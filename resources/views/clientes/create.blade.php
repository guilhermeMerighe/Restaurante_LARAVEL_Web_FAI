<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/style_base.css') }}">
</head>
<body>
    <header class="header">
        <h1>Novo Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn btn-info">← Voltar</a>
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

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </main>
</body>
</html>
