<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Ingrediente</title>
    <link rel="stylesheet" href="{{ asset('css/style_base.css') }}">
</head>
<body>
    <header class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        Novo Ingrediente
    </header>

    <div class="container">
        <form method="POST" action="{{ url('/ingredientes') }}">
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

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ url('/ingredientes') }}" class="btn btn-danger" style="margin-left:10px;">Cancelar</a>
        </form>
    </div>
</body>
</html>
