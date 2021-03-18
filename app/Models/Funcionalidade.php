<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionalidade extends BaseModel
{
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = "funcionalidade";
    protected $primaryKey = "fun_id";
}
