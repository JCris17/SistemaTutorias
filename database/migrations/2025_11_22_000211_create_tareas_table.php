<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
    Schema::create('tareas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_estudiante')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_tutor')->constrained('users')->onDelete('cascade');
        $table->string('titulo');
        $table->text('descripcion');
        $table->string('materia');
        $table->date('fecha_entrega');
        $table->boolean('completada')->default(false);
        $table->text('observaciones')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
};
