<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Criação de 50 usuários fictícios
        foreach (range(1, 50) as $index) {
            DB::table('users')->insert([
                'id' => (string) Str::uuid(), // Gerar UUID para o ID
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'birth_date' => $faker->date,
                'password' => Hash::make('password'), // Definir uma senha padrão
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
