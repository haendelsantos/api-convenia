<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Fornecedor;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Table name attribute
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'cep',
        'cnpj',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];
    /**
     * Custom create user
     *
     * @param array $values
     * @return void
     */
    public function createUser($values)
    {
        $values['password'] = Hash::make($values['password']);
        return User::create($values);
    }
    /**
     * Relationship users with fornecedores
     *
     * @return void
     */
    public function fornecedores()
    {
        return $this->hasMany(
            Fornecedor::class,
            'user_id',
            'id'
        );
    }
}
