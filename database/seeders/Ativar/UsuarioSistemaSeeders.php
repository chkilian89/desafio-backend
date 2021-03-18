<?php

namespace Database\Seeders\Ativar;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSistemaSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario_sistema')->insert([
            [
                'usu_nome' => 'Josiane Silveira',
                'usu_username' => 'jsilveira',
                'usu_senha' => sha1('123456'),
                'usu_documento' => '15046281015',
                'usu_email' => 'jsilveira@gmail.com',
                'per_id' => 2
            ],
            [
                'usu_nome' => 'Paulo Mariano',
                'usu_username' => 'pmariano',
                'usu_senha' => sha1('123456'),
                'usu_documento' => '53379211001',
                'usu_email' => 'pmariano@gmail.com',
                'per_id' => 1
            ],
        ]);
    }
}
