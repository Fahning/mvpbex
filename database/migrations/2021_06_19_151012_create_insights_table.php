<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('insight_id')->default(0);
            $table->float('faturamento');
            $table->string('tipo');
            $table->string('nome');
            $table->float('porcentagem');
            $table->float('media');
            $table->dateTime('sk_data');
            $table->integer('status')->default(0);
            $table->string('cnpj',14)->default(0);
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::table('insights', function (Blueprint $table){
            $table->foreign('insight_id')->references('id')->on('insight_por_tipo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insights');
    }
}
