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
    Schema::create('notificaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_estudiante')->constrained('users')->onDelete('cascade');
        $table->string('titulo');
        $table->text('mensaje');
        $table->string('tipo'); // info, warning, success, danger
        $table->boolean('leida')->default(false);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('notificacions');
    }
};
