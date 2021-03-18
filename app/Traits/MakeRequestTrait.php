<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NegocioException;
use Illuminate\Support\Facades\Auth;
use App\Services\Log\LogService;
use App\Models\CronjobLog;

trait MakeRequestTrait
{
    //protected $_defaultServiceNameSpace = '\App\Services';
    private $class;
    private $method;
    private $params;
    private $concat_class_name;
    private $start;
    private $lang;
    public $namespace;

    public function _callService($class, $method, $params)
    {
        $params['USUARIO_LOGADO'] = (!empty(Auth::user()) ? Auth::user()->usu_id : null );
        $this->start = microtime(true);
        $this->class = $class;
        $this->method = $method;
        $this->params = $params;
        //$this->lang   = $t['Lang'];
        $this->concat_class_name = "\App\Services\\{$class}";
        $context = null;
        try
        {
            $context = [
                'status'=>1,
                'response'=> $this->__makeTransaction__(true),
                'message'=>'Request executed with success'
            ];
        }
        catch (NegocioException $e)
        {
            $context = ['status'=>0,'response'=>null,'message'=>$e->getMessage()];
        }
        catch(Exception $e)
        {
            Log::info([
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $context = ['status'=>0,'response'=>null,'message'=>'A error has encontred, contact the system administrator'];
        }
        Log::info("{$this->concat_class_name}@{$this->method} time:". $this->requestTime() . ' ms');
        return $context;
    }
    /**
     * this method must be call only to execute modulationtool cronjobs
     * all requests are made on CronjobsController and all cronjobs routes
     * is placed in ./routes/web/cronjobs-routes.php
    */
    public function _cronExec($class, $method, $params = array(), $tipo = null)
    {
        set_time_limit(0);
        $this->start = microtime(true);
        $context = null;
        $log = null;
        $this->class = $class;
        $this->method = $method;
        $this->params = $params;
        $this->concat_class_name  = "\App\Cronjobs\\{$class}";
        if (!$this->_cronIsRunning($tipo)) {
            Log::info("==========>>> CRONJOB START <<<==========");
            $log = $this->__persistCronLog($tipo);
            try {
                $context = [
                    'status' => 1, 'mensagem' => 'Request executed with success', 'response' => $this->__makeTransaction__()
                ];
                $log->cronl_status = 1;
                $log->cronl_mensagem = 'Cronjob executado com sucesso.';
                Log::info("==========>>> CRONJOB END. TIME: " . $this->requestTime() . " ms <<<==========");
            } catch (Exception $e) {
                $log->cronl_status = 0;
                $log->cronl_mensagem = $e->getMessage();
                $context = ['status' => 0, 'mensagem' => 'A error has encontred, contact the system administrator', 'Error' => $e->getMessage()];
                Log::info(' ========= > OCORRREU UM PROBLEMA < =============');
                Log::info(' ==============> INFORMACOES <=================');
                Log::info("[Servico: {$class}@{$method}]");
                Log::info("==========>>> CRONJOB EXECUTADO COM ERRO:{$e->getMessage()}, TIME: " . $this->requestTime() . " <<<==========");
                Log::info([
                    'line' => $e->getLine(),
                    'code' => $e->getCode(),
                    'erro' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            Log::info("==========>>> TENTATIVA DE RODAR CRONJOB SIMULTÂNEO EVITADO TIPO:{$tipo} <<<==========");
            $context = ['status' => 0, 'mensagem' => 'Já existe uma intância desse cronjob em execução'];
        }
        if (!is_null($log)) {
            $log->cronl_data_fim = date('Y-m-d H:i:s');
            $log->save();
        }
        return $context;
    }
    private function _cronIsRunning($type)
    {
        return CronjobLog::where('tcron_id', $type)
            ->whereNull('cronl_data_fim')
            ->exists();
    }
    private function __persistCronLog($type)
    {
        $log = new CronjobLog;
        $log->tcron_id = $type;
        $log->save();
        return $log;
    }
    private function __makeTransaction__($persisActivityLog = false)
    {
        $result = null;
        // $lang = $this->lang ? $this->lang : 'pt';
        // App::setLocale($lang);
        DB::transaction(function () use (&$result, $persisActivityLog) {
            $result = (new $this->concat_class_name)->{$this->method}($this->params);
            if ($persisActivityLog) $this->_persisActivityLog();
        });
        return $result;
    }
    private function _persisActivityLog()
    {
        return (new LogService)->registrarAtividade([
            'classe'     => $this->class,
            'metodo'     => $this->method,
            'parametros' => $this->params
        ]);
    }

    private function requestTime()
    {
        $time = (microtime(true) - $this->start) * 1000;
        return number_format($time, 0, ',', '.');
    }
}
