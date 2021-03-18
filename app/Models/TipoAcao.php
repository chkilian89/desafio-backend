<?php

namespace App\Models;

use App\Models\BaseModel;

class TipoAcao extends BaseModel
{
    protected $table = "tipo_acao";
    protected $primaryKey = "tp_id";

    //cont CAMPO_CONSTANTE_TABLE = ID
    const ADICIONOU = 1;
    const REMOVEU = 2;
    const TRANSFERIU_PAGOU = 3;
    const RECEBEU = 4;
    const NOVO_USER = 5;
    const ESTORNO = 6;
}
