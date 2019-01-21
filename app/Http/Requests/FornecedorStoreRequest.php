<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'mensalidade' => 'required|int'
        ];
    }

    /**
     * Message For the requirements
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name é uma informação obrigatória!',
            'email.required' => 'Email é uma informação obrigatória!',
            'mensalidade.required' => 'Mensalidade é uma informação obrigatória!',
            'mensalidade.int' => 'Mensalidade deve ser um valor numérico!'
        ];
    }
}
