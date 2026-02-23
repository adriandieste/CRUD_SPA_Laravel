<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Proyecto;
use App\Models\Alumno;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create projects
        $project = Proyecto::factory()->create([
            'nombre' => 'Proyecto de Desarrollo Web',
            'descripcion' => 'Un proyecto para aprender Laravel y Vue.js',
            'user_id' => $user->id,
        ]);

        // Create students
        Alumno::factory(10)->create([
            'proyecto_id' => $project->id,
        ]);
    }
}

