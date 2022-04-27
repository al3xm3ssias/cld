<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('tipo_laboratorio_id');
            //$table->foreign('tipo_laboratorio_id')->references('id')->on('tipo_laboratorio');
            $table->string('nome')->nullable();
            $table->string('apelido')->nullable();
            $table->tinyInteger('restrito')->default(0);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('laboratorio');
    }
}
