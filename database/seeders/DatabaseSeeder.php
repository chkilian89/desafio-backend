<?php

namespace Database\Seeders;

use Database\Seeders\Ativar\CarteiraSeeders;
use Database\Seeders\Ativar\PerfilSeeders;
use Database\Seeders\Ativar\TipoAcaoSeeders;
use Database\Seeders\Ativar\TipoCronjobSeeders;
use Database\Seeders\Ativar\TraducoesSeeders;
use Database\Seeders\Ativar\UsuarioSistemaSeeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PerfilSeeders::class,
            UsuarioSistemaSeeders::class,
            TipoAcaoSeeders::class,
            TipoCronjobSeeders::class,
            TraducoesSeeders::class,
            CarteiraSeeders::class
        ]);
    }
}
