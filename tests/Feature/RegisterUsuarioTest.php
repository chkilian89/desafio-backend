<?php

namespace Tests\Feature;

use App\Models\UsuarioSistema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/novo-registro/cadastrar');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/novo-registro/salvar', [
            'usu_nome' => 'João da Silva',
            'usu_username' => 'jsilva',
            'usu_documento' => '13286415030',
            'usu_email' => 'jsilva@gmail.com',
            'usu_senha' => '123456',
            'per_id' => 1
        ]);

    }
}
