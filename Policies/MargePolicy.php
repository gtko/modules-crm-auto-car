<?php

namespace Modules\CrmAutoCar\Policies;

use App\Models\User;
use Modules\CrmAutoCar\Models\Marge;
use Illuminate\Auth\Access\HandlesAuthorization;

class MargePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Marge $marge): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Marge $marge): bool
    {
        //
    }

    public function delete(User $user, Marge $marge): bool
    {
        //
    }

    public function restore(User $user, Marge $marge): bool
    {
        //
    }

    public function forceDelete(User $user, Marge $marge): bool
    {
        //
    }
}
