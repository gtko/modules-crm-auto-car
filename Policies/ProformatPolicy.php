<?php

namespace Modules\CrmAutoCar\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CrmAutoCar\Models\Proformat;

class ProformatPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list proformats');
    }

    public function view(UserEntity $user, Proformat $model = null)
    {
        return $user->hasPermissionTo('views proformats');
    }

    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create proformats');
    }

    public function update(UserEntity $user, Proformat $model)
    {
        return $user->hasPermissionTo('update proformats');
    }

    public function delete(UserEntity $user, Proformat $model)
    {
        return $user->hasPermissionTo('delete proformats');
    }

    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete proformats');
    }

    public function restore(UserEntity $user, Proformat $model)
    {
        return false;
    }

    public function forceDelete(UserEntity $user, Proformat $model)
    {
        return false;
    }
}
