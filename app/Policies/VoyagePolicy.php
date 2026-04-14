<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Voyage;
use Illuminate\Auth\Access\Response;

class VoyagePolicy
{
   public function viewAny(User $user)
{
    return true;
}

public function create(User $user)
{
    return $user->hasAnyRole(['agent','manager']);
}
}
