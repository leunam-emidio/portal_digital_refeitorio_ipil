<?php
    
    if (isset($_SESSION['user_name'])) {
        header('Location: ../auth/login.php');
        exit;
    }

    require_once __DIR__ . '/../../../config/conn.php';
    require_once __DIR__ . '/../../controllers/AuthController.php';
    require_once __DIR__ . '/../../controllers/MenuController.php';
    require_once __DIR__ . '/../../controllers/ConfigController.php';
    require_once __DIR__ . '/../../controllers/FeedbackController.php';

    global $conn;

    $AuthController = new AuthController($conn);
    $MenuController = new MenuController($conn);
    $FeedbacksController = new FeedbackController($conn);
    $ConfigController = new ConfigController($conn);

    $menus = $MenuController->listMenus();
    $config = $ConfigController->listConfig();
    $feedbacks = $FeedbacksController->listFeedbacks();
    $configItem = $config[0] ?? [];
    $heroImage = $menus[0]['url'] ?? 'imgs/ipil-icon.png';
    if (!$heroImage || str_starts_with($heroImage, 'http://') || str_starts_with($heroImage, 'https://')) {
        $heroImage = 'imgs/ipil-icon.png';
    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Refeitório | IPIL</title>
    <link rel="stylesheet" href="../../../css/home-logged.css">
</head>
<body>
    <header class="header">
        <div class="container navbar">
            <a href="#home" class="logo">
                <img src="../../../imgs/ipil-icon.png" alt="IPIL Logo">
                <?= htmlspecialchars($configItem['nome_refeitorio'] ?? 'Refeitório IPIL') ?>
            </a>
            <nav class="nav-links" aria-label="Menu principal">
                <a href="#menu">Cardápio</a>
                <a href="#sobre">Sobre</a>
            </nav>
            <div class="user-info">
                <div class="user-avatar">
                    <?= ucwords($_SESSION['user_name'][0]) ?>
                </div>
                <span>
                    <?= ucwords($_SESSION['user_name']) ?>
                </span>
                <button class="btn btn-logout" onclick="logout()">Logout</button>
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
                    <?= htmlspecialchars($configItem['boas_vinda'] ?? 'Bem-vindo') ?>
                    , <?= htmlspecialchars(ucwords($_SESSION['user_name'])) ?>!!!</span>
                <h1>
                    <?= htmlspecialchars($configItem['titulo_home'] ?? '') ?>
                </h1>
                <p>
                    <?= htmlspecialchars($configItem['descricao_home'] ?? '') ?>
                </p>
                <div class="hero-actions">
                    <a href="#menu" class="btn btn-primary">Ver Cardápio</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="../../../<?= htmlspecialchars($heroImage) ?>" alt="Refeitório acolhedor">
            </div>
        </section>

        <section id="menu">
            <div class="section-title">
                <div>
                    <h2>Cardápio interativo</h2>
                    <p>Curta seus pratos favoritos e deixe seu feedback para ajudar outros estudantes</p>
                </div>
                <span class="info-pill">Interações disponíveis</span>
            </div>

            <div id="menu-grid" class="menu-grid">
                <!-- Menu cards will be populated by JavaScript -->
            </div>
        </section>

        <section id="sobre" class="section-title">
            <div>
                <h2>Sobre o Portal</h2>
                <p>O Portal Digital facilita o acesso ao cardápio, ajuda no planejamento das refeições e garante transparência sobre o que será servido no refeitório.</p>
            </div>
        </section>
    </main>

    <!-- Feedback Modal -->
    <div id="feedback-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title" class="modal-title">Deixar feedback</h3>
                <button id="modal-close" class="modal-close">&times;</button>
            </div>
            <form id="feedback-form" class="feedback-form">
                <textarea
                    id="feedback-textarea"
                    placeholder="Compartilhe sua opinião sobre este prato..."
                    required
                ></textarea>
                <button type="submit" class="btn btn-primary">Enviar Feedback</button>
            </form>
        </div>
    </div>

    <!-- Dish Feedbacks Modal -->
    <div id="dish-feedbacks-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="dish-feedbacks-modal-title" class="modal-title">Feedbacks do prato</h3>
                <button id="dish-feedbacks-modal-close" class="modal-close">&times;</button>
            </div>
            <div id="dish-feedbacks-container" class="dish-feedbacks">
                <!-- Feedbacks will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <footer class="footer">
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
                    <li><a href="#menu">Cardápio</a></li>
                    <li><a href="#feedbacks">Feedbacks</a></li>
                    <li><a href="../menu/index.php">Gerenciar Menus</a></li>
                </ul>
            </div>
            <div>
                <h3>Contatos</h3>
                <p>IPIL</p>
                <p>924 672 777</p>
                <p>digitalrefeitorio@ipil.edu</p>
            </div>
        </div>
        <div class="container footer-bottom">
            <p>© 2026 Portal Digital do Refeitório IPIL</p>
            <p>Desenvolvido para facilitar seu dia a dia no refeitório.</p>
        </div>
    </footer>

    <script>
        window.portalData = {
            dishes: <?= json_encode($menus, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>,
            feedbacks: <?= json_encode($feedbacks, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>
        };
    </script>
    <script src="../../../js/home-logged.js"></script>
    <script>
        function logout() {
            if (confirm('Tem certeza que deseja sair?')) {
                window.location.href = '../../../index.php?action=logout';
            }
        }
    </script>
</body>
</html>
