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
        .user-info {
            float: right;
            background-color: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    {{-- Bloque para usuarios autenticados: mostrar nombre y logout --}}
    @auth
        <div class="user-info">
            👤 Hola, <strong>{{ Auth::user()->name }}</strong> |
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:blue;text-decoration:underline;cursor:pointer;">
                    Cerrar sesión
                </button>
            </form>
        </div>
    @endauth

    {{-- Bloque para usuarios NO autenticados: mostrar enlaces de login/register --}}
    @guest
        <div class="user-info">
            <a href="{{ route('login') }}">🔐 Iniciar sesión</a> |
            <a href="{{ route('register') }}">📝 Registrarse</a>
        </div>
    @endguest

    <h1>Lista de artículos</h1>

    {{-- Solo usuarios autenticados pueden ver el botón de crear artículo --}}
    @auth
        <a href="{{ route('articles.create') }}">➕ Nuevo artículo</a>
        <br><br>
    @endauth

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
                    {{-- Solo mostrar columna "Acciones" si está autenticado --}}
                    @auth
                        <th>Acciones</th>
                    @endauth
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
                        
                        {{-- Solo usuarios autenticados ven el botón de eliminar --}}
                        @auth
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
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>