<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Prato</title>
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
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
        }
        input, select, button {
            padding: 8px 12px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
        .ingrediente-item {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .btn-remover {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Novo Prato</h1>
        <a href="{{ url('/pratos') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <form method="POST" action="{{ url('/pratos') }}">
            @csrf

            <label>Descrição:</label>
            <input type="text" name="descricao" required>

            <label>Valor Unitário:</label>
            <input type="number" step="0.01" name="valor_unitario" required>

            <h3>Composição</h3>
            <div id="ingredientes-lista">
                <div class="ingrediente-item">
                    <select name="ingredientes[]" onchange="verificarDuplicados(this)">
                        <option value="">-- Selecione um ingrediente --</option>
                        @foreach($ingredientes as $ing)
                            <option value="{{ $ing['cod_ingrediente'] }}">{{ $ing['descricao'] }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="quantidades[]" placeholder="Quantidade" min="1" required>
                    <button type="button" class="btn-remover" onclick="removerIngrediente(this)">X</button>
                </div>
            </div>

            <button type="button" class="btn-primary" onclick="adicionarIngrediente()">+ Ingrediente</button>

            <div class="btn-group">
                <button type="submit" class="btn-primary">Salvar</button>
                <a href="{{ url('/pratos') }}" class="btn-danger">Cancelar</a>
            </div>
        </form>
    </main>

    <script>
        function adicionarIngrediente() {
            const lista = document.getElementById('ingredientes-lista');
            const novo = lista.firstElementChild.cloneNode(true);
            novo.querySelector('input').value = '';
            novo.querySelector('select').selectedIndex = 0;
            lista.appendChild(novo);
        }

        function removerIngrediente(botao) {
            const lista = document.getElementById('ingredientes-lista');
            if (lista.children.length > 1) {
                botao.parentElement.remove();
            } else {
                alert('O prato deve ter pelo menos um ingrediente.');
            }
        }

        function verificarDuplicados(select) {
            const selects = document.querySelectorAll('select[name="ingredientes[]"]');
            const valores = [];
            for (let s of selects) {
                if (s.value !== "") {
                    if (valores.includes(s.value)) {
                        alert('Este ingrediente já foi adicionado!');
                        s.selectedIndex = 0;
                        return;
                    }
                    valores.push(s.value);
                }
            }
        }
    </script>
</body>
</html>
