<?php

namespace Tests\Feature;

use App\Models\UsuarioSistema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\DatabaseTestCase;


class PainelTest extends DatabaseTestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_adicionar_fundos()
    {
        $user = $this->signIn();

        $data = [
            'valor' => 1000,
            'user_id' => $user['usu_id']
        ];

        $this->json('POST', route('painel.adicionar-saldo', $data))
        ->assertJsonStructure([
            'status',
            'message',
            'response',
        ])
        ->assertJson([
                'status' => 1,
                'message' => 'Request executed with success'
            ]);
    }

    public function test_tranferir_pagar()
    {
        $user = $this->signIn();

        $payee = UsuarioSistema::whereNotIn('usu_id', [$user['usu_id']])->first();

        $data = [
            'value' => 10,
            'payer' => $user['usu_id'],
            'payee' => $payee['usu_id']
        ];

        $this->json('POST', route('painel.transferir-saldo', $data))
        ->assertJsonStructure([
            'status',
            'message',
            'response',
        ])
        ->assertJson([
                'status' => 1,
                'message' => 'Request executed with success'
            ]);
    }
}
