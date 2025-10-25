<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
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

        /* Ajustes específicos para esta página */
        .form-criar {
            margin: 20px 0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .form-criar input {
            padding: 8px 12px;
            font-size: 16px;
        }

        .tabela-pedidos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabela-pedidos th,
        .tabela-pedidos td {
            padding: 12px 8px;
            text-align: left;
            font-size: 16px;
        }

        .tabela-pedidos th {
            background-color: #f0f0f0;
            color: #000;
        }

        /* leve demarcação entre linhas */
        .tabela-pedidos tr {
            border-bottom: 1px solid #e0e0e0;
        }

        .acoes {
            display: flex;
            gap: 10px;
        }

        .btn-detalhes,
        .btn-finalizar {
            padding: 8px 16px;
            font-size: 16px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-detalhes {
            background-color: #3498db;
            color: white;
        }

        .btn-finalizar {
            background-color: #e74c3c;
            color: white;
        }

        .status-aberto {
            background-color: #2ecc71;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }

        .status-fechado {
            background-color: #f1c40f;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Pedidos</h1>
        <a href="{{ url('/') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <!-- Formulário de criar pedido -->
        <form method="POST" action="/pedidos/criar" class="form-criar">
            @csrf
            <input type="number" name="cod_cliente" placeholder="Código do Cliente" required>
            <button type="submit" class="btn-add">+ Criar Pedido</button>
        </form>

        <!-- Tabela de pedidos -->
        <table class="tabela-pedidos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Valor Total</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $p)
                    <tr>
                        <td>{{ $p['cod_pedido'] }}</td>
                        <td>{{ $p['cliente_nome'] }}</td>
                        <td>{{ $p['data_pedido'] }}</td>
                        <td>{{ $p['valor_total'] }}</td>
                        <td>
                            @if ($p['status'] == 0)
                                <span class="status-aberto">Aberto</span>
                            @else
                                <span class="status-fechado">Fechado</span>
                            @endif
                        </td>
                        <td class="acoes">
                            <a href="/pedidos/{{ $p['cod_pedido'] }}/itens" class="btn-detalhes">Ver Itens</a>

                            @if ($p['status'] == 0)
                                <form action="/pedidos/finalizar/{{ $p['cod_pedido'] }}" method="POST" style="margin:0">
                                    @csrf
                                    <button type="submit" class="btn-finalizar">Finalizar</button>
                                </form>
                            @else
                                <!-- Botão cinza desativado -->
                                <button class="btn-finalizado" disabled>Finalizado</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
