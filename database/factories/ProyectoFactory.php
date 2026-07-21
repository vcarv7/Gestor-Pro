<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cliente_id' => Cliente::factory(),
            'titulo' => fake()->sentence(3),
            'descripcion' => fake()->optional()->paragraph(),
            'fecha_inicio' => fake()->optional()->date(),
            'fecha_entrega' => fake()->optional()->date(),
            'estado' => fake()->randomElement(['pendiente', 'en_progreso', 'completado', 'cancelado']),
        ];
    }
}
