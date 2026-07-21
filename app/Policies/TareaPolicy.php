<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Tarea;
use App\Models\User;

class TareaPolicy
{
    public function view(User $user, Tarea $tarea): bool
    {
        return $tarea->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Tarea $tarea): bool
    {
        return $tarea->user_id === $user->id;
    }

    public function delete(User $user, Tarea $tarea): bool
    {
        return $tarea->user_id === $user->id;
    }

    public function restore(User $user, Tarea $tarea): bool
    {
        return $tarea->user_id === $user->id;
    }

    public function forceDelete(User $user, Tarea $tarea): bool
    {
        return $tarea->user_id === $user->id;
    }
}
