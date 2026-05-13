<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Menu | Refeitório IPIL</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <style>
        body {
            background: linear-gradient(180deg, #f4f4f4 0%, #e8f6ea 100%);
        }
        .page-header {
            padding: 30px 0;
            background: #0b7a35;
            color: #ffffff;
            box-shadow: 0 12px 45px rgba(0, 0, 0, 0.08);
        }
        .page-header .logo {
            font-size: 30px;
            letter-spacing: 0.05em;
        }
        .page-header nav a {
            color: #ffffff;
            text-decoration: none;
            margin-left: 24px;
            font-weight: 600;
        }
        .menu-builder {
            display: grid;
            grid-template-columns: 1.4fr 0.9fr;
            gap: 28px;
            margin: 40px auto;
            width: min(1120px, calc(100% - 32px));
        }
        .menu-card,
        .summary-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 18px 50px rgba(0,0,0,0.08);
            padding: 30px;
        }
        .menu-card h1,
        .summary-card h2 {
            margin-bottom: 16px;
            font-size: 28px;
            color: #0b7a35;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }
        .form-grid-full {
            grid-column: 1 / -1;
        }
        label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }
        .input-group {
            margin-bottom: 18px;
        }
        .input-group input,
        .input-group textarea,
        .input-group select {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #d8e1da;
            border-radius: 14px;
            background: #fbfbfb;
            color: #1d1d1d;
            font-size: 15px;
        }
        .input-group textarea {
            min-height: 140px;
            resize: vertical;
        }
        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
            margin-top: 12px;
        }
        .btn-submit {
            background: #0b7a35;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 15px 24px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .btn-submit:hover {
            background: #095d29;
        }
        .secondary-note {
            color: #6b6b6b;
            font-size: 14px;
        }
        .summary-card p {
            margin-top: 12px;
            line-height: 1.65;
            color: #4d4d4d;
        }
        .summary-list {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
        }
        .summary-list li {
            display: flex;
            justify-content: space-between;
            padding: 14px 16px;
            border: 1px solid #e7efea;
            border-radius: 14px;
            margin-bottom: 12px;
            background: #f9fdf8;
        }
        .summary-list span {
            font-weight: 700;
            color: #0b7a35;
        }
        @media (max-width: 920px) {
            .menu-builder {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="page-header">
        <div class="container">
            <div class="admin-layout">
                <div class="logo">Refeitório IPIL</div>
                <nav>
                    <a href="../../home/index.php">Home</a>
                    <a href="../menu/index.php">Menus</a>
                    <a href="../feedback/index.php">Feedback</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="menu-builder">
            <article class="menu-card">
                <h1>Criar novo cardápio</h1>
                <p class="secondary-note">Adicione os itens do menu do refeitório com descrição, categoria e opções de disponibilidade.</p>

                <form action="" method="POST" enctype="multipart/form-data" class="form-card">
                    <div class="form-grid">
                        <div class="input-group">
                            <label for="dish_name">Nome do prato</label>
                            <input type="text" id="dish_name" name="dish_name" placeholder="Ex: Arroz com feijão" required>
                        </div>
                        <div class="input-group">
                            <label for="category">Categoria</label>
                            <select id="category" name="category" required>
                                <option value="">Selecione a categoria</option>
                                <option value="principal">Prato Principal</option>
                                <option value="acompanhamento">Acompanhamento</option>
                                <option value="sobremesa">Sobremesa</option>
                                <option value="bebida">Bebida</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="menu_date">Dia do menu</label>
                            <select id="menu_date" name="menu_date" required>
                                <option value="">Escolha o dia</option>
                                <option value="segunda">Segunda-feira</option>
                                <option value="terca">Terça-feira</option>
                                <option value="quarta">Quarta-feira</option>
                                <option value="quinta">Quinta-feira</option>
                                <option value="sexta">Sexta-feira</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="price">Preço unitário</label>
                            <input type="number" id="price" name="price" step="0.01" placeholder="0,00" required>
                        </div>
                        <div class="input-group form-grid-full">
                            <label for="description">Descrição do prato</label>
                            <textarea id="description" name="description" placeholder="Descreva brevemente o prato e os ingredientes principais" required></textarea>
                        </div>
                        <div class="input-group form-grid-full">
                            <label for="image">Imagem do prato</label>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn-submit" type="submit" name="submit">Salvar cardápio</button>
                        <span class="secondary-note">Você pode adicionar mais de um item após salvar.</span>
                    </div>
                </form>
            </article>

            <aside class="summary-card">
                <h2>Resumo rápido</h2>
                <p>Use esta tela para criar menus semanais com itens organizados por categoria e dia. O formulário foi pensado para ser claro e responsivo, ideal para uso em desktops e tablets.</p>

                <ul class="summary-list">
                    <li><span>Nome</span><span>Obrigatório</span></li>
                    <li><span>Categoria</span><span>Prato, Bebida, Sobremesa</span></li>
                    <li><span>Dia</span><span>Segunda a Sexta</span></li>
                    <li><span>Imagem</span><span>Opcional</span></li>
                </ul>
            </aside>
        </section>
    </main>

    <footer class="footer">
        <div class="container">Copyright &copy; 2026 Refeitório IPIL</div>
    </footer>
</body>
</html>
