<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
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

    // Mostrar formulario
    public function create()
    {
        return view('articles.create');
    }

    // Guardar artículo
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
            'date'    => 'required|date',
        ]);

        // Crear artículo
        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->created_at = $request->date;
        $article->user_id = 1; // por ahora fijo
        $article->save();

        // Redirigir con mensaje
        return redirect()
            ->route('articles.index')
            ->with('success', 'Artículo creado correctamente');
    }

    // Eliminar artículo
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
