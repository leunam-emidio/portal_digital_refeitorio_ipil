<?php

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <div class="form-container">
        <div class="card">
            <h1 style="text-align:center;color:#0b7a35;">LOGIN</h1>
            <input type="email" id="email" placeholder="Digite o email">
            <input type="password" id="senha" placeholder="Digite a senha">
            <button onclick="login()">Entrar</button>
            <div id="loading" class="loading">
                Carregando dashboard...
            </div>
            <div class="link">
                <a href="./cadastro.php">Criar Conta</a>
            </div>
            <div class="link">
                <a href="./recuperar.php">Esqueci minha senha</a>
            </div>
        </div>
    </div>
    <script src="../../../public/js/script.js"></script>
</body>
</html>