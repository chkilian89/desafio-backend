<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerfilFuncionalidade extends BaseModel
{
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = "perfil_funcionalidade";
    protected $primaryKey = "pfu_id";
}
