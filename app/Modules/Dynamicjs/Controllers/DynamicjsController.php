<?php

namespace App\Modules\Dynamicjs\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DynamicjsController extends Controller
{
    public function base()
    {
        $content = view('Dynamicjs::base');
        return response($content,200,[
            'Content-Type'=>'application/x-javascript;charset=UTF-8'
        ]);
    }
    public function lang()
    {
        $content = view('Dynamicjs::translator');
        return response($content,200,[
            'Content-Type'=>'application/x-javascript;charset=UTF-8'
        ]);
    }
}
