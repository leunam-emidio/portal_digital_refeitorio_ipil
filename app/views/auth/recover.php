<?php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar palavra-passe | Refeitório  IPIL</title>
    <link rel="stylesheet" href="../../../public/css/login-ipil.css">
</head>
<body>
    <main>
        <div class="login-wrapper">
            <img src="../../../public/imgs/ipil-icon.png" alt="IPIL icon" class="login-logo">
            <h1 class="login-title">Recuperar palavra-passe</h1>
            <p class="login-desc">Insira o seu utilizador ou email para receber instruções de recuperação</p>
            <form class="login-form" method="POST" autocomplete="off">
                <div>
                    <label class="login-label" for="utilizador_email">Utilizador ou Email</label>
                    <input class="login-input" type="text" id="utilizador_email" name="utilizador_email" placeholder="Digite seu utilizador ou email" required autofocus>
                </div>
                <button type="submit" class="login-btn">Enviar instruções</button>
            </form>
            <div class="login-footer">
                <a href="./login.php">Voltar ao login</a>
            </div>
        </div>
    </main>
</body>
</html>