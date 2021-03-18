<?php

namespace App\Modules\Login\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Login\Request\ManageLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('Login::login');
    }
    // public function login(Request $request)
    public function login(ManageLoginRequest $request)
    {
        $retornoNegocio = $this->_callService('Login\LoginService','login',$request->all());

        if(!empty($retornoNegocio) && $retornoNegocio['status'])
        {
            $usuario = $this->_convertObject($retornoNegocio['response']);
            session()->put('user', $usuario);
            return $retornoNegocio;
        }
        return redirect()->route('login.index');
    }

    public function logout()
    {
        Auth::guard('web')->logout(false);
        session()->flush();
        return redirect()->route('login.index');
    }
}
