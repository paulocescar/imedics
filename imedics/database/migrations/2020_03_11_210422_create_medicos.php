<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('especialidade');
            $table->string('CPF')->unique();
            $table->string('CRM')->unique();
            $table->string('celular');
            $table->string('email');
            $table->string('preferencias');
            $table->string('password');
            $table->boolean('comunicao');
            $table->string('sexo');
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
        Schema::dropIfExists('medicos');
    }
}
