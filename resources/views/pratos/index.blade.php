<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pratos</title>
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
        }
        .btn-voltar:hover {
            background-color: #ddd;
        }
        .tabela-pratos {
            width: 100%;
            border-collapse: collapse;
        }
        .tabela-pratos th, .tabela-pratos td {
            padding: 12px 8px;
            font-size: 16px;
            text-align: left;
        }
        .tabela-pratos th {
            background-color: #f0f0f0;
        }
        .acoes-pratos {
            display: flex;
            gap: 10px;
        }
        .btn-editar {
            padding: 6px 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-excluir {
            padding: 6px 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        <h1>Pratos</h1>
        <a href="{{ url('/') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <a href="{{ url('/pratos/novo') }}" class="btn-novo">+ Novo Prato</a>

        @if(session('success'))
            <p class="text-success">{{ session('success') }}</p>
        @endif

        <table class="tabela-pratos">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Valor (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pratos as $p)
                <tr>
                    <td>{{ $p['cod_prato'] }}</td>
                    <td>{{ $p['descricao'] }}</td>
                    <td>{{ number_format($p['valor_unitario'], 2, ',', '.') }}</td>
                    <td class="acoes-pratos">
                        <a href="{{ url('/pratos/editar/'.$p['cod_prato']) }}" class="btn-editar">Editar</a>
                        <form action="{{ url('/pratos/deletar/'.$p['cod_prato']) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-excluir" onclick="return confirm('Excluir prato?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
