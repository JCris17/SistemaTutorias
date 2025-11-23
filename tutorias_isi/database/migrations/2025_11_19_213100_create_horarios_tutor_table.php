<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('horarios_tutor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade'); // Referencia a users
            $table->enum('dia_semana', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
            
            $table->unique(['tutor_id', 'dia_semana']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios_tutor');
    }
};