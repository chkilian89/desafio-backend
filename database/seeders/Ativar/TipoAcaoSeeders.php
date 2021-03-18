<?php

namespace Database\Seeders\Ativar;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAcaoSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_acao')->insert([
            ['tp_descricao' => 'Adicionou'],
            ['tp_descricao' => 'Removeu'],
            ['tp_descricao' => 'Transferiu/Pagou'],
            ['tp_descricao' => 'Recebeu'],
            ['tp_descricao' => 'Novo User'],
            ['tp_descricao' => 'Estorno'],
        ]);
    }
}
