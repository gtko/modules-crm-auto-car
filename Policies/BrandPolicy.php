<?php

namespace Modules\CrmAutoCar\Policies;

use App\Models\User;
use App\Models\Brand;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;

class BrandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the brand can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list brands');
    }

    /**
     * Determine whether the brand can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Brand  $model
     * @return mixed
     */
    public function view(UserEntity $user, Brand $model)
    {
        return $user->hasPermissionTo('view brands');
    }

    /**
     * Determine whether the brand can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create brands');
    }

    /**
     * Determine whether the brand can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Brand  $model
     * @return mixed
     */
    public function update(UserEntity $user, Brand $model)
    {
        return $user->hasPermissionTo('update brands');
    }

    /**
     * Determine whether the brand can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Brand  $model
     * @return mixed
     */
    public function delete(UserEntity $user, Brand $model)
    {
        return $user->hasPermissionTo('delete brands');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Brand  $model
     * @return mixed
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete brands');
    }

    /**
     * Determine whether the brand can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Brand  $model
     * @return mixed
     */
    public function restore(UserEntity $user, Brand $model)
    {
        return false;
    }

    /**
     * Determine whether the brand can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Brand  $model
     * @return mixed
     */
    public function forceDelete(UserEntity $user, Brand $model)
    {
        return false;
    }
}
