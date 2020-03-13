<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id')->unsigned()->nullable();
            $table->unsignedBigInteger('medico_id')->unsigned()->nullable();
            $table->dateTime('inicio')->nullable();
            $table->dateTime('fim')->nullable();
            $table->dateTime('data_agendamento');
            $table->enum('status',['M','C','E','F']);
            $table->string('observacao')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes')->
            onDelete('restrict')->
            onUpdate('cascade');

            $table->foreign('medico_id')->references('id')->on('medicos')->
            onDelete('restrict')->
            onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
