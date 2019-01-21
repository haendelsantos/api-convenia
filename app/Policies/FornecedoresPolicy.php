<?php

namespace App\Policies;

use App\User;
use App\Fornecedor;
use Illuminate\Auth\Access\HandlesAuthorization;

class FornecedoresPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can show the Fornecedor.
     *
     * @param  \App\User  $user
     * @param  \App\Fornecedor  $Fornecedor
     * @return mixed
     */
    public function show(User $user, Fornecedor $fornecedores)
    {
        return $user->id === $fornecedores->user_id;
    }


    /**
     * Determine whether the user can update the Fornecedor.
     *
     * @param  \App\User  $user
     * @param  \App\Fornecedor  $fornecedores
     * @return mixed
     */
    public function update(User $user, Fornecedor $fornecedores)
    {
        return $user->id === $fornecedores->user_id;
    }

    /**
     * Determine whether the user can delete the Fornecedor.
     *
     * @param  \App\User  $user
     * @param  \App\Fornecedor  $fornecedores
     * @return mixed
     */
    public function delete(User $user, Fornecedor $fornecedores)
    {
        return $user->id === $fornecedores->user_id;
    }

}
