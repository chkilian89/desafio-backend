<?php

namespace App\Api;

use Exception;
use Illuminate\Support\Facades\Log;

abstract class CurlMaker
{
	/**
	*	function description
	*	@param string $url
	*	@param array $parametros
	*	@return json_decoded object result
	*/
	public static function getResults($url, array $parametros = array())
	{
		debug([
			'CurlMaker_POST' => [
				'url' =>$url,
				'parametros' => $parametros
			]
		]);
		$parametros = json_encode($parametros);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($parametros))
		);
		try
		{
			$result = curl_exec($ch);
			curl_close($ch);
			return json_decode($result);
		}
		catch (Exception $erro)
		{
			Log::debug('==============> ERRO AO CHAMAR WEBSERVICE <==================');
			Log::debug('~~~~ Informacoes => ' . var_export($erro, true));
			// throw new NegocioException('Erro ao processar a chamada curl de webservice');
			// return ['status' => 0, 'mensagem'=>'Erro ao processar a chamada curl de webservice'];
			return 'Erro ao processar a chamada curl de webservice';
		}
	}

    public static function get($url)
    {
        // Iniciamos a função do CURL:
        $ch = curl_init($url);

        curl_setopt_array($ch, [

            // Equivalente ao -X:
            CURLOPT_CUSTOMREQUEST => 'GET',

            // Equivalente ao -H:
            CURLOPT_HTTPHEADER => [
                'JsonOdds-API-Key: yourapikey'
            ],

            // Permite obter o resultado
            CURLOPT_RETURNTRANSFER => 1,
        ]);

        $resposta = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $resposta;
    }
}
