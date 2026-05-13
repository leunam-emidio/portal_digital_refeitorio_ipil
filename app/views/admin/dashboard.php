<?php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
        <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar">
            <img src="imagens/admin.png">
            <h2 style="text-align:center;">Administrador</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Gerenciar Pratos</a></li>
                <li><a href="#">Adicionar Cardápio</a></li>
                <li><a href="#">Editar Cardápio</a></li>
                <li><a href="#">Remover Cardápio</a></li>
                <li><a href="#">Feedbacks</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="card">
                <h1 style="color:#0b7a35;">Painel Administrativo</h1>
                <input type="text" placeholder="Nome do prato">
                <input type="text" placeholder="Descrição do prato">
                <input type="text" placeholder="Dia do cardápio">
                <input type="file">
                <button>Adicionar Prato</button>
            </div>
            <div class="feedback-card">
                <h2>Feedbacks dos Usuários</h2>
                <p><strong>António:</strong> A comida estava ótima.</p>
                <hr><br>
                <p><strong>Maria:</strong> Gostei muito do prato de hoje.</p>
            </div>
        </div>
    </div>
</body>
</html>