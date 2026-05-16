<?php

    require_once __DIR__ . '/config/conn.php';
    require_once __DIR__ . '/app/controllers/AuthController.php';
    require_once __DIR__ . '/app/controllers/MenuController.php';
    require_once __DIR__ . '/app/controllers/ConfigController.php';

    global $conn;

    $AuthController = new AuthController($conn);
    $MenuController = new MenuController($conn);
    $ConfigController = new ConfigController($conn);

    $menus = $MenuController->listMenus();
    $config = $ConfigController->listConfig();

    $action = $_GET['action'] ?? '';

    switch ($action) {

        case 'login':
            $AuthController->login();
            break;

        case 'register':
            $AuthController->register();
            break;

        case 'dashboard':
            $AuthController->dashboard();
            break;

        case 'logout':
            $AuthController->logout();
            break;

    }
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Digital do Refeitório | IPIL</title>
    <link rel="stylesheet" href="css/landing.css">
</head>
<body>
    <header class="header">
        <div class="container navbar">
            <a href="#home" class="logo">
                <img src="https://portal.ipil.ao/ipil_icon.png" alt="IPIL Logo" style="width: 60px; height: 60px; margin-right: 8px;">
                <p>
                    <?= $config[0]['nome_refeitorio'] ?>
                </p>
            </a>
            <nav class="nav-links" aria-label="Menu principal">
                <a href="#menu">Cardápio</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
            </nav>
            <div class="nav-actions">
                <a href="app/views/auth/login.php" class="btn btn-secondary">Login</a>
                <a href="app/views/auth/register.php" class="btn btn-primary">Cadastro</a>
            </div>
            <button class="burger" aria-label="Abrir menu">
                <span></span>
            </button>
        </div>
    </header>

    <main class="container">
        <section class="hero" id="home">
            <div class="hero-copy">
                <span class="hero-pill">
                    <?= $config[0]['nome_refeitorio'] ?>
                </span>
                <h1>
                    <?= $config[0]['titulo_destacar'] ?>
                </h1>
                <p>
                    <?= $config[0]['descricao_cardapio'] ?>
                </p>
                <div class="hero-actions">
                    <a href="app/views/auth/login.php" class="btn btn-primary">Entrar agora</a>
                    <a href="app/views/auth/register.php" class="btn btn-secondary">Criar conta</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" alt="Prato saudável do refeitório">
            </div>
        </section>

        <section id="menu">
            <div class="section-title">
                <div>
                    <h2>Cardápio da semana</h2>
                    <p>Explore os pratos em destaque para hoje e os dias seguintes. Sem necessidade de login para visualizar.</p>
                </div>
                <span class="info-pill">Visualização pública</span>
            </div>

            <div class="menu-grid">
                <?php foreach($menus as $menu): ?>
                <article class="menu-card">
                    <img src="https://images.unsplash.com/photo-1562967916-eb82221dfb25?auto=format&fit=crop&w=800&q=80" alt="Arroz com feijão e carne">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <div>
                                <h3 class="menu-card-title">
                                    <?= $menu['name'] ?>
                                </h3>
                                <p>
                                    <?= $menu['description'] ?>
                                </p>
                            </div>
                            <span class="menu-category">
                                <?= $menu['category'] ?>
                            </span>
                        </div>
                        <div class="menu-card-footer">
                            <span><?= $menu['weekdays'] ?></span>
                            <span><?= $menu['tip'] ?></span>
                        </div>
                    </div>
                </article>
                <?php endforeach ?>
            </div>
        </section>

        <section id="sobre" class="section-title">
            <div>
                <h2>Por que usar o Portal</h2>
                <p>O Portal Digital facilita o acesso ao cardápio, ajuda no planejamento das refeições e garante transparência sobre o que será servido no refeitório.</p>
            </div>
        </section>
    </main>

    <footer class="footer" id="contato">
        <div class="container footer-grid">
            <div>
                <h3>
                    <?= $config[0]['nome_refeitorio'] ?>
                </h3>
                <p>
                    <?= $config[0]['descricao_refeitorio'] ?>
                </p>
            </div>
            <div>
                <h3>Links úteis</h3>
                <ul class="footer-links">
                    <li><a href="../app/views/auth/login.php">Login</a></li>
                    <li><a href="../app/views/auth/register.php">Cadastro</a></li>
                    <li><a href="#menu">Cardápio</a></li>
                </ul>
            </div>
            <div>
                <h3>Contato</h3>
                <p>IPIL</p>
                <p>(+244) 924 672 777</p>
                <p>digitalrefeitorio@ipil.edu</p>
            </div>
        </div>
        <div class="container footer-bottom">
            <p>© 2026 Portal Digital do Refeitório IPIL</p>
            <p>Desenvolvido para facilitar seu dia a dia no refeitório.</p>
        </div>
    </footer>

    <script src="js/landing.js"></script>
</body>
</html>
