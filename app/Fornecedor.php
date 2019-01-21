<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Bridge\User;

class Fornecedor extends Model
{
    const TABLE_NAME = 'fornecedores';
    const COLUMN_PRIMARY_KEY = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_EMAIL = 'email';
    const COLUMN_MENSALIDADE = 'mensalidade';
    const COLUMN_FOREIGN_KEY_USER = 'user_id';
    const COLUMN_CREATED_AT = 'created_at';
    const COLUMN_UPDATED_AT = 'updated_at';

    /**
     * Table name attribute
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_PRIMARY_KEY,
        self::COLUMN_NAME,
        self::COLUMN_EMAIL,
        self::COLUMN_MENSALIDADE,
        self::COLUMN_FOREIGN_KEY_USER,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::COLUMN_CREATED_AT,
        self::COLUMN_UPDATED_AT,
    ];
    /**
     * Return the user a
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
