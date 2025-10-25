<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Ingrediente</title>
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

        .form-ingrediente {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
        }

        .btn-primary {
            background-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Novo Ingrediente</h1>
        <a href="{{ url('/ingredientes') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <form method="POST" action="{{ url('/ingredientes') }}" class="form-ingrediente">
            @csrf

            <div class="form-group">
                <label>Descrição:</label>
                <input type="text" name="descricao" required maxlength="30">
            </div>

            <div class="form-group">
                <label>Unidade de Medida:</label>
                <select name="unidade" required>
                    <option value="0">Unidade</option>
                    <option value="1">Kg</option>
                </select>
            </div>

            <div class="form-group">
                <label>Valor Unitário (R$):</label>
                <input type="number" name="valor_unitario" step="0.01" min="0" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ url('/ingredientes') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
