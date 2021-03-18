<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsuarioSistema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_sistema', function (Blueprint $table) {
            $table->increments('usu_id');
            $table->string('usu_nome', 156);
            $table->string('usu_documento', 80)->unique();
            $table->string('usu_username', 80)->unique();
            $table->string('usu_senha', 45);
            $table->string('usu_email', 60)->unique();
            $table->smallInteger('usu_ativo')->default(1);
            $table->unsignedInteger('per_id');
            $table->foreign('per_id')->references('per_id')->on('perfil');
            $table->timestamp('usu_data_criacao')->useCurrent();
            $table->timestamp('usu_ultimo_acesso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_sistema');
    }
}
