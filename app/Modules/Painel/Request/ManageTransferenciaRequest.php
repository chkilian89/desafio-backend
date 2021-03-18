<?php

namespace App\Modules\Painel\Request;

use App\Models\Carteira;
use App\Request\BaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

class ManageTransferenciaRequest extends BaseRequest
{
    public function __construct()
    {
        parent::__construct();

        Validator::extend('checkIsWallet', function ($attribute, $value, $parameters, $validator) {
            $userId = (int)$parameters[0];
            $valorRetirado = (double)$parameters[1];

            $valorCarteira = $this->checkIsWallet($userId);

            if ( ($valorCarteira->valor - $valorRetirado) < (double)0 ) {
                return false;
            }

            return true;
        });
    }
    private function checkIsWallet(string $userId)
    {
        return Carteira::select(
            'usr.usu_id AS usu_id',
            'usr.usu_nome AS usu_nome',
            DB::raw(
               '( select sum(b.valor) AS total_valor from carteira b where b.user_from = carteira.user_from
                ) AS valor'
            )
        )
        ->join('usuario_sistema as usr', 'usr.usu_id', '=', 'carteira.user_from')
        ->where('carteira.user_from', $userId)
        ->whereNull('carteira.user_to')
        ->first();
    }
    public function rules()
    {
        return [
            'value' => "required|string|max:156|checkIsWallet:{$this->payer},{$this->value}",
            'payer' => 'required',//pagador
            'payee' => 'required',//recebedor
        ];
    }

    // public function attributes()
    // {
    //     return [
    //         'usu_senha' => 'SENHA',
    //         'usu_username' => 'USUÁRIO',
    //     ];
    // }

    public function messages()
    {
        return[
            'check_is_wallet' => 'Saldo insuficiente.',
        ];
    }

}
