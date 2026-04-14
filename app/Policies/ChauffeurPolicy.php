<?php

namespace App\Policies;

use App\Models\Chauffeur;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChauffeurPolicy
{
    public function viewAny(User $user)
{
    return $user->hasAnyRole(['admin','manager','agent']);
}

public function create(User $user)
{
    return $user->hasAnyRole(['admin','manager']);
}

public function update(User $user)
{
    return $user->hasAnyRole(['admin','manager']);
}
}
