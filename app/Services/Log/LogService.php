<?php

namespace App\Services\Log;

use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\LogUtilizacao;
use Carbon\Carbon;

class LogService extends BaseService
{
	/**
	 * function descriptiom
	 * @param
	 **/
	public function registrarAtividade($data)
	{
		if (!empty($data) && !empty($data['parametros']['USUARIO_LOGADO'])) {

			$log = new LogUtilizacao;
			$log->usu_id = $data['parametros']['USUARIO_LOGADO'];
			$log->lga_dados = json_encode($data);
			$log->save();
		}
	}
}
