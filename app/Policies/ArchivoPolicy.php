<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Archivo;
use App\Models\User;

class ArchivoPolicy
{
    public function view(User $user, Archivo $archivo): bool
    {
        return $archivo->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Archivo $archivo): bool
    {
        return $archivo->user_id === $user->id;
    }

    public function delete(User $user, Archivo $archivo): bool
    {
        return $archivo->user_id === $user->id;
    }

    public function restore(User $user, Archivo $archivo): bool
    {
        return $archivo->user_id === $user->id;
    }

    public function forceDelete(User $user, Archivo $archivo): bool
    {
        return $archivo->user_id === $user->id;
    }

    public function download(User $user, Archivo $archivo): bool
    {
        return $archivo->user_id === $user->id;
    }
}
