<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends BaseModel
{
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = "perfil";
    protected $primaryKey = "per_id";

    const ADMINISTRADOR           = 1;
    const COMUM                   = 2;

}
