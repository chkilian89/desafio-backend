<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('not_id');
            $table->unsignedInteger('usu_id');
            $table->foreign('usu_id')->references('usu_id')->on('usuario_sistema');
            $table->text('not_desc');
            $table->timestamp('not_date_insert')->useCurrent();
            $table->timestamp('not_date_read')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
