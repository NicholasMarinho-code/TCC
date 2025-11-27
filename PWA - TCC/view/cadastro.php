<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <div class="container">

        <h2>Cadastro</h2>

        <div class="form-group">
            <label>E-mail</label>
            <input type="email" id="emailCadastro" placeholder="Digite seu e-mail">
        </div>

        <div class="form-group">
            <label>Senha</label>
            <input type="password" id="senhaCadastro" placeholder="Crie uma senha">
        </div>

        <button id="btCadastrar" class="btn btn-outline">Criar Conta</button>

        <p class="link">
            <br>Já tem conta? <a href="login.php">Faça login</a>
        </p>

    </div>

    <script type="module" src="../app.js"></script>
</body>
</html>