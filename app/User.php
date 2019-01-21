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

    const TABLE_NAME = 'users';
    const COLUMN_PRIMARY_KEY = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_EMAIL = 'email';
    const COLUMN_PASSWORD = 'password';
    const COLUMN_REMEMBER_TOKEN = 'remember_token';
    const COLUMN_PHONE = 'phone';
    const COLUMN_ADDRESS = 'address';
    const COLUMN_CEP = 'cep';
    const COLUMN_CNPJ = 'cnpj';
    const COLUMN_CREATED_AT = 'created_at';
    const COLUMN_UPDATED_AT = 'updated_at';

    /**
     * Table name attribute
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_PRIMARY_KEY,
        self::COLUMN_NAME,
        self::COLUMN_EMAIL,
        self::COLUMN_PASSWORD,
        self::COLUMN_PHONE,
        self::COLUMN_ADDRESS,
        self::COLUMN_CEP,
        self::COLUMN_CNPJ
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::COLUMN_PASSWORD,
        self::COLUMN_REMEMBER_TOKEN,
        self::COLUMN_CREATED_AT,
        self::COLUMN_UPDATED_AT
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
        return $this->hasMany(Fornecedor::class,Fornecedor::COLUMN_FOREIGN_KEY_USER,self::COLUMN_PRIMARY_KEY);
    }

}
