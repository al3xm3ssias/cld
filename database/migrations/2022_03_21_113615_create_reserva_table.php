<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->datetime('start');
            $table->datetime('end')->nullable();
            $table->unsignedBigInteger('disciplina_id')->default('1');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
            $table->unsignedBigInteger('tipo_reserva_id');
            $table->foreign('tipo_reserva_id')->references('id')->on('tipo_reserva');
            $table->unsignedBigInteger('solicitante_id');
            $table->foreign('solicitante_id')->references('id')->on('users');
            $table->unsignedBigInteger('laboratorio_id');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorio');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->boolean('status')->default(true);
            $table->text('observacao')->nullable();
            $table->string('color')->default('#c63c27');
            $table->tinyInteger('adv')->default('0');
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
        Schema::dropIfExists('reserva');
    }
}
