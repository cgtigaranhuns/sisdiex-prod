<?php

namespace App\Policies;

use App\Models\TipoAcao;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class TipoAcaoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return $user->hasPermissionTo('View TipoAcao');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TipoAcao $tipoAcao): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create TipoAcao');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TipoAcao $tipoAcao): bool
    {
        return $user->hasPermissionTo('Edit TipoAcao');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TipoAcao $tipoAcao): bool
    {
        return $user->hasPermissionTo('Delete TipoAcao');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TipoAcao $tipoAcao): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TipoAcao $tipoAcao): bool
    {
        //
    }
}
