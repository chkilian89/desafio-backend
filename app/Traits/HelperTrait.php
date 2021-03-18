<?php

namespace App\Traits;

use App\Exceptions\NegocioException;
use App\Mail\StandardMailBuilder;
use DateInterval;
// use Illuminate\Support\Facades\Config;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Validator;

trait HelperTrait
{
	/**
	 * default sistem validator for throlling erros (use only in service context)
	 * @param @data array with response data
	 * @param @rules array of validation rules mandatory
	 * @param @names array of bind :attibute param on string message nom mandatory
	 * @param @messages array of custom messages for overrides default behaivoring
	 * @throws NegocioException a default sistem error throller
	 */
	public function _validate(array $data, array $rules, array $names = array(), array $messages = array())
	{
		$validator = Validator::make($data, $rules, $messages, $names);
		if ($validator->fails()) {
			$erros = $validator->errors();
			foreach ($erros->all() as $message) {
				throw new NegocioException($message);
			}
		}
	}

	/**
	 * default sistem mail sender to easely send messages
	 * @param $to string e-mail address to
	 * @param $view string name to view mail
	 * @param $data array payload data to set variables in view (optional)
	 * @param $withbcc array to include hidden recipier
	 * @return $this context
	 */
	public function _sendEmail($subject, $to, $view, array $data = [], $withbcc = [])
	{
		$mail = Mail::to($to);

		if ($withbcc) $mail->bcc($withbcc);

		$mail->send(new StandardMailBuilder($subject, $view, $data));

		return $this;
	}

	/**
	 * if folder does not exists, make it happen!.. have fun ;)
	 * @param $path string path to desired folder
	 * @return void
	 */
	public function _checkIfFolderExists($path, $permiss=751, $recursive=true)
	{
		if (!is_dir($path)) mkdir($path, $permiss,true);
	}
	/**
	 * make unique string token
	 * @return string token
	 */
	public function _hash()
	{
		$a = microtime(true);
		$b = date("Y-m-d H:i:s");
		$c = rand(000, 999);
		$d = rand(000, 999);
		return hash('sha256', (sha1($a) . md5($b) . sha1($c) . md5($d)));
	}
	/**
	 * make a array data become a object
	 * @param $data array
	 * @return object stdClass array converted
	 */
	public function _toObject($data)
	{
		return json_decode(json_encode($data));
	}
	/**
	 * make a BLR number formated like 1.000,00
	 * @param $valor the value to be formated
	 * @param $precisao the amount of decimals
	 * @param $separador_decimal the string decimal separator
	 * @param $separador_milhar the string separator of thousands
	 * @return number_format
	 */
	public function _formatNumber($valor = 0, $precisao = 2)
	{
		$numeros = [
			'pt' => (object)['dec' => ',', 'mil' => '.'],
			'es' => (object)['dec' => ',', 'mil' => '.'],
			'fr' => (object)['dec' => ',', 'mil' => ' '],
			'en' => (object)['dec' => '.', 'mil' => ','],
			'de' => (object)['dec' => ',', 'mil' => '.'],
			'zh' => (object)['dec' => '.', 'mil' => ','],
		];
		$locale = App::getLocale();
		$_number = array_key_exists($locale, $numeros)
			? $numeros[$locale]
			: (object)['dec' => ',', 'mil' => '.'];
		return number_format($valor ?? 0, $precisao, $_number->dec, $_number->mil);
	}
	/**
	 * default date formater using language parameters
	 * @param $stringDate in format Y-m-d or Y-m-d H:i:s
	 * @return string formated date
	 */
	public function _dateFormat($stringDate, $withHours = '')
	{
		$datas = config('config.formatos.datas');
		$locale = App::getLocale();
		$_date = array_key_exists($locale, $datas)
			? $datas[$locale]
			: 'd/m/Y';
		return date(($_date . $withHours), strtotime($stringDate));
	}
	/**
	 * convert a formated string numvber like 1.000,00 to 1000.00
	 * @param $valor the value
	 * @return number
	 */
	public function _stringToNumber($valor)
	{
		return $valor
			? preg_replace('/(\,)/', '.', preg_replace('/(\.)/', '', $valor))
			: null;
	}

	public function _convertObject($data)
	{
		return json_decode(json_encode($data));
	}

	public function _translate($list, $defaultKey = 'descricao')
	{
		foreach ($list as $k => &$v) {
			if (is_array($v)) {
				$v[$defaultKey] = trans($v[$defaultKey]);
			} else {
				$v->{"$defaultKey"} = trans($v->{"$defaultKey"});
			}
		}
		return $list;
	}
	/**
	 * função responsavel por manter atualizada as constantes do usuario logado
	 * como as parametrizações de conversões de teorico heat e teorico agua podem
	 * ser alteradas, o tempo de vida das constatns é de 2 minutos
	 * @return boolean
	 */
	public function _constantStatus()
	{
		$atualizarConstant = false;
		if (session()->has('user')) {
			$user = session()->get('user');
			if (!empty($user->TIME) && $user->TIME < date('Y-m-d H:i:s')) {
				$atualizarConstant = true;
			}
		}
		return $atualizarConstant;
	}

	/**
	 * make conversion float, to format database. Replace "," to ".". Ex: 1.050,00 => 1050.00
	 * @param float $campo
	 * @param boolean $retornaZero optional
	 * @return $campo
	 */
	public function __convFloat($campo, $retornaZero = false)
	{
		$posVirgula = strpos($campo, ',');

		if ($posVirgula) {
			$decimais = substr($campo, $posVirgula);
			$inteiros = str_replace('.', '', substr($campo, 0, $posVirgula));
			$campo = $inteiros . $decimais;
		}

		$campo = trim(str_replace(',', '.', $campo));

		if ((trim($campo) == "") and $retornaZero) {
			$campo = 0;
		}

		return $campo;
	}

	public function _knockoutPaginator($query, $page, $newTake=null, $liskey = 'lista')
	{
		$t = clone $query;
		$skip = !empty($page) ? $page - 1 : 0;
        $take = (!empty($newTake) ? $newTake :config('config.paginator.limit'));
		$total = $t->count();
		return [
			'itens_por_pagina' => $take,
			'pagina_atual' => !empty($page) ? $page : 1,
			'total_de_itens' => $total,
			'total_de_paginas' => ceil($total / $take),
			$liskey => $query->skip($skip * $take)->take($take)->get()
		];
	}

	public function _sanitizeString($str)
	{
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		// $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
		$str = preg_replace('/[^a-z0-9]/i', '_', $str);
		$str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
		return $str;
	}

	public function _dataFormat($stringDate, $format = 'd/m/Y H:i:s')
	{
		return (bool)strtotime($stringDate)
			? date($format, strtotime($stringDate))
			: "";
	}
	public function _limpaCampo($data)
	{
		return preg_replace('/\D/', '', $data);
	}

	/** Função responsável para converter em real
	*
	*/
	public function _formatareal($campo, $notnull = true)
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
    /**
     * function que converte strings para maiusculas, de acordo com o charset
     *
     * @param [type] $string
     * @param string $charset
     * @return void
     */
    public function _toUpper($string,$charset='UTF-8')
    {
        return trim(mb_strtoupper($string, $charset));
    }

    public function _retronaNull($campo)
    {
        if(empty(trim($campo))) return NULL;
        return $campo;
    }

    /**
     * function retorna os feriados nacionais do Brasil
     *
     * @param [ano] $string
     * @param [fomart] bool
     * @return array
    */
    public function listarFeriadosAno($ano = null){
        if ($ano === null){
            $ano = intval(date('Y'));
        }

        if($ano != '2037'){
            $pascoa     = easter_date($ano); // Limite entre 1970 a 2037 conforme http://www.php.net/manual/pt_BR/function.easter-date.php
        }else{
            $pascoa = easter_days($ano);
        }

        $dia_pascoa = date('j', $pascoa);
        $mes_pascoa = date('n', $pascoa);
        $ano_pascoa = date('Y', $pascoa);

        // $feriados = array(
        //     // Datas Fixas dos feriados brasileiros
        //     'Ano Novo' => mktime(0, 0, 0, 1,  1,   $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
        //     'Tiradentes' => mktime(0, 0, 0, 4,  21,  $ano), // Tiradentes - Lei nº 662, de 06/04/49
        //     'Dia do Trabalhador' => mktime(0, 0, 0, 5,  1,   $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
        //     'Independência do Brasil' => mktime(0, 0, 0, 9,  7,   $ano), // Dia da Independência - Lei nº 662, de 06/04/49
        //     'Nossa Senhora Aparecida' => mktime(0, 0, 0, 10,  12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
        //     'Finados' => mktime(0, 0, 0, 11,  2,  $ano), // Todos os santos - Lei nº 662, de 06/04/49
        //     'Proclamação da República' => mktime(0, 0, 0, 11, 15,  $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
        //     'Natal' => mktime(0, 0, 0, 12, 25,  $ano), // Natal - Lei nº 662, de 06/04/49

        //     // Essas datas dependem da páscoa
        //     'Segunda de Carnaval' => mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa),//2ºferia Carnaval
        //     'Terça de Carnaval' => mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa),//3ºferia Carnaval
        //     'Sexta-feira da Paixão' => mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa),//6ºfeira Santa
        //     'Páscoa' => mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa),//Pascoa
        //     'Corpus Christi' => mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa),//Corpus Cirist
        // );
        $feriados = array(
            // Datas Fixas dos feriados brasileiros
            mktime(0, 0, 0, 1,  1,   $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 4,  21,  $ano), // Tiradentes - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 5,  1,   $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 9,  7,   $ano), // Dia da Independência - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 10,  12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
            mktime(0, 0, 0, 11,  2,  $ano), // Todos os santos - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 11, 15,  $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 12, 25,  $ano), // Natal - Lei nº 662, de 06/04/49

            // Essas datas dependem da páscoa
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa),//2ºferia Carnaval
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa),//3ºferia Carnaval
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa),//6ºfeira Santa
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa),//Pascoa
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa),//Corpus Cirist
        );

        // asort($feriados);
        sort($feriados);
        $listaDiasFeriado = [];
        foreach ($feriados as $feriado) {
            $data = date('Y-m-d', $feriado);
            $listaDiasFeriado[] = $data;
        }

        return $listaDiasFeriado;
    }

    public function calculaPrazoFeriado($vencimento, $acao)
    {
        // $dataFeriados = $this->feriados(date('Y'),true)['datas'];
        $dataFeriados = $this->listarFeriadosAno(date("Y", strtotime($vencimento)));//??


        $weekDay = [0,6];//0 = DOMINGO, 6 = SÁBADO

        if(in_array($vencimento, $dataFeriados))
        {
            //$acao => Id do ação a ser tomada quando a data cair em feriado

            if( ($acao == 1 && !in_array($this->isWeekend($vencimento), $weekDay)) || (in_array($this->isWeekend($vencimento), $weekDay) && $acao == 1) ){//1 = Antecipar
                // debug('aqui helper');
                $novoPrazo = DateTime::createFromFormat('Y-m-d', $vencimento);
                $novoPrazo->sub(new DateInterval('P1D')); // -1 dia

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 0)
                {
                    $novoPrazo->sub(new DateInterval('P2D'));
                }

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 6)
                {
                    $novoPrazo->sub(new DateInterval('P1D'));
                }

                //garantindo que o novo vencimento seja um dia util.
                if(in_array($novoPrazo->format('Y-m-d'), $dataFeriados)){
                    $novoPrazo->sub(new DateInterval('P1D'));
                }

                return $novoPrazo->format('Y-m-d');
            }

            else if( ($acao == 3 && !in_array($this->isWeekend($vencimento), $weekDay)) || (in_array($this->isWeekend($vencimento), $weekDay) && $acao == 3) ){//3 = Postergar

                $novoPrazo = DateTime::createFromFormat('Y-m-d', $vencimento);
                $novoPrazo->add(new DateInterval('P1D')); // +1 dia

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 6){
                    $novoPrazo->add(new DateInterval('P2D'));
                }

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 0){
                    $novoPrazo->add(new DateInterval('P1D'));
                }

                //garantindo que o novo vencimento seja um dia util.
                if(in_array($novoPrazo->format('Y-m-d'), $dataFeriados)){
                    $novoPrazo->add(new DateInterval('P1D'));
                }

                return $novoPrazo->format('Y-m-d');
            }
            else{
                return $vencimento;
            }
        }else{

            if( (in_array($this->isWeekend($vencimento), $weekDay) && $acao == 1) ){//1 = Antecipar
                $novoPrazo = DateTime::createFromFormat('Y-m-d', $vencimento);
                $novoPrazo->sub(new DateInterval('P1D')); // -1 dia

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 0)
                {
                    $novoPrazo->sub(new DateInterval('P2D'));
                }

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 6)
                {
                    $novoPrazo->sub(new DateInterval('P1D'));
                }

                //garantindo que o novo vencimento seja um dia util.
                if(in_array($novoPrazo->format('Y-m-d'), $dataFeriados)){
                    $novoPrazo->sub(new DateInterval('P1D'));
                }

                return $novoPrazo->format('Y-m-d');
            }

            else if( (in_array($this->isWeekend($vencimento), $weekDay) && $acao == 3) ){//3 = Postergar

                $novoPrazo = DateTime::createFromFormat('Y-m-d', $vencimento);
                $novoPrazo->add(new DateInterval('P1D')); // +1 dia

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 6)
                {
                    $novoPrazo->add(new DateInterval('P2D'));
                }

                if($this->isWeekend(date('Y-m-d', strtotime($novoPrazo->format('Y-m-d')))) == 0)
                {
                    $novoPrazo->add(new DateInterval('P1D'));
                }

                //garantindo que o novo vencimento seja um dia util.
                if(in_array($novoPrazo->format('Y-m-d'), $dataFeriados)){
                    $novoPrazo->add(new DateInterval('P1D'));
                }

                return $novoPrazo->format('Y-m-d');
            }
            else{
                return $vencimento;
            }
        }
    }

    public function isWeekend($date) {
        // return (date('N', strtotime($date['data'])) >= 6);
        return (int)date('w', strtotime($date));
        // return ($weekDay == 0 || $weekDay == 6);

    }

    public function getDiasUteisMes($aPartirDe, $quantidadeDeDias = 30) {
        $aPartirDe = substr($aPartirDe, 0,4)."-".substr($aPartirDe, 5,2)."-01";
        $dateTime = new DateTime($aPartirDe);

        $listaDiasUteis = [];
        $contador = 0;
        while ($contador < $quantidadeDeDias) {
            $dateTime->modify('+1 weekday'); // adiciona um dia pulando finais de semana
            $data = $dateTime->format('Y-m-d');
            if (!in_array($data, $this->listarFeriadosAno(date("Y", strtotime($aPartirDe))) )) {
                $listaDiasUteis[] = $data;
                $contador++;
            }
        }

        return $listaDiasUteis;
    }

    public function searchTermoInString($termo, $string)
    {
        if(!empty($string) || $string != ""){
            $pattern = '/' . $termo . '/';//Padrão a ser encontrado na string $tags
            return preg_match($pattern, $string);
        }
        return false;
    }

}
