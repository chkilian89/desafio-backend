<?php

namespace App\Services\Login;

use App\Exceptions\NegocioException;
use App\Models\Carteira;
use App\Models\Funcionalidade;
use App\Models\TipoAcao;
use App\Models\UsuarioMakeLogin;
use App\Models\UsuarioSistema;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginService extends BaseService
{
    /**
     * responsible to set a system session with Auth
     * @param @data array [
     *  'usu_username'=>string
     *  'usu_senha'=>string
     * ]
     * @return mixed between NegocioException or string
     */
    public function login($data)
    {
        /*$this->_validate(
            $data,[
                'usu_username' => 'required|max:156',
                'usu_senha'=> 'required|max:16'
            ],[
                'usu_username' => 'Usuário',
                'usu_senha'=> 'Senha'
            ]
        );*/

        $user = UsuarioSistema::select(
            'usu_id',
            'usu_nome',
            'usu_senha',
            'usu_username',
            'usu_email',
            'usu_ativo',
            'usu_data_criacao',
            'usu_ultimo_acesso',
            'perfil.per_id',
            'perfil.per_descricao',

        )
        ->join('perfil', 'perfil.per_id', '=', 'usuario_sistema.per_id')
        ->where(function($w)use($data){
            $w->where('usu_username',$data['usu_username']);
            $w->where('usu_senha',$data['usu_senha']);
        })
        ->where('usu_ativo', 1)
        ->first();

        if(!$user) throw new NegocioException('Usuário ou senha inválido');
        // debug($user);
        $usuarioMakeLogin = new UsuarioMakeLogin;
        $usuarioMakeLogin->set($user);

        $user->usu_ultimo_acesso = date('Y-m-d H:i:s');
        $user->save();

        $return = $usuarioMakeLogin;
        $return->ROTAS_SISTEMA = Funcionalidade::whereNotNull('fun_url')->pluck('fun_url');
        $return->ROTAS_ACESSO = Funcionalidade::join('perfil_funcionalidades as p', function ($j) use ($user) {
            $j->on('p.fun_id', '=', 'funcionalidade.fun_id')->where('p.per_id', '=', $user->per_id);
        })
        ->orderBy('p.pfu_id', 'asc')
        ->pluck('funcionalidade.fun_url');

        Auth::guard('web')->login($usuarioMakeLogin, false/*this false attribut is to disable remember token feature*/);
        if(!Auth::user()) throw new NegocioException('Erro ao efetuar login');

        return $return;

    }

    public function criar(array $data)
    {
        $user = new UsuarioSistema;
        $user->fill($data);
        $user->save();

        $usuarioMakeLogin = new UsuarioMakeLogin;
        $usuarioMakeLogin->set($user);

        $user->usu_ultimo_acesso = date('Y-m-d H:i:s');
        $user->save();

        $return = $usuarioMakeLogin;
        $return->ROTAS_SISTEMA = Funcionalidade::whereNotNull('fun_url')->pluck('fun_url');
        $return->ROTAS_ACESSO = Funcionalidade::join('perfil_funcionalidades as p', function ($j) use ($user) {
            $j->on('p.fun_id', '=', 'funcionalidade.fun_id')->where('p.per_id', '=', $user->per_id);
        })
        ->orderBy('p.pfu_id', 'asc')
        ->pluck('funcionalidade.fun_url');

        Auth::guard('web')->login($usuarioMakeLogin, false/*this false attribut is to disable remember token feature*/);

        $carteira = new Carteira;
        $carteira->user_from = $user->usu_id;
        $carteira->tp_id = TipoAcao::NOVO_USER;
        $carteira->valor = 0;
        $carteira->save();

        return $return;
    }

}

