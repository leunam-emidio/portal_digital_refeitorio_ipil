<?php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se no Portal do IPIL</title>
    <link rel="stylesheet" href="../../../css/login-ipil.css">
</head>
<body>
    <main>
        <div class="login-wrapper">
            <img src="../../../imgs/ipil-icon.png" alt="IPIL icon" class="login-logo">
            <h1 class="login-title">Cadastre-se no Portal do IPIL</h1>
            <p class="login-desc">Preencha os dados abaixo para criar sua conta</p>
            <form action="../../../index.php?action=register" class="login-form" method="POST" autocomplete="on">
                <div>
                    <label class="login-label" for="name">Nome completo</label>
                    <input class="login-input" type="text" id="nome" name="name" placeholder="Digite seu nome completo" required autofocus>
                </div>
                <div>
                    <label class="login-label" for="email">Email</label>
                    <input class="login-input" type="email" id="email" name="email" placeholder="Digite seu email" required>
                </div>
                <div>
                    <label class="login-label" for="password">Palavra-passe</label>
                    <input class="login-input" type="password" id="senha" name="password" placeholder="Digite sua palavra-passe" required>
                </div>
                <div>
                    <label class="login-label" for="passwordConfirm">Confirmar palavra-passe</label>
                    <input class="login-input" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirme sua palavra-passe" required>
                </div>
                <button type="submit" class="login-btn">Cadastrar</button>
            </form>
            <div class="login-footer">
                <span>Já tem conta?</span>
                <a href="./login.php">Faça login</a>
            </div>
        </div>
    </main>
      <?php
        if (isset($_GET['error'])) {
            echo "
            <script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'register.php';
            </script>
            ";
        }
    ?>
</body>
</html>
