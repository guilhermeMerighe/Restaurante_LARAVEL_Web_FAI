<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/style_base.css') }}">
</head>
<body>
    <header class="header">
        <h1>Detalhes do Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn-voltar">← Voltar</a>
    </header>

    <section class="cliente-info">
        <h2>{{ $cliente['nome'] }}</h2>
        <p><strong>Telefone:</strong> {{ $cliente['telefone'] }}</p>
        <p><strong>Email:</strong> {{ $cliente['email'] }}</p>
    </section>

    <section class="pedidos">
        <h3>Pedidos</h3>

        @if (count($pedidos) > 0)
            <table class="tabela-pedidos">
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
            <p>Nenhum pedido encontrado.</p>
        @endif
    </section>
</body>
</html>
