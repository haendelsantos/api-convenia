<?php namespace App\Libraries\Factory;

use App\Libraries\Factory\FornecedorInterface;
use App\User;

class FornecedorFactory implements FornecedorInterface
{
    /**
     * User intance
     *
     * @var User
     */
    protected $user;

    /**
     * Get Total
     *
     * @return void
     */
    public function totalMensalidades(User $user)
    {
        return $user->fornecedores->sum('mensalidade');
    }
}