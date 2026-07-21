<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->optional()->phoneNumber(),
            'empresa' => fake()->optional()->company(),
            'notas' => fake()->optional()->sentence(),
        ];
    }
}
