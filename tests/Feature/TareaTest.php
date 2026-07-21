<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TareaTest extends TestCase
{
    use RefreshDatabase;

    public function test_tarea_can_be_created(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);

        $response = $this->actingAs($user)->post("/proyectos/{$proyecto->id}/tareas", [
            'nombre' => 'Tarea de prueba',
            'prioridad' => 'media',
            'proyecto_id' => $proyecto->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tareas', [
            'proyecto_id' => $proyecto->id,
            'nombre' => 'Tarea de prueba',
        ]);
    }

    public function test_tarea_can_be_toggled_completed(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);
        $tarea = Tarea::factory()->create(['user_id' => $user->id, 'proyecto_id' => $proyecto->id, 'completada' => false]);

        $response = $this->actingAs($user)->put("/tareas/{$tarea->id}", [
            'nombre' => $tarea->nombre,
            'prioridad' => $tarea->prioridad,
            'completada' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tareas', ['id' => $tarea->id, 'completada' => true]);
    }

    public function test_tarea_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);
        $tarea = Tarea::factory()->create(['user_id' => $user->id, 'proyecto_id' => $proyecto->id]);

        $response = $this->actingAs($user)->delete("/tareas/{$tarea->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted($tarea);
    }

    public function test_complete_all_bulk_action(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);
        Tarea::factory()->count(3)->create(['user_id' => $user->id, 'proyecto_id' => $proyecto->id, 'completada' => false]);

        $response = $this->actingAs($user)->patch("/proyectos/{$proyecto->id}/tareas/complete-all");

        $response->assertRedirect();
        $this->assertEquals(0, Tarea::where('proyecto_id', $proyecto->id)->where('completada', false)->count());
    }

    public function test_destroy_all_bulk_action(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);
        Tarea::factory()->count(3)->create(['user_id' => $user->id, 'proyecto_id' => $proyecto->id]);

        $response = $this->actingAs($user)->delete("/proyectos/{$proyecto->id}/tareas/destroy-all");

        $response->assertRedirect();
        $this->assertEquals(3, Tarea::onlyTrashed()->where('proyecto_id', $proyecto->id)->count());
    }

    public function test_tarea_restore(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $user->id, 'cliente_id' => $cliente->id]);
        $tarea = Tarea::factory()->create(['user_id' => $user->id, 'proyecto_id' => $proyecto->id]);
        $tarea->delete();

        $response = $this->actingAs($user)->patch("/tareas/{$tarea->id}/restore");

        $response->assertRedirect();
        $this->assertNotSoftDeleted($tarea);
    }

    public function test_other_user_cannot_modify_tarea(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $owner->id]);
        $proyecto = Proyecto::factory()->create(['user_id' => $owner->id, 'cliente_id' => $cliente->id]);
        $tarea = Tarea::factory()->create(['user_id' => $owner->id, 'proyecto_id' => $proyecto->id]);

        $response = $this->actingAs($other)->put("/tareas/{$tarea->id}", [
            'nombre' => 'Hacked',
            'prioridad' => 'alta',
        ]);

        $response->assertForbidden();
    }
}
