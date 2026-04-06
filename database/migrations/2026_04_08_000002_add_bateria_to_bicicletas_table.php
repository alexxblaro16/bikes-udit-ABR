<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bicicletas', function (Blueprint $table) {
            $table->integer('bateria')->default(100)->after('estado'); // 0-100, 100% = 2h de uso
            $table->datetime('ultimo_uso')->nullable()->after('bateria'); // para calcular carga
        });
    }

    public function down(): void
    {
        Schema::table('bicicletas', function (Blueprint $table) {
            $table->dropColumn(['bateria', 'ultimo_uso']);
        });
    }
};
