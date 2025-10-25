<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Itens do Pedido {{ $cod_pedido }}</title>
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

        .form-itens, .form-finalizar {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-itens input, .form-finalizar input {
            padding: 8px 12px;
            font-size: 16px;
        }

        .btn-finalizar, .btn-finalizado, .btn-adicionar, .btn-salvar, .btn-excluir {
            padding: 8px 16px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .btn-finalizar {
            background-color: #2ecc71;
        }

        .btn-finalizado {
            background-color: #f1c40f;
            cursor: not-allowed;
        }

        .btn-adicionar {
            background-color: #3498db;
        }

        .btn-salvar {
            background-color: #e67e22;
        }

        .btn-excluir {
            background-color: #e74c3c;
        }

        .tabela-itens {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabela-itens th, .tabela-itens td {
            padding: 12px 8px;
            font-size: 16px;
            text-align: left;
        }

        .tabela-itens th {
            background-color: #f0f0f0;
            color: #000;
        }

        .tabela-itens tr {
            border-bottom: 1px solid #e0e0e0;
        }

        .acoes-itens {
            display: flex;
            gap: 10px;
        }

        a.voltar {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #3498db;
            text-decoration: none;
        }

        a.voltar:hover {
            text-decoration: underline;
        }

        .total-span {
            font-weight: bold;
            font-size: 16px;
        }

        .info-finalizado {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Itens do Pedido {{ $cod_pedido }}</h1>
        <a href="{{ url('/pedidos') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        @if (session('error'))
            <script>alert("{{ session('error') }}");</script>
        @endif
        @if (session('success'))
            <script>alert("{{ session('success') }}");</script>
        @endif

        @if ($status == 0)
            
            <!-- Botão de finalizar pedido e total -->
            <form id="form-finalizar" class="form-finalizar">
                @csrf
                <button type="submit" class="btn-finalizar">Finalizar Pedido</button>
                <span class="total-span">Total: R$ {{ number_format($valor_total, 2, ',', '.') }}</span>

            </form>

            <script>
                document.getElementById('form-finalizar').addEventListener('submit', function(e) {
                    e.preventDefault(); // impede o envio normal do form

                    fetch("{{ url('/pedidos/finalizar/' . $cod_pedido) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success){
                            alert(data.success);
                            location.reload(); // atualiza a página para refletir o status finalizado
                        } else {
                            alert(data.error || 'Erro ao finalizar pedido.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Erro ao finalizar pedido.');
                    });
                });

            </script>

            <!-- Formulário para adicionar item -->
            <form method="POST" action="{{ url('/pedidos/' . $cod_pedido . '/itens/adicionar') }}" class="form-itens">
                @csrf
                <input type="number" name="cod_prato" placeholder="Código do Prato" required>
                <input type="number" name="quantidade" placeholder="Quantidade" required>
                <button type="submit" class="btn-adicionar">Adicionar</button>
            </form>
        @else
            <div class="form-finalizar">
                <button class="btn-finalizado" disabled>Finalizado</button>
                <span class="total-span">Total: R$ {{ number_format($valor_total, 2, ',', '.') }}</span>
            </div>
            <p class="info-finalizado">Não é mais possível adicionar novos itens para esse pedido.</p>
        @endif

        <!-- Tabela de itens -->
        <table class="tabela-itens">
            <thead>
                <tr>
                    <th>Prato</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itens as $item)
                    <tr>
                        <td>{{ $item['prato'] }}</td>
                        <td>
                            @if ($status == 0)
                                <form method="POST" action="{{ url('/pedidos/' . $cod_pedido . '/itens/' . $item['cod_prato'] . '/atualizar') }}" style="display:inline;">
                                    @csrf
                                    <input type="number" name="quantidade" value="{{ $item['quantidade'] }}" min="1" style="width:60px; padding:4px;">
                                    <button type="submit" class="btn-salvar">Salvar</button>
                                </form>
                            @else
                                {{ $item['quantidade'] }}
                            @endif
                        </td>
                        <td>{{ number_format($item['valor_unitario'], 2, ',', '.') }}</td>
                        <td class="acoes-itens">
                            @if ($status == 0)
                                <form method="POST" action="{{ url('/pedidos/' . $cod_pedido . '/itens/' . $item['cod_prato'] . '/excluir') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-excluir">Excluir</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </main>
</body>
</html>
