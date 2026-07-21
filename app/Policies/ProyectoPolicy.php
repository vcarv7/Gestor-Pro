<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\User;

class ProyectoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->user_id === $user->id;
    }

    public function delete(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->user_id === $user->id;
    }

    public function restore(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->user_id === $user->id;
    }

    public function forceDelete(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->user_id === $user->id;
    }

    public function exportPdf(User $user, Proyecto $proyecto): bool
    {
        return $proyecto->user_id === $user->id;
    }
}
