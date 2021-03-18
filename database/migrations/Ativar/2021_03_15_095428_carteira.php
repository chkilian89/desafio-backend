<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Carteira extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carteira', function (Blueprint $table) {
            $table->increments('cat_id');
            $table->unsignedInteger('user_from')->nullable();
            $table->foreign('user_from')->references('usu_id')->on('usuario_sistema');
            $table->unsignedInteger('user_to')->nullable();
            $table->foreign('user_to')->references('usu_id')->on('usuario_sistema');
            $table->unsignedInteger('tp_id')->nullable();
            $table->foreign('tp_id')->references('tp_id')->on('tipo_acao');
            $table->double('valor');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carteira');
    }
}
