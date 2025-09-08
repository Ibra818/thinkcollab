<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'nom' => 'Toutes les categories',
                'slug' => '',
                'description' => '',
                'couleur' => '#3B82F6',
                'icone' => 'code',
            ],

            [
                'nom' => 'Développement Web',
                'slug' => 'developpement-web',
                'description' => 'Formations sur le développement web frontend et backend',
                'couleur' => '#3B82F6',
                'icone' => 'code',
            ],
            [
                'nom' => 'Mobile',
                'slug' => 'mobile',
                'description' => 'Développement d\'applications mobiles iOS et Android',
                'couleur' => '#10B981',
                'icone' => 'smartphone',
            ],
            [
                'nom' => 'Design',
                'slug' => 'design',
                'description' => 'UX/UI Design, graphisme et design d\'interfaces',
                'couleur' => '#F59E0B',
                'icone' => 'palette',
            ],
            [
                'nom' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Analyse de données, machine learning et intelligence artificielle',
                'couleur' => '#8B5CF6',
                'icone' => 'chart-bar',
            ],
            [
                'nom' => 'Cybersécurité',
                'slug' => 'cybersecurite',
                'description' => 'Sécurité informatique, ethical hacking et protection des données',
                'couleur' => '#EF4444',
                'icone' => 'shield',
            ],
            [
                'nom' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Déploiement, CI/CD, containerisation et infrastructure',
                'couleur' => '#06B6D4',
                'icone' => 'server',
            ],
            [
                'nom' => 'Marketing Digital',
                'slug' => 'marketing-digital',
                'description' => 'SEO, réseaux sociaux, publicité en ligne et analytics',
                'couleur' => '#EC4899',
                'icone' => 'megaphone',
            ],
            [
                'nom' => 'Entrepreneuriat',
                'slug' => 'entrepreneuriat',
                'description' => 'Création d\'entreprise, business model et gestion de projet',
                'couleur' => '#84CC16',
                'icone' => 'briefcase',
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}
