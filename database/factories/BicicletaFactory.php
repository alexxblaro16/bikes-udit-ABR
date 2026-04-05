<?php

namespace Database\Factories;

use App\Models\Estacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class BicicletaFactory extends Factory
{
    private static int $contador = 1;

    public function definition(): array
    {
        $marcas = ['BH', 'Orbea', 'Decathlon', 'Trek', 'Giant'];
        $modelos = ['City', 'Urban', 'Campus', 'Eco', 'Sport'];

        $codigo = 'BIC-' . str_pad(self::$contador++, 3, '0', STR_PAD_LEFT);

        return [
            'codigo' => $codigo,
            'estacion_id' => Estacion::factory(),
            'estado' => 'disponible',
            'marca' => fake()->randomElement($marcas),
            'modelo' => fake()->randomElement($modelos) . ' ' . fake()->numberBetween(100, 999),
        ];
    }

    // Estados
    public function disponible(): static
    {
        return $this->state(fn(array $attributes) => ['estado' => 'disponible']);
    }

    public function noDisponible(): static
    {
        return $this->state(fn(array $attributes) => ['estado' => 'no-disponible']);
    }

    public function enMantenimiento(): static
    {
        return $this->state(fn(array $attributes) => ['estado' => 'en-mantenimiento']);
    }
}
