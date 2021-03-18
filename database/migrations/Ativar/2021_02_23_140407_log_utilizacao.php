<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogUtilizacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_utilizacao', function (Blueprint $table) {
            $table->increments('lga_id');
            $table->integer('usu_id')->nullable();
            $table->text('lga_dados')->nullable();
            $table->timestamp('lga_data')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_utilizacao');
    }
}
