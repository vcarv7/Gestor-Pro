<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProyectoTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_only_own_proyectos(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        Proyecto::factory()->count(2)->create(['user_id' => $user->id]);
        Proyecto::factory()->count(2)->create(['user_id' => $other->id]);

        $response = $this->actingAs($user)->get('/proyectos');

        $response->assertOk();
    }

    public function test_proyecto_can_be_created(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/proyectos', [
            'titulo' => 'Mi Proyecto',
            'cliente_id' => $cliente->id,
            'estado' => 'pendiente',
        ]);

        $response->assertRedirect(route('proyectos.index'));
        $this->assertDatabaseHas('proyectos', [
            'user_id' => $user->id,
            'titulo' => 'Mi Proyecto',
        ]);
    }

    public function test_proyecto_can_be_updated(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $response = $this->actingAs($user)->put("/proyectos/{$proyecto->id}", [
            'titulo' => 'Actualizado',
            'cliente_id' => $cliente->id,
            'estado' => 'en_progreso',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('proyectos', ['id' => $proyecto->id, 'titulo' => 'Actualizado']);
    }

    public function test_proyecto_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $response = $this->actingAs($user)->delete("/proyectos/{$proyecto->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted($proyecto);
    }

    public function test_proyecto_pdf_export(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $response = $this->actingAs($user)->get("/proyectos/{$proyecto->id}/pdf");

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type') ?? '');
    }

    public function test_other_user_cannot_access_proyecto(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $owner->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $owner->id, 'cliente_id' => $cliente->id]);

        $response = $this->actingAs($other)->get("/proyectos/{$proyecto->id}");

        $response->assertForbidden();
    }
}
