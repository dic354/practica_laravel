<!DOCTYPE html>
<html>
<head>
    <title>Nuevo artículo</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 6px; }
        .error { color: red; }
    </style>
</head>
<body>

    <h1>Nuevo artículo</h1>

    <a href="{{ route('articles.index') }}">← Volver</a>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <label>Título</label>
        <input type="text" name="title" value="{{ old('title') }}">

        <label>Contenido</label>
        <textarea name="content" rows="5">{{ old('content') }}</textarea>

        <label>Fecha</label>
        <input type="date" name="date" value="{{ old('date') }}">

        <br><br>
        <button type="submit">Guardar artículo</button>
    </form>

</body>
</html>
