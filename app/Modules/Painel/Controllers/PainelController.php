<?php

namespace App\Modules\Painel\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Painel\Request\ManageTransferenciaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PainelController extends Controller
{
    public function index()
    {
        return view('Painel::home');
    }

    public function getDados(Request $request)
    {
        return $this->_callService('Painel\PainelService','getInfoUser',$request->all());
    }

    public function adicionarSaldo(Request $request)
    {
        return $this->_callService('Painel\PainelService','adicionarSaldo',$request->all());
    }

    public function transferir(ManageTransferenciaRequest $request)
    {
        return $this->_callService('Painel\PainelService','transferir',$request->all());
    }

}
