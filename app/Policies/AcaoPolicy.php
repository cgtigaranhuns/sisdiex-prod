<?php

namespace App\Policies;

use App\Models\Acao;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class AcaoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Acao');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Acao $acao): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Acao');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Acao $acao): bool
    {
        return $user->hasPermissionTo('Edit Acao');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Acao $acao): bool
    {
        return $user->hasPermissionTo('Delete Acao');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Acao $acao): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Acao $acao): bool
    {
        //
    }
}
