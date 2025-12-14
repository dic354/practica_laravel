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
}
