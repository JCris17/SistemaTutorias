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
    Schema::create('tutorias', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_estudiante');
        $table->unsignedBigInteger('id_tutor');
        $table->string('tema');
        $table->date('fecha');
        $table->time('hora_inicio');
        $table->time('hora_fin')->nullable();
        $table->text('observaciones')->nullable();
        $table->timestamps();

        // Relaciones con users
        $table->foreign('id_estudiante')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_tutor')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorias');
    }
};
