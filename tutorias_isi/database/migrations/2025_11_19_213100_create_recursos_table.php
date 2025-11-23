<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade'); // Referencia a users
            $table->string('nombre');
            $table->enum('tipo', ['documento', 'presentacion', 'video', 'enlace']);
            $table->string('archivo')->nullable();
            $table->string('enlace')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('tamaño')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recursos');
    }
};