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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        auth()->user()->proyectos()->create($validated);

        return back();
    }

    public function show(Proyecto $proyecto)
    {
        $this->authorize('view', $proyecto);

        return Inertia::render('Proyectos/Show', [
            'proyecto' => $proyecto->load('alumnos'),
        ]);
    }

    public function update(Request $request, $proyecto)
    {
        $proyecto = Proyecto::findOrFail($proyecto);
        $this->authorize('view', $proyecto);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto->update($validated);

        return back();
    }

    public function destroy($proyecto)
    {
        $proyecto = Proyecto::findOrFail($proyecto);
        $this->authorize('view', $proyecto);

        $proyecto->delete();

        return back();
    }
}


