<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trayectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('bicicleta_id')->constrained('bicicletas')->cascadeOnDelete();
            $table->foreignId('estacion_inicio_id')->constrained('estaciones');
            $table->foreignId('estacion_fin_id')->nullable()->constrained('estaciones');
            $table->datetime('started_at');
            $table->datetime('ended_at')->nullable(); // null = trayecto activo
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trayectos');
    }
};
