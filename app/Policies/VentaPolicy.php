<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;
use Illuminate\Auth\Access\HandlesAuthorization;

class VentaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venta  $venta
     * @return mixed
     */
    public function view(User $user, Venta $venta)
    {
        $permiso = $user->getPermiso('venta');
        return $user->isAdmin() || (isset($permiso->permisos) && $permiso->permisos->visualizar);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permiso = $user->getPermiso('venta');
        return $user->isAdmin() || (isset($permiso->permisos) && $permiso->permisos->crear);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venta  $venta
     * @return mixed
     */
    public function update(User $user, Venta $venta)
    {
        $permiso = $user->getPermiso('venta');
        return $user->isAdmin() || (isset($permiso->permisos) && $permiso->permisos->modificar);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venta  $venta
     * @return mixed
     */
    public function delete(User $user, Venta $venta)
    {
        $permiso = $user->getPermiso('venta');
        return $user->isAdmin() || (isset($permiso->permisos) && $permiso->permisos->eliminar);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venta  $venta
     * @return mixed
     */
    public function restore(User $user, Venta $venta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venta  $venta
     * @return mixed
     */
    public function forceDelete(User $user, Venta $venta)
    {
        //
    }
}
