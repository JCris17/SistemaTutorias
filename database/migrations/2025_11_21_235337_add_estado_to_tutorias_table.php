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
    Schema::table('tutorias', function (Blueprint $table) {
        $table->enum('estado', ['activa', 'pendiente', 'completada', 'cancelada'])
              ->default('pendiente')
              ->after('id_tutor');
    });
}

public function down()
{
    Schema::table('tutorias', function (Blueprint $table) {
        $table->dropColumn('estado');
    });
}
};
