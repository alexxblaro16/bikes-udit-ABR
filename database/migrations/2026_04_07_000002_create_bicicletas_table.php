<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bicicletas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('estacion_id')->nullable()->constrained('estaciones')->nullOnDelete();
            $table->string('estado')->default('disponible'); // disponible, no-disponible, en-mantenimiento
            $table->string('marca');
            $table->string('modelo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bicicletas');
    }
};
