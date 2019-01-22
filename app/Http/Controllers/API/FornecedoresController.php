<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\User;
use App\Http\Requests\FornecedorStoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Libraries\Factory\FornecedorFactory;

class FornecedoresController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respond($this->fornecedoresCache());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fornecedor = $this->fornecedoresCache()->find($id);
        $this->authorize('show', $fornecedor);

        if ($fornecedor) {
            return $this->respond($fornecedor);
        }

        return $this->respondNotFound('Fornecedor not found!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorStoreRequest $request)
    {
        try {
            $fornecedor = User::find(Auth::user()->id)
                ->fornecedores()
                ->create($request->all());

            return $this->clearCache()->respond($fornecedor);
        } catch (\Exception $e) {
            return $this->respondInternalError('it was not possible to register');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedorUpdateRequest $request, $id)
    {
        $fornecedor = $this->fornecedoresCache()->find($id);
        $this->authorize('update', $fornecedor);

        try {
            $fornecedor->update($request->all());

            return $this->clearCache()->respond($fornecedor);
        } catch (\Exception $e) {
            return $this->respondInternalError('it was not possible to register');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fornecedor = $this->fornecedoresCache()->find($id);
        $this->authorize('delete', $fornecedor);

        if ($fornecedor) {
            $fornecedor->delete();

            return $this->clearCache()->respond(['message' => 'Fornecedor deleted!']);
        }

        return $this->respondInternalError('Fornecedor Not Found!');
    }

    /**
     * Retorna o total de mensalidades.
     */
    public function totalMensalidades()
    {
        try {
            $total = (new FornecedorFactory(Auth::user()->id))->totalMensalidades();

            return $this->respond(['total' => $total]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
    }

    /**
     * Fornecedores on cache.
     *
     * @return $this
     */
    protected function fornecedoresCache()
    {
        $minutes = Carbon::now()->addMinutes(10);

        return Cache::remember('api::fornecedores', $minutes, function () {
            return User::find(Auth::user()->id)->fornecedores;
        });
    }

    /**
     * Clear cache keys from api.
     *
     * @return $this
     */
    protected function clearCache()
    {
        Cache::forget('api::fornecedores');

        return $this;
    }
}
