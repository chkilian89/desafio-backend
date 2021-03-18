<?php

namespace Database\Seeders\Ativar;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarteiraSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carteira')->insert([
            [
                'user_from' => 1,
                'tp_id' => 5,
                'valor' => 0
            ],
            [
                'user_from' => 2,
                'tp_id' => 5,
                'valor' => 0
            ]
        ]);
    }
}
