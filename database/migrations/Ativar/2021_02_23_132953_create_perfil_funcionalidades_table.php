<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilFuncionalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_funcionalidades', function (Blueprint $table) {
            $table->increments('pfu_id');
            $table->unsignedInteger('per_id');
            $table->foreign('per_id')->references('per_id')->on('perfil');
            $table->unsignedInteger('fun_id');
            $table->foreign('fun_id')->references('fun_id')->on('funcionalidade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_funcionalidades');
    }
}
