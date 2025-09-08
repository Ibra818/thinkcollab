<?php

namespace App\Http\Controllers;

use App\Models\{LessonVideo, FeedVideo, Formation};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class LessonVideoController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Formation $formation): JsonResponse
    {
        $this->authorize('viewLessons', $formation);
        
        $videos = $formation->lessonVideos()->orderBy('ordre')->get();
        return response()->json($videos);
    }

    public function store(Request $request, Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);

        // $validated = $request->validate([
        //     'titre' => 'required|string|max:255',
        //     'url_video' => 'required|string|max:255',
        //     'ordre' => 'required|integer|min:1',
        //     'duree' => 'required|integer|min:1',
        // ]);

        foreach( $request -> allFiles() as $key => $file){

                $index = str_replace('module-file-', '', $key);
                $namekey = "module-name-" .$index; 
                
                $lessonName = $request -> input($namekey);
                $path = $file->store('lessons', 'public');

                $lesson = LessonVideo::create(
                    [
                        'titre' => $lessonName? $lessonName : 'Sans titre',
                        'url_video' => '/'.$path,  
                        'ordre' => 1,
                        'duree' =>  900,
                        'formation_id' => $request -> id,
                    ]);
            }

        return response() -> json(['success' => 'Modules ajoutées avec success']);
        // $video = LessonVideo::create($validated);
        // return response()->json($video, 201);
    }

    public function show(LessonVideo $lessonVideo): JsonResponse
    {
        $this->authorize('view', $lessonVideo);
        
        return response()->json($lessonVideo->load('formation'));
    }

    public function update(Request $request, LessonVideo $lessonVideo): JsonResponse
    {
        $this->authorize('update', $lessonVideo->formation);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:255',
            'ordre' => 'sometimes|integer|min:1',
            'duree' => 'sometimes|integer|min:1',
        ]);

        $lessonVideo->update($validated);
        return response()->json($lessonVideo);
    }

    public function destroy(LessonVideo $lessonVideo): JsonResponse
    {
        $this->authorize('update', $lessonVideo->formation);
        
        $lessonVideo->delete();
        return response()->json(['message' => 'Vidéo supprimée avec succès']);
    }

    public function reorder(Request $request, Formation $formation): JsonResponse
    {
        $this->authorize('update', $formation);

        $validated = $request->validate([
            'videos' => 'required|array',
            'videos.*.id' => 'required|exists:lesson_videos,id',
            'videos.*.ordre' => 'required|integer|min:1',
        ]);

        foreach ($validated['videos'] as $videoData) {
            LessonVideo::where('id', $videoData['id'])
                      ->where('formation_id', $formation->id)
                      ->update(['ordre' => $videoData['ordre']]);
        }

        return response()->json(['message' => 'Ordre des vidéos mis à jour avec succès']);
    }
}
