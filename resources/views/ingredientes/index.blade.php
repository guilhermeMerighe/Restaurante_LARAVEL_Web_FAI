<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ingredientes</title>
    <link rel="stylesheet" href="{{ asset('css/style_base.css') }}">
</head>
<body>
    <header class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        Ingredientes
    </header>

    <div class="container">
        @if (session('success'))
            <div class="text-success" style="margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ url('/ingredientes/novo') }}" class="btn btn-primary">
            Novo Ingrediente
        </a>

        <table class="table">
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
                    <td>
                        <form method="POST" action="{{ url('/ingredientes/' . $ing['cod_ingrediente'] . '/adicionar') }}" style="display:inline;">
                            @csrf
                            <input type="number" name="quantidade" min="1" placeholder="Qtd" required style="width:70px;">
                            <button type="submit" class="btn btn-info">
                                + Estoque
                            </button>
                        </form>

                        <form method="POST" action="{{ url('/ingredientes/' . $ing['cod_ingrediente'] . '/excluir') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Remover este ingrediente?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
