<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'matricula' => fake()->unique()->numerify('MAT-####'),
            'telefono' => fake()->phoneNumber(),
            'direccion' => fake()->address(),
        ];
    }
}
