<?php namespace App\Libraries\Factory;

use App\User;

interface FornecedorInterface
{
    /**
     * userId needed to instantiate the class
     *
     * @param int $userId
     */
    public function __construct(int $userId);
    /**
     * Get total of mensalidades
     *
     * @return void
     */
    public function totalMensalidades();
}
