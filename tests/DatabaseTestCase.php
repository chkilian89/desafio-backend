<?php

namespace Tests;

use App\Models\UsuarioSistema;
use App\Services\Login\LoginService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


abstract class DatabaseTestCase extends TestCase
{
    public function setUp():void
    {
        parent::setUp();

        $this->artisan('app:ativar');

        // $this->artisan('test',['--env' => 'testing']);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });

    }

    public function signIn()
    {
        $loginService = app(LoginService::class);

        $user = $loginService->login([
            'usu_username' => 'jsilveira',
            'usu_senha' => sha1('123456'),
        ]);

        session()->put('user', $user);

        return $user;

    }
}
