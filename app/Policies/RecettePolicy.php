<?php

namespace App\Policies;

use App\Models\RecetteMensuelle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecettePolicy
{
   public function viewAny(User $user)
{
    return $user->hasAnyRole(['admin','comptable']);
}

public function create(User $user)
{
    return $user->hasRole('comptable');
}
}
