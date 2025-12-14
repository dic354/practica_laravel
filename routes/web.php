<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolaController;
use App\Http\Controllers\ArticleController;
use App\Models\User;
use App\Models\Article;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// HolaController de prueba
Route::get('/hola', [HolaController::class, 'index']);

// Ruta de test para Eloquent
Route::get('/test', function () {
    $users = User::all();
    $articles = Article::all();
    $user1 = User::find(1);
    $userArticles = Article::where('user_id', 1)->get();

    $newArticle = new Article();
    $newArticle->title = 'Artículo creado con Eloquent';
    $newArticle->content = 'Contenido generado para la prueba';
    $newArticle->user_id = 1;
    $newArticle->save();

    return [
        'users' => $users,
        'articles' => $articles,
        'user1' => $user1,
        'userArticles' => $userArticles,
        'newArticle' => $newArticle,
    ];
});

/*
|--------------------------------------------------------------------------
| Rutas de artículos
|--------------------------------------------------------------------------
*/

// Listado y vista de artículos (público)
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');

Route::get('/articles/{id}', [ArticleController::class, 'show'])
    ->name('articles.show');

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (Guest - no autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard (opcional, puedes eliminarla si no la usas)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de artículos protegidas
    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])
        ->name('articles.store');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])
        ->name('articles.destroy');

    // Rutas de perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Confirm Password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
});