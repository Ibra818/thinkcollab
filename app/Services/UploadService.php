<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    /**
     * Upload une image avec compression si possible
     */
    public function uploadImage(UploadedFile $file, string $path = 'images', int $quality = 85): string
    {
        $filename = uniqid() . '.jpg';
        $fullPath = $path . '/' . $filename;
        
        // Vérifier si GD est disponible pour la compression
        if (extension_loaded('gd')) {
            try {
                // Compression avec GD natif
                $this->compressImageWithGD($file, $path, $filename, $quality);
            } catch (\Exception $e) {
                // Fallback: stocker sans compression
                $file->storeAs($path, $filename, 'public');
            }
        } else {
            // Pas de GD disponible, stocker sans compression
            $file->storeAs($path, $filename, 'public');
        }
        
        return '/' . $fullPath;
    }
    
    /**
     * Compression d'image avec GD natif
     */
    private function compressImageWithGD(UploadedFile $file, string $path, string $filename, int $quality): void
    {
        $sourcePath = $file->getPathname();
        $targetPath = storage_path('app/public/' . $path . '/' . $filename);
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists(dirname($targetPath))) {
            mkdir(dirname($targetPath), 0755, true);
        }
        
        // Obtenir les dimensions de l'image source
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            throw new \Exception('Impossible de lire l\'image source');
        }
        
        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Calculer les nouvelles dimensions (max 800x600)
        $maxWidth = 800;
        $maxHeight = 600;
        
        $ratio = min($maxWidth / $sourceWidth, $maxHeight / $sourceHeight);
        $newWidth = (int)($sourceWidth * $ratio);
        $newHeight = (int)($sourceHeight * $ratio);
        
        // Créer l'image source selon le type
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \Exception('Type d\'image non supporté pour la compression');
        }
        
        if (!$sourceImage) {
            throw new \Exception('Impossible de créer l\'image source');
        }
        
        // Créer l'image de destination
        $destImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Préserver la transparence pour PNG
        if ($mimeType === 'image/png') {
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
            $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
            imagefilledrectangle($destImage, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Redimensionner l'image
        imagecopyresampled(
            $destImage, $sourceImage,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $sourceWidth, $sourceHeight
        );
        
        // Sauvegarder l'image compressée
        imagejpeg($destImage, $targetPath, $quality);
        
        // Libérer la mémoire
        imagedestroy($sourceImage);
        imagedestroy($destImage);
    }

    /**
     * Upload une vidéo avec validation
     */
    public function uploadVideo(UploadedFile $file, string $path = 'videos'): string
    {
        // Validation du type MIME
        $allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/mkv', 'video/webm'];
        if (!in_array($file->getClientMimeType(), $allowedTypes)) {
            throw new \InvalidArgumentException('Type de fichier vidéo non supporté');
        }

        // Validation de la taille (500MB max)
        if ($file->getSize() > 500 * 1024 * 1024) {
            throw new \InvalidArgumentException('Fichier trop volumineux (max 500MB)');
        }

        $videoPath = $file->store($path, 'public');
        return '/' . $videoPath;
    }

    /**
     * Génère une miniature pour une vidéo
     */
    public function generateVideoThumbnail(string $videoPath, int $timeOffset = 5): string
    {
        // Cette fonction nécessiterait FFmpeg pour extraire une frame
        // Pour l'instant, on retourne un placeholder
        return '/images/video-placeholder.jpg';
    }

    /**
     * Optimise les paramètres d'upload
     */
    public function getOptimizedSettings(): array
    {
        return [
            'max_file_size' => config('upload.max_file_size', 512000), // 500MB
            'max_image_size' => config('upload.max_image_size', 51200), // 50MB
            'chunk_size' => config('upload.chunk_size', 1024 * 1024),
            'timeout' => config('upload.timeout', 300),
        ];
    }
}
