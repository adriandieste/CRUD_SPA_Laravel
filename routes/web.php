<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    Route::get('proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');

    Route::get('proyectos/{proyecto}/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::post('proyectos/{proyecto}/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');
    Route::put('proyectos/{proyecto}/alumnos/{alumno}', [AlumnoController::class, 'update'])->name('alumnos.update');
    Route::delete('proyectos/{proyecto}/alumnos/{alumno}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
});

require __DIR__.'/settings.php';

