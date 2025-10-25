<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/style_novo.css') }}">
    <style>
        header.header {
            background-color: #111;
            color: white;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            padding: 20px;
        }

        .btn-voltar {
            background-color: #eee;
            color: #333;
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
            text-decoration: none;
        }

        .btn-voltar:hover {
            background-color: #ddd;
        }

        .cliente-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .cliente-info h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .pedidos table {
            width: 100%;
            border-collapse: collapse;
        }

        .pedidos th, .pedidos td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        .pedidos th {
            background-color: #000;
            color: #fff;
        }

        .pedidos tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Detalhes do Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <section class="cliente-info">
            <h2>{{ $cliente['nome'] }}</h2>
            <p><strong>Telefone:</strong> {{ $cliente['telefone'] }}</p>
            <p><strong>Email:</strong> {{ $cliente['email'] }}</p>
        </section>

        <section class="pedidos">
            <h3>Pedidos</h3>

            @if (count($pedidos) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Cód. Pedido</th>
                            <th>Data</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $p)
                            <tr>
                                <td>{{ $p['cod_pedido'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($p['data_pedido'])->format('d/m/Y H:i') }}</td>
                                <td>R$ {{ number_format($p['total'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color:#666;">Nenhum pedido encontrado.</p>
            @endif
        </section>
    </main>
</body>
</html>
