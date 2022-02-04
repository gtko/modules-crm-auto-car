<?php

namespace Modules\CrmAutoCar\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list payments');
    }

    public function view(UserEntity $user, Payment $model)
    {
        return $user->hasPermissionTo('views payments');
    }

    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create payments');
    }

    public function update(UserEntity $user, Payment $model)
    {
        return $user->hasPermissionTo('update payments');
    }

    public function delete(UserEntity $user)
    {
        return $user->hasPermissionTo('delete payments');
    }

    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete payments');
    }

    public function restore(UserEntity $user, Payment $model)
    {
        return false;
    }

    public function forceDelete(UserEntity $user, Payment $model)
    {
        return false;
    }
}
