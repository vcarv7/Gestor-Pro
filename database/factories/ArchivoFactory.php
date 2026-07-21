<?php

namespace Database\Factories;

use App\Models\Archivo;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArchivoFactory extends Factory
{
    protected $model = Archivo::class;

    public function definition(): array
    {
        return [
            'proyecto_id' => Proyecto::factory(),
            'user_id' => User::factory(),
            'nombre_original' => fake()->word() . '.' . fake()->fileExtension(),
            'nombre_storage' => fake()->uuid() . '.' . fake()->fileExtension(),
            'mime_type' => fake()->mimeType(),
            'tamano' => fake()->numberBetween(1024, 2097152),
            'descripcion' => fake()->optional()->sentence(),
        ];
    }
}
