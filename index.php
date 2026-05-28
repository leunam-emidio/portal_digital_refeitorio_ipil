<?php

    require_once __DIR__ . '/config/conn.php';
    require_once __DIR__ . '/app/controllers/AuthController.php';
    require_once __DIR__ . '/app/controllers/MenuController.php';
    require_once __DIR__ . '/app/controllers/ConfigController.php';
    require_once __DIR__ . '/app/controllers/FeedbackController.php';

    global $conn;

    $AuthController = new AuthController($conn);
    $MenuController = new MenuController($conn);
    $ConfigController = new ConfigController($conn);
    $FeedbackController = new FeedbackController($conn);

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

        case 'feedback_create':
            $FeedbackController->createFeedback();
            break;

        case 'menu_save':
            requireAdmin();
            $MenuController->saveMenu();
            exit;

        case 'menu_delete':
            requireAdmin();
            $MenuController->deleteMenu();
            exit;

        case 'user_status':
            requireAdmin();
            $AuthController->toggleUserStatus();
            exit;

        case 'user_delete':
            requireAdmin();
            $AuthController->deleteUser();
            exit;

        case 'feedback_delete':
            requireAdmin();
            $FeedbackController->deleteFeedback();
            exit;

        case 'config_save':
            requireAdmin();
            $ConfigController->saveConfig();
            exit;

    }

    function requireAdmin() {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Acesso negado.']);
            exit;
        }
    }

    function publicImagePath($path) {
        if (!$path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return 'imgs/ipil-icon.png';
        }

        return $path;
    }

    $configItem = $config[0] ?? [];
    $heroImage = publicImagePath($menus[0]['image'] ?? '');
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
                <img src="imgs/ipil-icon.png" alt="IPIL Logo" style="width: 60px; height: 60px; margin-right: 8px;">
                <p>
                    <?= htmlspecialchars($configItem['nome_refeitorio'] ?? 'Refeitório IPIL') ?>
                </p>
            </a>
            <nav class="nav-links" aria-label="Menu principal">
                <a href="#menu">Cardápio</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
                <div class="nav-actions nav-actions-mobile">
                    <a href="app/views/auth/login.php" class="btn btn-secondary">Login</a>
                    <a href="app/views/auth/register.php" class="btn btn-primary">Cadastro</a>
                </div>
            </nav>
            <div class="nav-actions nav-actions-desktop">
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
                    <?= htmlspecialchars($configItem['nome_refeitorio'] ?? 'Refeitório IPIL') ?>
                </span>
                <h1>
                    <?= htmlspecialchars($configItem['titulo_index'] ?? 'Portal Digital do Refeitório IPIL') ?>
                </h1>
                <p>
                    <?= htmlspecialchars($configItem['descricao_index'] ?? '') ?>
                </p>
                <div class="hero-actions">
                    <a href="app/views/auth/login.php" class="btn btn-primary">Entrar agora</a>
                    <a href="app/views/auth/register.php" class="btn btn-secondary">Criar conta</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="<?= htmlspecialchars($heroImage) ?>" alt="Prato do refeitório">
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
                    <img src="<?= htmlspecialchars(publicImagePath($menu['image'] ?? $menu['url'] ?? '')) ?>" alt="<?= htmlspecialchars($menu['name']) ?>">
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <div>
                                <h3 class="menu-card-title">
                                    <?= htmlspecialchars($menu['name']) ?>
                                </h3>
                                <p>
                                    <?= htmlspecialchars($menu['description']) ?>
                                </p>
                            </div>
                            <span class="menu-category">
                                <?= htmlspecialchars($menu['category']) ?>
                            </span>
                        </div>
                        <div class="menu-card-footer">
                            <span><?= htmlspecialchars($menu['weekdays'] ?? '') ?></span>
                            <span><?= htmlspecialchars($menu['tip'] ?? '') ?></span>
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
                    <?= htmlspecialchars($configItem['nome_refeitorio'] ?? 'Refeitório IPIL') ?>
                </h3>
                <p>
                    <?= htmlspecialchars($configItem['descricao_refeitorio'] ?? '') ?>
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
            <p>Desenvolvido por <strong>Emídio Manuel & Toni Kroos</strong> para facilitar seu dia a dia no refeitório.</p>
        </div>
    </footer>

    <script src="js/landing.js"></script>
</body>
</html>
