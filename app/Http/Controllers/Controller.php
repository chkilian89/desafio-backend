<?php

namespace App\Http\Controllers;

use App\Traits\HelperTrait;
use App\Traits\JsonExceptionTrait;
use App\Traits\MakeRequestTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MakeRequestTrait, HelperTrait, JsonExceptionTrait;
}
