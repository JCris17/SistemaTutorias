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
    Schema::create('evaluaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_estudiante')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_tutor')->constrained('users')->onDelete('cascade');
        $table->string('materia');
        $table->string('tipo_evaluacion'); // quiz, examen, proyecto
        $table->decimal('calificacion', 3, 1);
        $table->text('comentarios')->nullable();
        $table->date('fecha_evaluacion');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('evaluacions');
    }
};
