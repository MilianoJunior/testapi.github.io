<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => 'Miliano Fernandes de Oliveira',
            'telefone' => fake()->phoneNumber(),
            'nascimento' => fake()->dateTime(),
            'email' => 'milianojunior39@gmail.com',
            'senha' => '654123',
            'imagem' => fake()->imageUrl(640, 480, 'animals', true),
            'usina' => 'CGH_HOME',
            'ultimo_acesso' => now(),
            'numero_acessos' => fake()->randomDigit(),
            'acessos_consecutivos' => '1',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
