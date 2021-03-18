<?php

namespace App\Modules\Login\Request;

use App\Models\UsuarioSistema;
use App\Request\BaseRequest;
use Illuminate\Validation\Rule;
use Validator;

class ManageLoginRequest extends BaseRequest
{
    public function __construct()
    {
        parent::__construct();

        Validator::extend('check_is_user_valid', function ($attribute, $value, $parameters, $validator) {
            $username = (string)$parameters[0];
            $senha = (string)$parameters[1];

            if ($this->checkIsUserValid($username, $senha)) {
                return true;
            }

            return false;
        });
    }
    private function checkIsUserValid(string $username, string $senha)
    {
        return UsuarioSistema::where(function($w)use($username, $senha){
            $w->where('usu_username',$username);
            $w->where('usu_senha',$senha);
        })->exists();
    }
    public function rules()
    {
        return [
            'usu_username' => "required|string|max:156|check_is_user_valid:{$this->usu_username},{$this->usu_senha}",
            'usu_senha' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'usu_senha' => 'SENHA',
            'usu_username' => 'USUÁRIO',
        ];
    }

    public function messages()
    {
        return[
            'check_is_user_valid' => 'Usuário ou senha inválido',
        ];
    }

}
