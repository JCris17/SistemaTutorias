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
    Schema::create('asistencias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_estudiante')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_tutoria')->constrained('tutorias')->onDelete('cascade');
        $table->boolean('asistio')->default(false);
        $table->text('observaciones')->nullable();
        $table->timestamp('fecha_asistencia')->useCurrent();
        $table->timestamps();
        
        // Índice único para evitar duplicados
        $table->unique(['id_estudiante', 'id_tutoria']);
    });
}

public function down()
{
    Schema::dropIfExists('asistencias');
}
};
