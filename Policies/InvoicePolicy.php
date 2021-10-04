<?php

namespace Modules\CrmAutoCar\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CrmAutoCar\Models\Invoice;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list invoices');
    }

    public function view(UserEntity $user, Invoice $model)
    {
        return $user->hasPermissionTo('views invoices');
    }

    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create invoices');
    }

    public function update(UserEntity $user, Invoice $model)
    {
        return $user->hasPermissionTo('update invoices');
    }

    public function delete(UserEntity $user, Invoice $model)
    {
        return $user->hasPermissionTo('delete invoices');
    }

    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete invoices');
    }

    public function restore(UserEntity $user, Invoice $model)
    {
        return false;
    }

    public function forceDelete(UserEntity $user, Invoice $model)
    {
        return false;
    }
}
