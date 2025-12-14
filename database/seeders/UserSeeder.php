<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'David',
            'email' => 'david@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        User::factory(5)->create(); // Faker (opcional): crea 5 usuarios aleatorios
    }
}
