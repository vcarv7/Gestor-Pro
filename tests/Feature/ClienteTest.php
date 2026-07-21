<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_only_own_clientes(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        Cliente::factory()->count(3)->create(['user_id' => $user->id]);
        Cliente::factory()->count(2)->create(['user_id' => $other->id]);

        $response = $this->actingAs($user)->get('/clientes');

        $response->assertOk();
        $response->assertSee($user->clientes()->first()->nombre);
    }

    public function test_create_form_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/clientes/create');

        $response->assertOk();
    }

    public function test_cliente_can_be_created(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/clientes', [
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
        ]);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', [
            'user_id' => $user->id,
            'email' => 'juan@example.com',
        ]);
    }

    public function test_cliente_requires_nombre(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/clientes', [
            'nombre' => '',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    public function test_cliente_requires_unique_email(): void
    {
        $user = User::factory()->create();
        Cliente::factory()->create(['user_id' => $user->id, 'email' => 'dup@example.com']);

        $response = $this->actingAs($user)->post('/clientes', [
            'nombre' => 'Otro',
            'email' => 'dup@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_cliente_can_be_updated(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put("/clientes/{$cliente->id}", [
            'nombre' => 'Nuevo Nombre',
            'email' => $cliente->email,
        ]);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'nombre' => 'Nuevo Nombre']);
    }

    public function test_cliente_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/clientes/{$cliente->id}");

        $response->assertRedirect(route('clientes.index'));
        $this->assertSoftDeleted($cliente);
    }

    public function test_cliente_can_be_restored(): void
    {
        $user = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $user->id]);
        $cliente->delete();

        $response = $this->actingAs($user)->patch("/clientes/{$cliente->id}/restore");

        $response->assertRedirect();
        $this->assertNotSoftDeleted($cliente);
    }

    public function test_other_user_cannot_access_cliente(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $cliente = Cliente::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->get("/clientes/{$cliente->id}");

        $response->assertForbidden();
    }
}
