<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tutorias', function (Blueprint $table) {
            $table->enum('modalidad', ['presencial', 'virtual', 'ambas'])->default('presencial');
        });
    }

    public function down()
    {
        Schema::table('tutorias', function (Blueprint $table) {
            $table->dropColumn('modalidad');
        });
    }
};