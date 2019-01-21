<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'unique:users,email',
            'cnpj' => 'unique:users,cnpj|int',
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
            'email.unique' => 'Email já cadastrado!',
            'cnpj.unique' => 'CNPJ já cadastrado!'
        ];
    }
}
