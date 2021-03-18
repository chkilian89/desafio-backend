<?php

namespace Database\Seeders\Ativar;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfil')->insert([
            ['per_descricao' => 'LOJISTA'],
            ['per_descricao' => 'COMUM'],
        ]);
    }
}
