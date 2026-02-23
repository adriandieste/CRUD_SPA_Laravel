<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlumnoController extends Controller
{
    public function index(Proyecto $proyecto)
    {
        $this->authorize('view', $proyecto);

        $alumnos = $proyecto->alumnos()->paginate(10);

        return Inertia::render('Alumnos/Index', [
            'proyecto' => $proyecto,
            'alumnos' => $alumnos,
        ]);
    }

    public function store(Request $request, Proyecto $proyecto)
    {
        $this->authorize('view', $proyecto);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $proyecto->alumnos()->create($validated);

        return back();
    }

    public function update(Request $request, $proyecto, $alumno)
    {
        $proyecto = Proyecto::findOrFail($proyecto);
        $alumno = Alumno::findOrFail($alumno);
        
        $this->authorize('view', $proyecto);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos,email,' . $alumno->id,
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $alumno->update($validated);

        return back();
    }

    public function destroy($proyecto, $alumno)
    {
        $proyecto = Proyecto::findOrFail($proyecto);
        $alumno = Alumno::findOrFail($alumno);
        
        $this->authorize('view', $proyecto);

        $alumno->delete();

        return back();
    }
}

