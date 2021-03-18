<?php

namespace App\Models;

use App\Models\BaseModel;

class CronjobLog extends BaseModel
{
    protected $table = "cronjob_log";
    protected $primaryKey = "cronl_id";
}