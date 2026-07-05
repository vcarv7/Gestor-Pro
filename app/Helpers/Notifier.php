<?php

namespace App\Helpers;

use App\Models\User;

class Notifier
{
    protected static array $prefMap = [
        'password_change' => 'notify_password_change',
        'cliente_delete' => 'notify_cliente_delete',
        'proyecto_delete' => 'notify_proyecto_delete',
        'tarea_bulk_delete' => 'notify_tarea_bulk_delete',
    ];

    public static function notify(User $user, string $type, string $title, string $message, array $data = []): void
    {
        $pref = self::$prefMap[$type] ?? null;

        if ($pref && $user->relationLoaded('setting') ? optional($user->setting)->$pref === false : false) {
            return;
        }

        if ($pref && $user->setting && !$user->setting->$pref) {
            return;
        }

        $user->notifications()->create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data ?: null,
        ]);
    }
}
