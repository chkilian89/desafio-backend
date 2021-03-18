<?php

namespace App\Models;

use App\Models\BaseModel;

class TipoCronjob extends BaseModel
{
    protected $table = "tipo_cronjob";
    protected $primaryKey = "tcron_id";

    //cont CAMPO_CONSTANTE_TABLE = ID
    const TRADUZIR = 1;
    const CRIAR_TAREFAS_TRIMESTRAL = 2;
    const CRIAR_TAREFAS_MENSAL = 3;
    const CRIAR_TAREFAS_ANUAL = 4;
    const ALTERA_STATUS_TAREFAS = 5;
    const CRIAR_TAREFAS_BIMESTRAL = 6;
    const ATUALIZAR_CLIENTE = 7;
}
