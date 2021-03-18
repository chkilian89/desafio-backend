<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuarioMakeLogin extends Authenticatable
{
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
        'usu_senha',
        'usu_criado_em',
        'usu_atualizado_em',
        'usu_excluido_em',
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

    public function set($data)
    {
        if(!empty($data)){
            foreach($data as $key => $val){
                $this->{$key} = $val;
            }
        }
        return $this;
    }

    public function getRememberToken()
    {
        return null; // not supported
    }

    public function setRememberToken($value)
    {
        // not supported
    }

    public function getRememberTokenName()
    {
        return null; // not supported
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
}
