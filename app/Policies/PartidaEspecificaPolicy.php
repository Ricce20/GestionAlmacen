<?php

namespace App\Policies;

use App\Models\PartidaEspecifica;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PartidaEspecificaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PartidaEspecifica $partidaEspecifica): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PartidaEspecifica $partidaEspecifica): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PartidaEspecifica $partidaEspecifica): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PartidaEspecifica $partidaEspecifica): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PartidaEspecifica $partidaEspecifica): bool
    {
        return $user->rol == 'Administrador' ?  true : false;

    }
}
