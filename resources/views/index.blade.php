<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal - LaBuBurger</title>
    <link rel="stylesheet" href="{{ asset('css/style_novo.css') }}">
    <style>
        /* ======== ESTILOS ADICIONAIS ======== */
        .layout {
            display: flex;
            height: 100vh;
            background-color: #f7f7f7;
        }

        /* ======== MENU LATERAL ======== */
        .sidebar {
            width: 35%;
            max-width: 480px;
            background-color: #111;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        .sidebar img {
            width: 220px;
            height: auto;
            border-radius: 12px;
            margin-bottom: 40px;
            object-fit: cover;
        }

        .menu {
            width: 100%;
            margin-top: 20px;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 18px 30px;
            font-size: 18px;
            font-weight: 500;
            border-left: 5px solid transparent;
            transition: all 0.25s ease-in-out;
        }

        .menu a:hover {
            background-color: #333;
            border-left: 5px solid #ff9800;
        }

        /* ======== CONTEÚDO PRINCIPAL ======== */
        .conteudo {
            flex: 1;
            padding: 60px 80px;
            overflow-y: auto;
        }

        .conteudo h2 {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* ======== LISTA DE VENDAS ======== */
        .vendas-lista {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .venda-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 500;
            color: #333;
            cursor: pointer;
            transition: transform 0.15s ease-in-out, box-shadow 0.2s ease;
        }

        .venda-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            background-color: #fdfdfd;
        }

        .venda-nome {
            color: #222;
            font-weight: 600;
        }

        .venda-valor {
            color: #28a745;
            font-weight: 700;
            font-size: 19px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 100%;
                max-width: none;
                flex-direction: row;
                justify-content: space-between;
                padding: 20px;
            }

            .sidebar img {
                width: 100px;
            }

            .conteudo {
                padding: 30px;
            }

            .venda-item {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- MENU LATERAL -->
        <aside class="sidebar">
            <img src="{{ asset('images/labuburger.jpg') }}" alt="Logo LaBuBurger">
            <nav class="menu">
                <a href="{{ route('clientes.index') }}">Clientes</a>
                <a href="{{ url('/pratos') }}">Pratos</a>
                <a href="{{ url('/pedidos') }}">Pedidos</a>
                <a href="{{ route('ingredientes.index') }}">Ingredientes</a>
            </nav>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="conteudo">
            <h2>📊 Últimas Vendas</h2>

            <div class="vendas-lista">
                @php
                    use App\Models\Pedido;
                    $pedidoModel = new Pedido();
                    $vendas = $pedidoModel->listar();
                    $ultimasVendas = array_slice($vendas, 0, 15);
                @endphp

                @if (empty($ultimasVendas))
                    <p>Nenhuma venda registrada ainda.</p>
                @else
                    @foreach ($ultimasVendas as $venda)
                        <div class="venda-item" onclick="window.location='{{ url('/pedidos/' . $venda['cod_pedido'] . '/itens') }}'">
                            <span class="venda-nome">{{ $venda['cliente_nome'] }}</span>
                            <span class="venda-valor">R$ {{ number_format($venda['valor_total'], 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>
    </div>
</body>
</html>
