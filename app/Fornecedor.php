<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Bridge\User;

class Fornecedor extends Model
{
    /**
     * Table name attribute
     *
     * @var string
     */
    protected $table = 'fornecedores';
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'mensalidade',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
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
