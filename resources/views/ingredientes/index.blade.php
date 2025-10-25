<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ingredientes</title>
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

        .btn-novo {
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            display: inline-block;
            text-decoration: none;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 8px;
            font-size: 16px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        table th {
            background-color: #f0f0f0;
            color: #000;
        }

        table tr:hover {
            background-color: #f8f9fa;
        }

        input[type="number"] {
            width: 70px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .acoes-ingredientes {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }

        .btn-info {
            background-color: #3498db;
        }

        .btn-info:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .text-success {
            color: #2ecc71;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Ingredientes</h1>
        <a href="{{ url('/') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="text-success">{{ session('success') }}</div>
        @endif

        <a href="{{ url('/ingredientes/novo') }}" class="btn-novo">+ Novo Ingrediente</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Unidade</th>
                    <th>Valor Unitário (R$)</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingredientes as $ing)
                    <tr>
                        <td>{{ $ing['cod_ingrediente'] }}</td>
                        <td>{{ $ing['descricao'] }}</td>
                        <td>{{ $ing['unidade'] == 0 ? 'Unidade' : 'Kg' }}</td>
                        <td>{{ number_format($ing['valor_unitario'], 2, ',', '.') }}</td>
                        <td>{{ $ing['quantidade_estoque'] }}</td>
                        <td class="acoes-ingredientes">
                            <form method="POST" action="{{ url('/ingredientes/' . $ing['cod_ingrediente'] . '/adicionar') }}" style="display:inline;">
                                @csrf
                                <input type="number" name="quantidade" min="1" placeholder="Qtd" required>
                                <button type="submit" class="btn btn-info">+ Estoque</button>
                            </form>

                            <form method="POST" action="{{ url('/ingredientes/' . $ing['cod_ingrediente'] . '/excluir') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Remover este ingrediente?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
