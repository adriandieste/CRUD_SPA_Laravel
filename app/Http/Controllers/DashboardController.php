<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get user's projects with student count
        $proyectos = $user->proyectos()
            ->withCount('alumnos')
            ->get();
        
        // Get all students for user's projects
        $alumnos = $user->proyectos()
            ->with('alumnos')
            ->get()
            ->flatMap->alumnos;
        
        return Inertia::render('Dashboard', [
            'proyectos' => $proyectos,
            'alumnos' => $alumnos,
            'stats' => [
                'total_proyectos' => $proyectos->count(),
                'total_alumnos' => $alumnos->count(),
            ],
        ]);
    }
}
