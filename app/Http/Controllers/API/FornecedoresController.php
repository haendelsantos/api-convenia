<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fornecedor;
use App\Http\Controllers\ApiController;
use App\User;
use App\Http\Requests\FornecedorStoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;
use App\Libraries\Factory\FornecedorFactory;

class FornecedoresController extends ApiController
{
    /**
     * Clear cache keys from api
     *
     * @return void
     */
    protected function clearCache()
    {
        Cache::forget('api::fornecedores');
        Cache::forget('api::totalMensalidades');
        return $this;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $minutes = Carbon::now()->addMinutes(10);

        $fornecedores = Cache::remember('api::fornecedores',$minutes,function(){
            return User::find(Auth::user()->id)->fornecedores;
        });

        return $this->respond($fornecedores);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::find($id);
        $this->authorize('show',$fornecedor);

        if($fornecedor){
            return $this->respond($fornecedor);
        }

        return $this->respondNotFound('Fornecedor not found!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorStoreRequest $request)
    {
        try{

            $fornecedor = User::find(Auth::user()->id)
                ->fornecedores()
                ->create($request->all());

            return $this->clearCache()
                ->respond($fornecedor);
        }catch(\Exception $e){

            return $this->respondInternalError('it was not possible to register');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::find($id);
        $this->authorize('update',$fornecedor);

        try{

            $fornecedor->update($request->all());

            return $this->clearCache()
                ->respond($fornecedor);
        }catch(\Exception $e){

            return $this->respondInternalError('it was not possible to register');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($fornecedorId)
    {
        $fornecedor =  Fornecedor::find($fornecedorId);
        $this->authorize('delete',$fornecedor);

        if($fornecedor){

            $fornecedor->delete();

            return $this->clearCache()
                ->respond(['message' =>'Fornecedor deleted!']);
        }

        return $this->respondInternalError('Fornecedor Not Found!');
    }
    /**
     * Retorna o total de mensalidades
     *
     * @return void
     */
    public function totalMensalidades()
    {
        try{
            
            $minutes = Carbon::now()->addMinutes(10);

            $total = Cache::remember('api::totalMensalidades',$minutes,function(){

                return (new FornecedorFactory())
                    ->totalMensalidades(User::find(Auth::user()->id));
            });

            return $this->respond(['total' => $total]);
        }catch(\Exception $e){
            return $this->respondInternalError();
        }
    }
}
