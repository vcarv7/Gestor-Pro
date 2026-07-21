<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_finds_clientes(): void
    {
        $user = User::factory()->create();
        Cliente::factory()->create(['user_id' => $user->id, 'nombre' => 'Carlos Pérez']);

        $response = $this->actingAs($user)->get('/buscar?q=Carlos');

        $response->assertOk();
        $response->assertJsonPath('results.0.title', 'Carlos Pérez');
    }

    public function test_search_finds_proyectos(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->create(['user_id' => $user->id, 'titulo' => 'App Web']);

        $response = $this->actingAs($user)->get('/buscar?q=App');

        $response->assertOk();
        $response->assertJsonPath('results.0.title', 'App Web');
    }

    public function test_search_finds_tareas(): void
    {
        $user = User::factory()->create();
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id]);
        Tarea::factory()->create(['user_id' => $user->id, 'proyecto_id' => $proyecto->id, 'nombre' => 'Diseñar login']);

        $response = $this->actingAs($user)->get('/buscar?q=login');

        $response->assertOk();
        $response->assertJsonPath('results.0.title', 'Diseñar login');
    }

    public function test_search_returns_empty_for_short_query(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/buscar?q=a');

        $response->assertOk();
        $response->assertJsonCount(0, 'results');
    }

    public function test_search_does_not_include_other_users_data(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Cliente::factory()->create(['user_id' => $other->id, 'nombre' => 'Usuario Oculto']);

        $response = $this->actingAs($user)->get('/buscar?q=Oculto');

        $response->assertOk();
        $response->assertJsonCount(0, 'results');
    }
}
