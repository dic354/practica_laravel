<!DOCTYPE html>
<html>
<head>
    <title>Listado de Artículos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>

    <h1>Lista de artículos</h1>

    <a href="{{ route('articles.create') }}">➕ Nuevo artículo</a>
    <br><br>

    {{-- Mensajes --}}
    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    @if(session('error'))
        <p style="color: red;">
            {{ session('error') }}
        </p>
    @endif

    @if($articles->isEmpty())
        <p>No hay artículos disponibles.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>
                            <a href="{{ route('articles.show', $article->id) }}">
                                {{ $article->title }}
                            </a>
                        </td>
                        <td>{{ $article->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form
                                action="{{ route('articles.destroy', $article->id) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Seguro que quieres borrar este artículo?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color:red;">
                                    🗑 Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
