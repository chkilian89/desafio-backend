<?php

namespace App\Modules\Login\Request;

use App\Request\BaseRequest;
use Illuminate\Validation\Rule;

class ManageUserRegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'usu_nome' => 'required|string|max:156',
            'usu_email' => "required|string|email|max:156|".Rule::unique('usuario_sistema','usu_email')->ignore($this->usu_id, 'usu_id'),
            'usu_username' => "required|string|max:156|".Rule::unique('usuario_sistema', 'usu_username')->ignore($this->usu_id, 'usu_id'),
            'usu_documento' => "required|integer|".Rule::unique('usuario_sistema', 'usu_documento')->ignore($this->usu_id, 'usu_id'),
            'usu_senha' => 'required|string|min:6',
            'per_id' => 'required|exists:perfil'
        ];
    }

    public function attributes()
    {
        return [
            'usu_nome' => 'NOME',
            'usu_email' => 'E-MAIL',
            'usu_documento' => 'DOCUMENTO',
            'usu_senha' => 'SENHA',
            'usu_username' => 'USUÁRIO',
        ];
    }
    // public function messages()
    // {
    //     return[
    //         'ur_nome' => 'Nome',
    //         'ur_cpf'  => 'CPF',
    //         'ur_rg' => 'RG',
    //         'un_id' => 'Idenficador do Cliente'
    //     ];
    // }

}
