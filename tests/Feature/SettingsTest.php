<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_displays(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/ajustes');

        $response->assertOk();
    }

    public function test_profile_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/ajustes/profile', [
            'name' => 'Nuevo Nombre',
            'email' => $user->email,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nuevo Nombre']);
    }

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/ajustes/password', [
            'current_password' => 'password',
            'password' => 'NewPassword1!',
            'password_confirmation' => 'NewPassword1!',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('NewPassword1!', $user->fresh()->password));
    }

    public function test_password_update_requires_valid_current(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from('/ajustes')->put('/ajustes/password', [
            'current_password' => 'wrong-password',
            'password' => 'NewPassword1!',
            'password_confirmation' => 'NewPassword1!',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    public function test_notification_preferences_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/ajustes/notifications', [
            'notify_password_change' => false,
            'notify_cliente_delete' => true,
            'notify_proyecto_delete' => true,
            'notify_tarea_bulk_delete' => false,
        ]);

        $response->assertRedirect();
        $this->assertFalse($user->fresh()->setting->notify_password_change);
    }

    public function test_appearance_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/ajustes/appearance', [
            'dark_mode' => true,
        ]);

        $response->assertRedirect();
        $this->assertTrue($user->fresh()->setting->dark_mode);
    }

    public function test_account_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/ajustes/account', [
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertNull($user->fresh());
    }

    public function test_account_deletion_requires_valid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from('/ajustes')->delete('/ajustes/account', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
