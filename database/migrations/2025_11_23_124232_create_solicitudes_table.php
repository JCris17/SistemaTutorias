<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_estudiante')->constrained('users');
            $table->string('tipo'); // tutoria, material, duda, otro
            $table->string('materia');
            $table->foreignId('id_tutor')->nullable()->constrained('users');
            $table->text('descripcion');
            $table->enum('urgencia', ['baja', 'media', 'alta'])->default('media');
            $table->enum('estado', ['pendiente', 'en_proceso', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('respuesta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
};