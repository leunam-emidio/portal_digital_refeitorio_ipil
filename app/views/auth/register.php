<?php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se no Portal do IPIL</title>
    <link rel="stylesheet" href="../../../public/css/login-ipil.css">
</head>
<body>
    <main>
        <div class="login-wrapper">
            <img src="https://portal.ipil.ao/ipil_icon.png" alt="IPIL icon" class="login-logo">
            <h1 class="login-title">Cadastre-se no Portal do IPIL</h1>
            <p class="login-desc">Preencha os dados abaixo para criar sua conta</p>
            <form class="login-form" method="POST" autocomplete="off">
                <div>
                    <label class="login-label" for="nome">Nome completo</label>
                    <input class="login-input" type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required autofocus>
                </div>
                <div>
                    <label class="login-label" for="email">Email</label>
                    <input class="login-input" type="email" id="email" name="email" placeholder="Digite seu email" required>
                </div>
                <div>
                    <label class="login-label" for="senha">Palavra-passe</label>
                    <input class="login-input" type="password" id="senha" name="senha" placeholder="Digite sua palavra-passe" required>
                </div>
                <div>
                    <label class="login-label" for="confirmar_senha">Confirmar palavra-passe</label>
                    <input class="login-input" type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua palavra-passe" required>
                </div>
                <button type="submit" class="login-btn">Cadastrar</button>
            </form>
            <div class="login-footer">
                <span>Já tem conta?</span>
                <a href="./login.php">Faça login</a>
            </div>
        </div>
    </main>
</body>
</html>