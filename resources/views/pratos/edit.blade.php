<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Prato</title>
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
        input, button {
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
            padding: 8px 15px;
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
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Editar Prato</h1>
        <a href="{{ url('/pratos') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <form method="POST" action="{{ url('/pratos/'.$prato['cod_prato']) }}">
            @csrf

            <label>Descrição:</label>
            <input type="text" name="descricao" value="{{ $prato['descricao'] }}" required>

            <label>Valor Unitário:</label>
            <input type="number" step="0.01" name="valor_unitario" value="{{ $prato['valor_unitario'] }}" required>

            <div class="btn-group">
                <button type="submit" class="btn-primary">Salvar Alterações</button>
                <a href="{{ url('/pratos') }}" class="btn-danger">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
