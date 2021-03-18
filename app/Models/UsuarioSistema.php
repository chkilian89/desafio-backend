<?php

namespace App\Models;

use App\Models\BaseModel;

class UsuarioSistema extends BaseModel
{
    const ID_USER_ADMIN = 1;

    protected $table = "usuario_sistema";
    protected $primaryKey = "usu_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usu_id',
        'usu_nome',
        'usu_username',
        'usu_documento',
        'usu_email',
        'usu_senha',
        'usu_data_criacao',
        'usu_ultimo_acesso',
        'per_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'usu_senha'
    ];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('usu_ativo', 1);
    }
}
