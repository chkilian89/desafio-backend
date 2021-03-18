<?php

namespace App\Converters\Painel;

use App\Models\TipoAcao;
use Illuminate\Support\Collection;

class PainelConverter
{
    public static function formatHistorico(array $data)
    {
       $result = [] ;

       foreach ($data as $item) {
           $result[] =[
                "cat_id" => $item['cat_id'],
                "acao" => self::formatAcao($item['tp_id'], $item['user_nome_from'], $item['user_nome_to']),
                "valor" => self::_formatareal($item['valor']),
                "created_at" => $item['created_at'],
                "classe" => self::setClasse($item['tp_id'])
           ];
       }
       return $result;
    }

    private static function formatAcao(int $idAcao, $userFrom, $userTo)
    {
        switch ($idAcao) {
            case TipoAcao::ADICIONOU:
                return "Você adicionou dinheiro a sua conta.";
                break;

            case TipoAcao::REMOVEU:
                return "Você removeu dinheiro da sua conta. ";
                break;

            case TipoAcao::TRANSFERIU_PAGOU:
                return "Você transferiu/pagou o usuário {$userTo}. ";
                break;

            case TipoAcao::RECEBEU:
                return "Você recebeu dinheiro do usuário {$userTo}. ";
                break;

            case TipoAcao::NOVO_USER:
                return "Você se cadastrou no sistema. ";
                break;

            case TipoAcao::ESTORNO:
                return "O dinheiro foi estornado para a sua conta.";
                break;
        }
    }

    private static function setClasse(int $idAcao)
    {
        switch ($idAcao) {
            case TipoAcao::ADICIONOU:
                return "table-info";
                break;

            case TipoAcao::REMOVEU:
            case TipoAcao::TRANSFERIU_PAGOU:
                return "table-danger";
                break;

            case TipoAcao::RECEBEU:
            case TipoAcao::ESTORNO:
                return "table-success";
                break;

            case TipoAcao::NOVO_USER:
                return "table-secondary";
                break;

        }
    }

    private static function _formatareal($campo, $notnull = true)
	{
		$formata = true;
		if (trim($campo) == "" || $campo == null) {
			if ($notnull) {
				$campo = 0;
			} else {
				$campo = "";
				$formata = false;
			}
		}
		if ($formata) {
			$campo = number_format($campo, 2, ',', '.');
		}
		return $campo;
    }
}
