<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Primer usuario

        Article::create([
            'title' => 'Artículo de prueba',
            'content' => 'Contenido del artículo...',
            'user_id' => $user->id
        ]);

        Article::factory(10)->create(); // Faker (opcional) - crea 10 artículos aleatorios
    }
}
