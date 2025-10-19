<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="{{ asset('css/style_base.css') }}">
</head>
<body>
    <header class="header">
        <h1>Lista de Clientes</h1>
        <button class="btn-add" onclick="window.location.href='{{ route('clientes.create') }}'">
            + Novo Cliente
        </button>
    </header>

    <main class="container">
        <table class="tabela-clientes">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $c)
                    <tr>
                        <td>{{ $c['cod_cliente'] }}</td>
                        <td>{{ $c['nome'] }}</td>
                        <td>{{ $c['telefone'] }}</td>
                        <td>{{ $c['email'] }}</td>
                        <td>
                            <a href="{{ route('clientes.detalhes', $c['cod_cliente']) }}" class="btn-detalhes">Detalhes</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
