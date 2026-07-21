<?php

namespace App\Policies;

use App\Models\User;

class AdministrationPolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function manage(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function viewAudit(User $user): bool
    {
        return $user->hasRole('super-admin');
    }
}
