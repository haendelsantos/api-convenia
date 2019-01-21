<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'cnpj' => 'required|unique:users,cnpj|int',
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
            'email.unique' => 'Email já cadastrado!',
            'password.required' => 'Password é uma informação obrigatória!',
            'cnpj.required' => 'CNPJ é uma informação obrigatória!',
            'cnpj.unique' => 'CNPJ já cadastrado!'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'email' => 'trim|lowercase',
            'name' => 'trim|capitalize|escape'
        ];
    }
}
