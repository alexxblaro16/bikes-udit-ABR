<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trayectos', function (Blueprint $table) {
            $table->boolean('favorito')->default(false)->after('ended_at');
        });
    }

    public function down(): void
    {
        Schema::table('trayectos', function (Blueprint $table) {
            $table->dropColumn('favorito');
        });
    }
};
