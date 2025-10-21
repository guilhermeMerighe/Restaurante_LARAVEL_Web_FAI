<h1>Pedidos</h1>

<form method="POST" action="/pedidos/criar">
    @csrf
    <label>Cliente:</label>
    <input type="number" name="cod_cliente" required>
    <button type="submit">Criar Pedido</button>
</form>

<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Data</th>
        <th>Valor Total</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>
    @foreach ($pedidos as $p)
    <tr>
        <td>{{ $p['cod_pedido'] }}</td>
        <td>{{ $p['cliente_nome'] }}</td>
        <td>{{ $p['data_pedido'] }}</td>
        <td>{{ $p['valor_total'] }}</td>
        <td>{{ $p['status'] == 0 ? 'Aberto' : 'Fechado' }}</td>
        <td>
            <a href="/pedidos/{{ $p['cod_pedido'] }}/itens">Ver Itens</a>
            @if ($p['status'] == 0)
            <form action="/pedidos/finalizar/{{ $p['cod_pedido'] }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Finalizar</button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>
