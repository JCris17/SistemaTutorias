<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('solicituds', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_estudiante')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_tutor')->nullable()->constrained('users')->onDelete('cascade');
        $table->string('tipo'); // tutor_personal, tema_especifico, horario_especial
        $table->string('materia');
        $table->text('descripcion');
        $table->string('urgencia'); // baja, media, alta
        $table->string('estado')->default('pendiente'); // pendiente, aprobada, rechazada
        $table->text('respuesta')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
};
