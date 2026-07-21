<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'proyecto_id' => Proyecto::factory(),
            'nombre' => fake()->sentence(4),
            'descripcion' => fake()->optional()->paragraph(),
            'fecha_limite' => fake()->optional()->date(),
            'prioridad' => fake()->randomElement(['baja', 'media', 'alta']),
            'completada' => fake()->boolean(30),
        ];
    }
}
