<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador | Refeitório IPIL</title>
    <link rel="stylesheet" href="../../../public/css/admin-dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                   <img src="../../../public/imgs/ipil-icon.png" alt="IPIL icon" class="login-logo">
                    Portal Admin
                </div>
                <div class="sidebar-user">
                    <div class="sidebar-avatar">AD</div>
                    <div class="sidebar-user-info">
                        <h4>Admin</h4>
                        <p>Administrador</p>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="#" class="nav-link active" data-section="overview">
                        <i>📊</i>
                        Visão Geral
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="menu">
                        <i>🍽️</i>
                        Gerenciar Cardápio
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="users">
                        <i>👥</i>
                        Gerenciar Usuários
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="feedbacks">
                        <i>💬</i>
                        Gerenciar Feedbacks
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="reports">
                        <i>📈</i>
                        Relatórios
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="settings">
                        <i>⚙️</i>
                        Configurações
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Overview Section -->
            <section id="overview" class="section">
                <div class="header">
                    <h1>Dashboard Administrativo</h1>
                    <div class="header-actions">
                        <button class="btn btn-secondary" onclick="location.reload()">
                            <i>🔄</i>
                            Atualizar
                        </button>
                        <button class="btn btn-logout" onclick="logout()">
                            <i>🚪</i>
                            Logout
                        </button>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon users">👥</div>
                        </div>
                        <div class="stat-value" id="total-users">0</div>
                        <div class="stat-label">Usuários Cadastrados</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon dishes">🍽️</div>
                        </div>
                        <div class="stat-value" id="total-dishes">0</div>
                        <div class="stat-label">Pratos no Cardápio</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon feedbacks">💬</div>
                        </div>
                        <div class="stat-value" id="today-feedbacks">0</div>
                        <div class="stat-label">Feedbacks Hoje</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon likes">❤️</div>
                        </div>
                        <div class="stat-value" id="top-dish">-</div>
                        <div class="stat-label">Prato Mais Curtido</div>
                    </div>
                </div>
            </section>

            <!-- Menu Management Section -->
            <section id="menu" class="section" style="display: none;">
                <div class="header">
                    <h1>Gerenciamento do Cardápio</h1>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2 class="table-title">Pratos Cadastrados</h2>
                        <div class="table-actions">
                            <select id="dish-filter" class="filter-select">
                                <option value="">Todas as categorias</option>
                                <option value="Prato Principal">Prato Principal</option>
                                <option value="Acompanhamento">Acompanhamento</option>
                                <option value="Sobremesa">Sobremesa</option>
                                <option value="Bebida">Bebida</option>
                            </select>
                            <button class="btn btn-primary" onclick="addDish()">
                                <i>➕</i>
                                Adicionar Prato
                            </button>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="dishes-tbody">
                            <!-- Dishes will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- User Management Section -->
            <section id="users" class="section" style="display: none;">
                <div class="header">
                    <h1>Gerenciamento de Usuários</h1>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2 class="table-title">Usuários Cadastrados</h2>
                        <div class="table-actions">
                            <input type="text" id="user-search" class="search-input" placeholder="Buscar por nome ou email...">
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data de Cadastro</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="users-tbody">
                            <!-- Users will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Feedback Management Section -->
            <section id="feedbacks" class="section" style="display: none;">
                <div class="header">
                    <h1>Gerenciamento de Feedbacks</h1>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2 class="table-title">Feedbacks Recebidos</h2>
                        <div class="table-actions">
                            <select id="feedback-filter" class="filter-select">
                                <option value="">Todos os feedbacks</option>
                                <option value="today">Apenas hoje</option>
                                <!-- Dish options will be populated by JavaScript -->
                            </select>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Prato</th>
                                <th>Comentário</th>
                                <th>Data</th>
                                <th>Curtidas</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="feedbacks-tbody">
                            <!-- Feedbacks will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Reports Section -->
            <section id="reports" class="section" style="display: none;">
                <div class="header">
                    <h1>Relatórios e Gráficos</h1>
                </div>

                <div class="charts-grid">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Pratos Mais Curtidos</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="likes-chart" width="400" height="300"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Feedbacks por Dia da Semana</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="feedbacks-chart" width="400" height="300"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Distribuição por Categoria</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="categories-chart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="section" style="display: none;">
                <div class="header">
                    <h1>Configurações do Portal</h1>
                </div>

                <div class="settings-section">
                    <form id="settings-form">
                        <div class="settings-group">
                            <h3 class="settings-title">Informações do Refeitório</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label" for="restaurant-name">Nome do Refeitório</label>
                                    <input type="text" id="restaurant-name" name="restaurantName" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="opening-hours">Horário de Funcionamento</label>
                                    <input type="text" id="opening-hours" name="openingHours" class="form-input" placeholder="Ex: 07:00 - 19:00" required>
                                </div>
                            </div>
                        </div>

                        <div class="settings-group">
                            <h3 class="settings-title">Mensagens e Conteúdo</h3>
                            <div class="form-group full-width">
                                <label class="form-label" for="welcome-message">Mensagem de Boas-vindas</label>
                                <textarea id="welcome-message" name="welcomeMessage" class="form-textarea" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="settings-actions">
                            <button type="submit" class="btn btn-primary">
                                <i>💾</i>
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Dish Modal -->
    <div id="dish-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="dish-modal-title" class="modal-title">Adicionar Prato</h2>
                <button class="modal-close">&times;</button>
            </div>

            <form id="dish-form" onsubmit="saveDish(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="dish-name">Nome do Prato</label>
                        <input type="text" id="dish-name" name="name" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dish-category">Categoria</label>
                        <select id="dish-category" name="category" class="form-select" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="Prato Principal">Prato Principal</option>
                            <option value="Acompanhamento">Acompanhamento</option>
                            <option value="Sobremesa">Sobremesa</option>
                            <option value="Bebida">Bebida</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="dish-description">Descrição</label>
                        <textarea id="dish-description" name="description" class="form-textarea" required></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="dish-image">URL da Imagem</label>
                        <input type="url" id="dish-image" name="image" class="form-input" placeholder="https://exemplo.com/imagem.jpg">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dish-status">Status</label>
                        <select id="dish-status" name="status" class="form-select" required>
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 Portal Digital do Refeitório IPIL - Dashboard Administrativo v1.0</p>
    </footer>

    <script src="../../../public/js/admin-dashboard.js"></script>
    <script>
        function logout() {
            if (confirm('Tem certeza que deseja sair do painel administrativo?')) {
                window.location.href = '../auth/login.php';
            }
        }
    </script>
</body>
</html>