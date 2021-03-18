<?php

namespace App\Modules\Login\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Login\Request\ManageUserRegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Login::register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function criar(ManageUserRegisterRequest $request)
    {
        $retornoNegocio = $this->_callService('Login\LoginService','criar',$request->all());
        if(!empty($retornoNegocio) && $retornoNegocio['status'])
        {
            $usuario = $this->_convertObject($retornoNegocio['response']);
            // Auth::login($usuario);
            session()->put('user', $usuario);

            event(new Registered($usuario));
            return $retornoNegocio;
        }

        return redirect()->route('login.index');
    }
}
