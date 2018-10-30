<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RdaUniversidadByPeriodo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rda_universidad', function(Blueprint $table){
            $table->string('periodo_id')->nullable();
            $table->foreign('periodo_id')->references('codigo')->on('periodo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rda_universidad', function(Blueprint $table){
            $table->dropForeign('rda_universidad_periodo_id_foreign');
            $table->dropColumn('periodo_id');
        });
    }
}
