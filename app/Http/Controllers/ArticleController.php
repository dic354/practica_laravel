<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    /**
     * middlewares para el controlador (Laravel 11+)
     * Solo usuarios autenticados pueden crear, guardar y eliminar
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create', 'store', 'destroy']),
        ];
    }

    public function index()
    {
        // Traer todos los artículos
        $articles = Article::all();

        // Pasarlos a la vista
        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        // Buscar el artículo por ID
        $article = Article::findOrFail($id);

        // Pasarlo a la vista
        return view('articles.show', compact('article'));
    }

    // Mostrar formulario (PROTEGIDO por middleware)
    public function create()
    {
        return view('articles.create');
    }

    // Guardar artículo (PROTEGIDO por middleware)
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
            'date'    => 'required|date',
        ]);

        // Crear artículo asociado al usuario autenticado
        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->created_at = $request->date;
        $article->user_id = Auth::id(); // Usuario autenticado actual
        $article->save();

        // Redirigir con mensaje
        return redirect()
            ->route('articles.index')
            ->with('success', 'Artículo creado correctamente');
    }

    // Eliminar artículo (PROTEGIDO por middleware)
    public function destroy($id)
    {
         try {
            $article = Article::findOrFail($id);
            $article->delete();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artículo eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()
                ->route('articles.index')
                ->with('error', 'Error al eliminar el artículo');
        }
    }
}