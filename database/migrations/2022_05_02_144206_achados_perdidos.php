<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AchadosPerdidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achados_e_perdidos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->datetime('dia_achado')->useCurrent();
            $table->datetime('data_saida')->nullable();
            $table->unsignedBigInteger('laboratorio_id');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorio');
            $table->unsignedBigInteger('solicitante_id');
            $table->foreign('solicitante_id')->references('id')->on('users');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achados_e_perdidos');


    }
}
