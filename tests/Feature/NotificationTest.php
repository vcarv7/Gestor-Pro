<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_can_be_marked_as_read(): void
    {
        $user = User::factory()->create();

        $notification = $user->notifications()->create([
            'type' => 'test',
            'title' => 'Test',
            'message' => 'Test message',
        ]);

        $response = $this->actingAs($user)->patch("/notificaciones/{$notification->id}/read");

        $response->assertRedirect();
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_all_notifications_can_be_marked_as_read(): void
    {
        $user = User::factory()->create();

        $user->notifications()->create(['type' => 'test', 'title' => 'A', 'message' => 'Msg A']);
        $user->notifications()->create(['type' => 'test', 'title' => 'B', 'message' => 'Msg B']);

        $response = $this->actingAs($user)->patch('/notificaciones/read-all');

        $response->assertRedirect();
        $this->assertEquals(0, $user->notifications()->unread()->count());
    }

    public function test_recent_endpoint_returns_json(): void
    {
        $user = User::factory()->create();

        $user->notifications()->create(['type' => 'test', 'title' => 'Test', 'message' => 'Msg']);

        $response = $this->actingAs($user)->get('/notificaciones/recent');

        $response->assertOk();
        $response->assertJsonStructure(['unread_count', 'recent']);
    }

    public function test_index_displays_paginated_notifications(): void
    {
        $user = User::factory()->create();

        $user->notifications()->create(['type' => 'test', 'title' => 'Notif 1', 'message' => 'Msg']);
        $user->notifications()->create(['type' => 'test', 'title' => 'Notif 2', 'message' => 'Msg']);

        $response = $this->actingAs($user)->get('/notificaciones');

        $response->assertOk();
        $response->assertSee('Notif 1');
    }

    public function test_other_user_cannot_mark_others_notification(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $notification = $owner->notifications()->create([
            'type' => 'test',
            'title' => 'Privado',
            'message' => 'Privado',
        ]);

        $response = $this->actingAs($other)->patch("/notificaciones/{$notification->id}/read");

        $response->assertForbidden();
    }
}
