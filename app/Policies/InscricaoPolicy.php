<?php

namespace App\Policies;

use App\Models\Inscricao;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class InscricaoPolicy
{
     use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Inscricao');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inscricao $inscricao): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Inscricao');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inscricao $inscricao): bool
    {
       return $user->hasPermissionTo('Edit Inscricao');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inscricao $inscricao): bool
    {
        return $user->hasPermissionTo('Delete Inscricao');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inscricao $inscricao): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inscricao $inscricao): bool
    {
        //
    }
}
