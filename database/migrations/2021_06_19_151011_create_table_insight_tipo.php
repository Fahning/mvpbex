<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInsightTipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insight_por_tipo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('faturamento_ultimos_tres_meses');
            $table->json('chart_um');
            $table->json('chart_dois');
            $table->json('chart_tres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insight_por_tipo');
    }
}
