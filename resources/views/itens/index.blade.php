<h1>Itens do Pedido {{ $cod_pedido }}</h1>


@if (session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif


{{-- Botão de finalizar pedido --}}
<form method="POST" action="{{ url('/pedidos/finalizar/' . $cod_pedido) }}" style="margin-bottom: 15px;">
    @csrf
    <button type="submit" style="background:green; color:white; padding:8px 15px; border:none; border-radius:4px; cursor:pointer;">
        Finalizar Pedido
    </button>

    <span style="margin-left:15px; font-weight:bold;">
        Total: R$ {{ number_format($valor_total, 2, ',', '.') }}
    </span>
</form>

<form method="POST" action="{{ url('/pedidos/' . $cod_pedido . '/itens/adicionar') }}" style="margin-bottom: 20px;">
    @csrf
    <label>Prato:</label>
    <input type="number" name="cod_prato" required>
    <label>Quantidade:</label>
    <input type="number" name="quantidade" required>
    <button type="submit" style="background:blue; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
        Adicionar
    </button>
</form>

<table border="1" cellpadding="6" style="width:100%; border-collapse:collapse;">
    <tr style="background:#f2f2f2;">
        <th>Prato</th>
        <th>Quantidade</th>
        <th>Valor Unitário</th>
        <th>Ações</th>
    </tr>

    @foreach ($itens as $item)
        <tr>
            <td>{{ $item['prato'] }}</td>
            <td>
                <form method="POST" action="{{ url('/pedidos/' . $cod_pedido . '/itens/' . $item['cod_prato'] . '/atualizar') }}" style="display:inline;">
                    @csrf
                    <input type="number" name="quantidade" value="{{ $item['quantidade'] }}" min="1" style="width:60px;">
                    <button type="submit" style="background:orange; color:white; border:none; padding:3px 6px; border-radius:3px; cursor:pointer;">
                        Salvar
                    </button>
                </form>
            </td>
            <td>{{ number_format($item['valor_unitario'], 2, ',', '.') }}</td>
            <td>
                <form method="POST" action="{{ url('/pedidos/' . $cod_pedido . '/itens/' . $item['cod_prato'] . '/excluir') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:red; color:white; border:none; padding:3px 6px; border-radius:3px; cursor:pointer;">
                        Excluir
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<br>
<a href="{{ url('/pedidos') }}" style="color:blue;">Voltar</a>
