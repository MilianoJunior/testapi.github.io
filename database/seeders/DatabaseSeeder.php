<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nome' => 'Miliano Fernandes de Oliveira junior',
            'telefone' => fake()->phoneNumber(),
            'nascimento' => '18/06/1983',
            'email' => 'milianojunior39@gmail.com',
            'senha' => '654123',
            'imagem' => fake()->imageUrl(640, 480, 'animals', true),
            'usina' => 'CGH_HOME',
            'status' => 1,
            'ultimo_acesso' => now(),
            'numero_acessos' => 0,
            'acessos_consecutivos' => 1,
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'nome' => 'Gelson Fernandes de Oliveira',
            'telefone' => fake()->phoneNumber(),
            'nascimento' => '02/01/1986',
            'email' => 'gelsonoliveiracco@gmail.com',
            'senha' => '654123',
            'imagem' => fake()->imageUrl(640, 480, 'animals', true),
            'usina' => 'CGH_HOME',
            'status' => 1,
            'ultimo_acesso' => now(),
            'numero_acessos' => 0,
            'acessos_consecutivos' => 1,
            'remember_token' => Str::random(10),
        ]);
    }
}
