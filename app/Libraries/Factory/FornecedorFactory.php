<?php namespace App\Libraries\Factory;

use App\Libraries\Factory\FornecedorInterface;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class FornecedorFactory implements FornecedorInterface
{
    protected $user;


    public function __construct(int $userId)
    {
        $this->user = $this->usersCache()->find($userId);
    }

    /**
     * Get Total
     *
     * @return void
     */
    public function totalMensalidades()
    {
        return $this->user->fornecedores->sum('mensalidade');
    }

    /**
     * Return all users in cache
     *
     * @return void
     */
    protected function usersCache()
    {
        $minutes = Carbon::now()->addMinutes(10);

        return Cache::remember('api::users', $minutes, function () {
            return User::all();
        });
    }
}
