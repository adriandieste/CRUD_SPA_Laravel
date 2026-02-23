<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::where('user_id', auth()->id())
            ->with('alumnos')
            ->get();

        return Inertia::render('Proyectos/Index', [
            'proyectos' => $proyectos,
        ]);
    }

    public function show(Proyecto $proyecto)
    {
        $this->authorize('view', $proyecto);

        return Inertia::render('Proyectos/Show', [
            'proyecto' => $proyecto->load('alumnos'),
        ]);
    }
}

