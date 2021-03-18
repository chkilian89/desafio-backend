<?php

namespace App\Services\Painel;

use App\Api\CurlMaker;
use App\Converters\Painel\PainelConverter;
use App\Events\UsuarioRecebeuPagamento;
use App\Exceptions\NegocioException;
use App\Models\Carteira;
use App\Models\Funcionalidade;
use App\Models\Notification;
use App\Models\TipoAcao;
use App\Models\UsuarioMakeLogin;
use App\Models\UsuarioSistema;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PainelService extends BaseService
{
    /**
     * responsible to set a system session with Auth
     * @param @data array [
     *  'usu_username'=>string
     *  'usu_senha'=>string
     * ]
     * @return mixed between NegocioException or string
     */
    public function getInfoUser(array $data)
    {
        return [
            "historico" => PainelConverter::formatHistorico($this->getHistoricByUser(Auth::user()->usu_id)),
            "carteira" => $this->getInfoCarteira(Auth::user()->usu_id),
            "usuarios" => UsuarioSistema::select(
                'usu_id',
                DB::raw("CASE WHEN per_id = 1 THEN CONCAT(usu_nome, ' (Lojista)') ELSE usu_nome END AS usu_nome")
            )->where('usu_ativo', 1)->whereNotIn('usu_id', [Auth::user()->usu_id])->get()->toArray()
        ];
    }

    public function getHistoricByUser(int $userId)
    {
        return Carteira::select(
            "cat_id",
            "user_from.usu_id AS user_id_from",
            "user_from.usu_nome AS user_nome_from",
            "user_to.usu_id AS user_id_to",
            "user_to.usu_nome AS user_nome_to",
            "tipo_acao.tp_id",
            "tipo_acao.tp_descricao",
            "valor",
            'carteira.created_at'
        )
        ->join('tipo_acao', function($j){
            $j->on('tipo_acao.tp_id', '=', 'carteira.tp_id');
        })
        ->leftJoin('usuario_sistema as user_from', function($j){
            $j->on('user_from.usu_id', '=', 'carteira.user_from');
        })
        ->leftJoin('usuario_sistema as user_to', function($j){
            $j->on('user_to.usu_id', '=', 'carteira.user_to');
        })
        ->where(function($w) use($userId){
            $w->where('user_from', $userId);
            // $w->orWhere('user_to', $userId);
        })
        ->orderBy('carteira.created_at', 'desc')
        ->get()->toArray()
        ;
    }

    public function adicionarSaldo(array $data)
    {
        $carteira = new Carteira;
        $carteira->user_from = $data['user_id'];
        $carteira->tp_id = TipoAcao::ADICIONOU;
        $carteira->valor = $data['valor'];
        $carteira->save();

        return $carteira;
    }

    public function transferir(array $data)
    {
        $carteira = new Carteira;
        $carteira->user_from = $data['payer'];
        $carteira->user_to = $data['payee'];
        $carteira->tp_id = TipoAcao::TRANSFERIU_PAGOU;
        $carteira->valor = -$data['value'];
        $carteira->save();

        $dataCheckTransf = CurlMaker::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        if(!empty($dataCheckTransf) && $dataCheckTransf['message'] == "Autorizado")
        {
            $carteira = new Carteira;
            $carteira->user_from = $data['payee'];
            $carteira->user_to = $data['payer'];
            $carteira->tp_id = TipoAcao::RECEBEU;
            $carteira->valor = $data['value'];
            $carteira->save();

            event(new UsuarioRecebeuPagamento($carteira));

        }else{
            $carteira = new Carteira;
            $carteira->user_from = $data['payer'];
            // $carteira->user_to = $data['payee'];
            $carteira->tp_id = TipoAcao::ESTORNO;
            $carteira->valor = $data['value'];
            $carteira->save();
        }
    }

    private function getInfoCarteira(int $userId)
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

}

