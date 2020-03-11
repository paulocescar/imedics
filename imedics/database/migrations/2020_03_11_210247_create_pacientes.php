<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('CPF')->unique();
            $table->string('CNPJ')->unique();
            $table->string('sexo');
            $table->string('email');
            $table->string('celular');
            $table->string('preferencias');
            $table->string('password');
            $table->boolean('comunicao');
            $table->timestamp('data_nascimento');
            $table->string('observacao');
            $table->softDeletes();
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
        Schema::dropIfExists('pacientes');
    }
}
