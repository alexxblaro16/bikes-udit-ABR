<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Bicicleta;
use App\Models\Estacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrayectoFactory extends Factory
{
    public function definition(): array
    {
        $inicio = fake()->dateTimeBetween('-30 days', '-1 day');

        return [
            'user_id' => User::factory(),
            'bicicleta_id' => Bicicleta::factory(),
            'estacion_inicio_id' => Estacion::factory(),
            'estacion_fin_id' => Estacion::factory(),
            'started_at' => $inicio,
            'ended_at' => fake()->dateTimeBetween($inicio, 'now'),
        ];
    }

    /**
     * Trayecto activo (sin estación fin ni fecha fin)
     */
    public function activo(): static
    {
        return $this->state(fn(array $attributes) => [
            'estacion_fin_id' => null,
            'ended_at' => null,
            'started_at' => now()->subMinutes(fake()->numberBetween(5, 120)),
        ]);
    }
}
