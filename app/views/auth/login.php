<?php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entre no Portal do IPIL</title>
    <link rel="stylesheet" href="../../../public/css/login-ipil.css">
</head>
<body>
    <main>
        <div class="login-wrapper">
            <img src="https://portal.ipil.ao/ipil_icon.png" alt="IPIL icon" class="login-logo">
            <h1 class="login-title">Entre no Portal do IPIL</h1>
            <p class="login-desc">Insira os seus dados de utilizador abaixo para fazer login</p>
            <form class="login-form" method="POST" autocomplete="off">
                <div>
                    <label class="login-label" for="utilizador">Email</label>
                    <input class="login-input" type="email" id="utilizador" name="email" placeholder="Digite o seu email" required autofocus>
                </div>
                <div>
                    <div class="login-actions">
                        <label class="login-label" for="senha">Palavra-passe</label>
                        <a href="./recover.php" class="login-link">Esqueceu a palavra-passe?</a>
                    </div>
                    <input class="login-input" type="password" id="senha" name="senha" placeholder="Digite sua palavra-passe" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <div class="login-footer">
                <span>Não tem conta?</span>
                <a href="./register.php">Cadastre-se</a>


            </div>
        </div>
    </main>
</body>
</html>