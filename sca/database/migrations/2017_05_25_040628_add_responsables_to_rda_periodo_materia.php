<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponsablesToRdaPeriodoMateria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rda_periodo_materia', function (Blueprint $table) {
            $table->string('responsables')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rda_periodo_materia', function (Blueprint $table) {
              $table->dropColumn('responsables');
        });
    }
}
