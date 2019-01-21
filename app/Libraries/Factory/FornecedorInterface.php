<?php namespace App\Libraries\Factory;

use App\User;

interface FornecedorInterface {

    /**
     * Get total of mensalidades
     *
     * @return void
     */
    public function totalMensalidades(User $user);
}