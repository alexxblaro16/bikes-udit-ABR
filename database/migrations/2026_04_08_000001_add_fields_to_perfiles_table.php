<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perfiles', function (Blueprint $table) {
            $table->date('fecha_nacimiento')->nullable()->after('direccion');
            $table->string('nacionalidad')->default('Española')->after('fecha_nacimiento');
        });
    }

    public function down(): void
    {
        Schema::table('perfiles', function (Blueprint $table) {
            $table->dropColumn(['fecha_nacimiento', 'nacionalidad']);
        });
    }
};
