<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tutoria_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutoria_id')->constrained()->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('users')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'confirmada', 'completada', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Evitar inscripciones duplicadas
            $table->unique(['tutoria_id', 'estudiante_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutoria_estudiante');
    }
};