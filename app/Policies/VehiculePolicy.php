<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Auth\Access\Response;

class VehiculePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin','manager']);
    }

    public function view(User $user, Vehicule $vehicule)
    {
        return $user->hasAnyRole(['admin','manager']);
    }

public function create(User $user)
{
    return $user->hasRole('admin');
}

public function update(User $user)
{
    return $user->hasAnyRole(['admin','manager']);
}

public function delete(User $user)
{
    return $user->hasRole('admin');
}
}
