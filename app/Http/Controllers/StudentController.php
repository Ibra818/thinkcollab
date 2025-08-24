<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        // Ici vous pouvez ajouter la logique pour récupérer les données du dashboard
        $courses = [
            ['title' => 'Développement Web', 'progress' => 75, 'instructor' => 'Marie Dupont'],
            ['title' => 'Laravel Avancé', 'progress' => 45, 'instructor' => 'Jean Martin'],
            ['title' => 'Design UI/UX', 'progress' => 30, 'instructor' => 'Sophie Bernard'],
        ];

        return view('student.dashboard', compact('courses'));
    }
}
