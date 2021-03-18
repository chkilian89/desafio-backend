<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CronjobLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cronjob_log', function (Blueprint $table) {
            $table->increments('cronl_id');
            $table->unsignedInteger('tcron_id');
            $table->foreign('tcron_id')->references('tcron_id')->on('tipo_cronjob');
            $table->timestamp('cronl_data_inicio')->useCurrent();
            $table->timestamp('cronl_data_fim')->nullable();
            $table->smallInteger('cronl_status')->nullable();
            $table->text('cronl_mensagem', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cronjob_log');
    }
}
