<?php

namespace Database\Seeders\Ativar;

use App\Models\TipoCronjob;
use Illuminate\Database\Seeder;

class TipoCronjobSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCronjob::create([
            'tcron_constante' => 'TRADUZIR'
        ]);
    }
}
