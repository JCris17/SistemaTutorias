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
    Schema::create('materials', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_tutor')->constrained('users')->onDelete('cascade');
        $table->string('titulo');
        $table->string('materia');
        $table->string('tipo'); // documento, video, enlace, presentacion
        $table->text('descripcion')->nullable();
        $table->string('archivo_url')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
