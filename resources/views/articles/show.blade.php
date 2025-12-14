<!DOCTYPE html>
<html>
<head>
    <title>{{ $article->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .meta {
            color: #666;
            font-size: 14px;
        }
        .content {
            margin-top: 20px;
        }
        a {
            text-decoration: none;
            color: #0066cc;
        }
    </style>
</head>
<body>

    <a href="{{ url('/articles') }}">← Volver al listado</a>

    <h1>{{ $article->title }}</h1>

    <p class="meta">
        Autor: {{ $article->user->name ?? 'Desconocido' }} <br>
        Fecha: {{ $article->created_at->format('d/m/Y') }}
    </p>

    <div class="content">
        <p>{{ $article->content }}</p>
    </div>

</body>
</html>