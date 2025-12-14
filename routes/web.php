<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hola', [HolaController::class, 'index']);

use App\Models\User;
use App\Models\Article;

Route::get('/test', function () {

    // 1. Obtener todos los usuarios
    $users = User::all();

    // 2. Obtener todos los artículos
    $articles = Article::all();

    // 3. Obtener un usuario por id
    $user1 = User::find(1);

    // 4. Filtrar artículos por user_id
    $userArticles = Article::where('user_id', 1)->get();

    // 5. Crear un nuevo artículo y guardarlo
    $newArticle = new Article();
    $newArticle->title = 'Artículo creado con Eloquent';
    $newArticle->content = 'Contenido generado para la prueba';
    $newArticle->user_id = 1;
    $newArticle->save();

    // Retornar todo como JSON para ver los resultados
    return [
        'users' => $users,
        'articles' => $articles,
        'user1' => $user1,
        'userArticles' => $userArticles,
        'newArticle' => $newArticle,
    ];
});

use App\Http\Controllers\ArticleController;

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
