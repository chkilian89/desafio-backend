<?php

namespace App\Models;

use App\Models\BaseModel;

class Notification  extends BaseModel
{
    protected $table = "notifications";
    protected $primaryKey = "not_id";
}
