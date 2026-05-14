<?php

    
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
                <img src="https://portal.ipil.ao/ipil_icon.png" alt="IPIL Logo">
                Refeitório IPIL
            </a>
            <nav class="nav-links" aria-label="Menu principal">
                <a href="#menu">Cardápio</a>
                <a href="#sobre">Sobre</a>
            </nav>
            <div class="user-info">
                <div class="user-avatar">JS</div>
                <span>João Silva</span>
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
                <span class="hero-pill">Bem-vindo de volta, João! 👋</span>
                <h1>Explore o cardápio e compartilhe suas experiências.</h1>
                <p>Como usuário logado, você pode curtir pratos, deixar feedbacks e ver comentários de outros estudantes sobre o refeitório.</p>
                <div class="hero-actions">
                    <a href="#menu" class="btn btn-primary">Ver Cardápio</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80" alt="Refeitório acolhedor">
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
                <h3>Refeitório IPIL</h3>
                <p>Um ambiente acolhedor e nutritivo para estudantes, com menu pensado para o bem-estar diário.</p>
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
                <h3>Contato</h3>
                <p>Rua do Campus, 123</p>
                <p>(00) 1234-5678</p>
                <p>digitalrefeitorio@ipil.edu.br</p>
            </div>
        </div>
        <div class="container footer-bottom">
            <p>© 2026 Portal Digital do Refeitório IPIL</p>
            <p>Desenvolvido para facilitar seu dia a dia no refeitório.</p>
        </div>
    </footer>

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