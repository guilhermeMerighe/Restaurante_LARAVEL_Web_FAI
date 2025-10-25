<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Cliente</title>
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

        .form-cliente {
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

        .form-group input {
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
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Novo Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn-voltar">Voltar</a>
    </header>

    <main class="container">
        <form action="{{ route('clientes.store') }}" method="POST" class="form-cliente">
            @csrf

            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="telefone">
            </div>

            <div class="form-group">
                <label>CPF:</label>
                <input type="text" name="cpf" required>
            </div>

            <div class="form-group">
                <label>RG:</label>
                <input type="text" name="rg" required>
            </div>

            <div class="form-group">
                <label>Endereço:</label>
                <input type="text" name="endereco" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
