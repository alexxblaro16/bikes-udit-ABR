<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder del sistema de bicicletas (crea usuarios con perfiles, estaciones, bicis y trayectos)
        $this->call([
            BicicletaEstacionSeeder::class,
        ]);
    }
}
