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
    <main class="container">
        <div class="page-title">
            <div>
                <h1>Cardápios disponíveis</h1>
                <p class="secondary-note">Visualize e gerencie os menus semanais do refeitório com dados de categoria, dia e status.</p>
            </div>
            <a href="create.php" class="button-primary">Adicionar novo menu</a>
        </div>

        <section class="overview-panel">
            <div class="overview-widget">
                <h3>Menus ativos</h3>
                <p>18</p>
            </div>
            <div class="overview-widget">
                <h3>Pratos cadastrados</h3>
                <p>54</p>
            </div>
            <div class="overview-widget">
                <h3>Atualizado hoje</h3>
                <p>3</p>
            </div>
        </section>

        <section class="menu-grid">
            <article class="menu-card">
                <h2>Segunda-feira</h2>
                <p>Prato principal: Arroz com feijão. Acompanhamento: Saladinha fresca. Sobremesa: Gelatina de fruta.</p>
                <div class="menu-meta">
                    <span>Principal</span>
                    <span>Segunda</span>
                    <span class="status-pill status-active">Visível</span>
                </div>
            </article>
            <article class="menu-card">
                <h2>Terça-feira</h2>
                <p>Prato principal: Frango grelhado com legumes. Acompanhamento: Purê de batata. Bebida: Suco natural.</p>
                <div class="menu-meta">
                    <span>Principal</span>
                    <span>Terça</span>
                    <span class="status-pill status-active">Visível</span>
                </div>
            </article>
            <article class="menu-card">
                <h2>Quarta-feira</h2>
                <p>Prato principal: Peixe ao molho leve. Acompanhamento: Arroz integral. Sobremesa: Frutas da estação.</p>
                <div class="menu-meta">
                    <span>Principal</span>
                    <span>Quarta</span>
                    <span class="status-pill status-active">Visível</span>
                </div>
            </article>
        </section>

        <section class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Prato</th>
                        <th>Categoria</th>
                        <th>Dia</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Arroz com feijão</td>
                        <td>Principal</td>
                        <td>Segunda</td>
                        <td>R$ 8,50</td>
                        <td><span class="status-pill status-active">Ativo</span></td>
                        <td class="action-buttons"><a href="edit.php?id=1">Editar</a><a href="#">Remover</a></td>
                    </tr>
                    <tr>
                        <td>Salada de legumes</td>
                        <td>Acompanhamento</td>
                        <td>Segunda</td>
                        <td>R$ 4,00</td>
                        <td><span class="status-pill status-active">Ativo</span></td>
                        <td class="action-buttons"><a href="edit.php?id=2">Editar</a><a href="#">Remover</a></td>
                    </tr>
                    <tr>
                        <td>Bife de carne</td>
                        <td>Principal</td>
                        <td>Terça</td>
                        <td>R$ 10,00</td>
                        <td><span class="status-pill status-active">Ativo</span></td>
                        <td class="action-buttons"><a href="edit.php?id=3">Editar</a><a href="#">Remover</a></td>
                    </tr>
                    <tr>
                        <td>Suco natural</td>
                        <td>Bebida</td>
                        <td>Terça</td>
                        <td>R$ 3,50</td>
                        <td><span class="status-pill status-archived">Inativo</span></td>
                        <td class="action-buttons"><a href="edit.php?id=4">Editar</a><a href="#">Remover</a></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>