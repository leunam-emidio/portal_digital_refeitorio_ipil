// Mock data for the admin dashboard
const mockData = {
    users: [
        { id: 1, name: "João Silva", email: "joao@email.com", registerDate: "2024-01-15", status: "active" },
        { id: 2, name: "Maria Santos", email: "maria@email.com", registerDate: "2024-02-20", status: "active" },
        { id: 3, name: "Pedro Costa", email: "pedro@email.com", registerDate: "2024-03-10", status: "blocked" },
        { id: 4, name: "Ana Oliveira", email: "ana@email.com", registerDate: "2024-04-05", status: "active" },
        { id: 5, name: "Carlos Mendes", email: "carlos@email.com", registerDate: "2024-05-12", status: "active" }
    ],
    dishes: [
        { id: 1, name: "Arroz com Feijão", category: "Prato Principal", description: "Clássico nutritivo", image: "https://example.com/image1.jpg", status: "active" },
        { id: 2, name: "Salada Tropical", category: "Acompanhamento", description: "Verduras frescas", image: "https://example.com/image2.jpg", status: "active" },
        { id: 3, name: "Gelatina de Frutas", category: "Sobremesa", description: "Doce leve", image: "https://example.com/image3.jpg", status: "inactive" },
        { id: 4, name: "Suco Natural", category: "Bebida", description: "Bebida fresca", image: "https://example.com/image4.jpg", status: "active" },
        { id: 5, name: "Massa ao Molho", category: "Prato Principal", description: "Massa saborosa", image: "https://example.com/image5.jpg", status: "active" },
        { id: 6, name: "Bife de Carne", category: "Prato Principal", description: "Corte suculento", image: "https://example.com/image6.jpg", status: "active" }
    ],
    feedbacks: [
        { id: 1, userId: 1, dishId: 1, comment: "Adorei o arroz com feijão!", date: "2024-05-13", likes: 8 },
        { id: 2, userId: 2, dishId: 1, comment: "Bem temperado e muito saboroso.", date: "2024-05-13", likes: 5 },
        { id: 3, userId: 4, dishId: 2, comment: "A salada estava muito fresca!", date: "2024-05-12", likes: 12 },
        { id: 4, userId: 5, dishId: 4, comment: "O suco é sempre uma boa pedida.", date: "2024-05-12", likes: 6 },
        { id: 5, userId: 3, dishId: 5, comment: "Massa perfeita!", date: "2024-05-11", likes: 15 }
    ],
    settings: {
        restaurantName: "Refeitório IPIL",
        openingHours: "07:00 - 19:00",
        welcomeMessage: "Bem-vindo ao Portal Digital do Refeitório IPIL"
    }
};

// DOM elements
let currentSection = 'overview';
let dishModal, userModal, settingsForm;

// Initialize the dashboard
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    renderOverview();
    updateNavigation();
    loadData();
});

// Initialize DOM elements
function initializeElements() {
    dishModal = document.getElementById('dish-modal');
    userModal = document.getElementById('user-modal');
    settingsForm = document.getElementById('settings-form');
}

// Setup event listeners
function setupEventListeners() {
    // Navigation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', handleNavigation);
    });

    // Search and filters
    document.getElementById('user-search')?.addEventListener('input', filterUsers);
    document.getElementById('dish-filter')?.addEventListener('change', filterDishes);
    document.getElementById('feedback-filter')?.addEventListener('change', filterFeedbacks);

    // Modal close buttons
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Modal overlays
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    });

    // Settings form
    settingsForm?.addEventListener('submit', saveSettings);

    // Populate feedback filter options
    populateFeedbackFilters();
}

// Navigation handler
function handleNavigation(e) {
    e.preventDefault();
    const section = e.currentTarget.dataset.section;
    navigateToSection(section);
}

// Navigate to section
function navigateToSection(section) {
    currentSection = section;
    updateNavigation();

    // Hide all sections
    document.querySelectorAll('.section').forEach(sec => {
        sec.style.display = 'none';
    });

    // Show current section
    const currentSectionEl = document.getElementById(section);
    if (currentSectionEl) {
        currentSectionEl.style.display = 'block';
    }

    // Render section content
    switch(section) {
        case 'overview':
            renderOverview();
            break;
        case 'menu':
            renderMenuManagement();
            break;
        case 'users':
            renderUserManagement();
            break;
        case 'feedbacks':
            renderFeedbackManagement();
            break;
        case 'reports':
            renderReports();
            break;
        case 'settings':
            renderSettings();
            break;
    }
}

// Update navigation active state
function updateNavigation() {
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.dataset.section === currentSection) {
            link.classList.add('active');
        }
    });
}

// Render overview section
function renderOverview() {
    const stats = calculateStats();

    document.getElementById('total-users').textContent = stats.totalUsers;
    document.getElementById('total-dishes').textContent = stats.totalDishes;
    document.getElementById('today-feedbacks').textContent = stats.todayFeedbacks;
    document.getElementById('top-dish').textContent = stats.topDish;
}

// Calculate statistics
function calculateStats() {
    const totalUsers = mockData.users.length;
    const totalDishes = mockData.dishes.filter(d => d.status === 'active').length;

    const today = new Date().toISOString().split('T')[0];
    const todayFeedbacks = mockData.feedbacks.filter(f => f.date === today).length;

    const dishLikes = {};
    mockData.feedbacks.forEach(f => {
        dishLikes[f.dishId] = (dishLikes[f.dishId] || 0) + f.likes;
    });

    const topDishId = Object.keys(dishLikes).reduce((a, b) =>
        dishLikes[a] > dishLikes[b] ? a : b, Object.keys(dishLikes)[0]);

    const topDish = mockData.dishes.find(d => d.id == topDishId)?.name || 'Nenhum';

    return { totalUsers, totalDishes, todayFeedbacks, topDish };
}

// Render menu management
function renderMenuManagement() {
    const tbody = document.getElementById('dishes-tbody');
    tbody.innerHTML = mockData.dishes.map(dish => `
        <tr>
            <td>${dish.name}</td>
            <td>${dish.category}</td>
            <td>${dish.description}</td>
            <td><span class="status-badge status-${dish.status}">${dish.status === 'active' ? 'Ativo' : 'Inativo'}</span></td>
            <td class="action-buttons">
                <button class="btn-icon btn-edit" onclick="editDish(${dish.id})" title="Editar">
                    <i>✏️</i>
                </button>
                <button class="btn-icon btn-delete" onclick="deleteDish(${dish.id})" title="Excluir">
                    <i>🗑️</i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Render user management
function renderUserManagement() {
    const tbody = document.getElementById('users-tbody');
    tbody.innerHTML = mockData.users.map(user => `
        <tr>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${formatDate(user.registerDate)}</td>
            <td><span class="status-badge status-${user.status}">${getStatusLabel(user.status)}</span></td>
            <td class="action-buttons">
                <button class="btn-icon btn-block" onclick="toggleUserStatus(${user.id})" title="${user.status === 'blocked' ? 'Desbloquear' : 'Bloquear'}">
                    <i>${user.status === 'blocked' ? '🔓' : '🔒'}</i>
                </button>
                <button class="btn-icon btn-delete" onclick="deleteUser(${user.id})" title="Excluir">
                    <i>🗑️</i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Render feedback management
function renderFeedbackManagement() {
    const tbody = document.getElementById('feedbacks-tbody');
    tbody.innerHTML = mockData.feedbacks.map(feedback => {
        const user = mockData.users.find(u => u.id === feedback.userId);
        const dish = mockData.dishes.find(d => d.id === feedback.dishId);
        return `
            <tr>
                <td>${user?.name || 'Usuário'}</td>
                <td>${dish?.name || 'Prato'}</td>
                <td>${feedback.comment}</td>
                <td>${formatDate(feedback.date)}</td>
                <td>${feedback.likes}</td>
                <td class="action-buttons">
                    <button class="btn-icon btn-delete" onclick="deleteFeedback(${feedback.id})" title="Excluir">
                        <i>🗑️</i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

// Render reports with charts
function renderReports() {
    // This will be enhanced with Chart.js integration
    setTimeout(() => {
        renderCharts();
    }, 100);
}

// Render settings
function renderSettings() {
    document.getElementById('restaurant-name').value = mockData.settings.restaurantName;
    document.getElementById('opening-hours').value = mockData.settings.openingHours;
    document.getElementById('welcome-message').value = mockData.settings.welcomeMessage;
}

// CRUD Operations - Dishes
function addDish() {
    openDishModal();
}

function editDish(id) {
    const dish = mockData.dishes.find(d => d.id === id);
    if (!dish) return;

    openDishModal(dish);
}

function deleteDish(id) {
    if (confirm('Tem certeza que deseja excluir este prato?')) {
        const index = mockData.dishes.findIndex(d => d.id === id);
        if (index > -1) {
            mockData.dishes.splice(index, 1);
            renderMenuManagement();
            saveData();
        }
    }
}

function openDishModal(dish = null) {
    const form = document.getElementById('dish-form');
    const title = document.getElementById('dish-modal-title');

    if (dish) {
        title.textContent = 'Editar Prato';
        form.name.value = dish.name;
        form.category.value = dish.category;
        form.description.value = dish.description;
        form.image.value = dish.image;
        form.status.value = dish.status;
        form.dataset.dishId = dish.id;
    } else {
        title.textContent = 'Adicionar Prato';
        form.reset();
        delete form.dataset.dishId;
    }

    dishModal.classList.add('show');
}

function saveDish(e) {
    e.preventDefault();

    const form = e.target;
    const dishId = form.dataset.dishId;
    const dishData = {
        name: form.name.value,
        category: form.category.value,
        description: form.description.value,
        image: form.image.value,
        status: form.status.value
    };

    if (dishId) {
        // Update existing dish
        const dish = mockData.dishes.find(d => d.id == dishId);
        if (dish) {
            Object.assign(dish, dishData);
        }
    } else {
        // Add new dish
        dishData.id = Date.now();
        mockData.dishes.push(dishData);
    }

    closeModal();
    renderMenuManagement();
    saveData();
}

// CRUD Operations - Users
function toggleUserStatus(id) {
    const user = mockData.users.find(u => u.id === id);
    if (user) {
        user.status = user.status === 'active' ? 'blocked' : 'active';
        renderUserManagement();
        saveData();
    }
}

function deleteUser(id) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        const index = mockData.users.findIndex(u => u.id === id);
        if (index > -1) {
            mockData.users.splice(index, 1);
            renderUserManagement();
            saveData();
        }
    }
}

// CRUD Operations - Feedbacks
function deleteFeedback(id) {
    if (confirm('Tem certeza que deseja excluir este feedback?')) {
        const index = mockData.feedbacks.findIndex(f => f.id === id);
        if (index > -1) {
            mockData.feedbacks.splice(index, 1);
            renderFeedbackManagement();
            saveData();
        }
    }
}

// Settings
function saveSettings(e) {
    e.preventDefault();

    mockData.settings = {
        restaurantName: document.getElementById('restaurant-name').value,
        openingHours: document.getElementById('opening-hours').value,
        welcomeMessage: document.getElementById('welcome-message').value
    };

    saveData();
    alert('Configurações salvas com sucesso!');
}

// Filtering functions
function filterUsers(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#users-tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

function filterDishes(e) {
    const category = e.target.value;
    const rows = document.querySelectorAll('#dishes-tbody tr');

    rows.forEach(row => {
        if (category === '' || row.cells[1].textContent === category) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterFeedbacks(e) {
    const filter = e.target.value;
    const rows = document.querySelectorAll('#feedbacks-tbody tr');

    rows.forEach(row => {
        const dishName = row.cells[1].textContent;
        const date = row.cells[3].textContent;

        let show = true;
        if (filter.startsWith('dish-')) {
            const dishId = filter.replace('dish-', '');
            const dish = mockData.dishes.find(d => d.id == dishId);
            show = dish && dish.name === dishName;
        } else if (filter === 'today') {
            const today = new Date().toISOString().split('T')[0];
            show = date === formatDate(today);
        }

        row.style.display = show ? '' : 'none';
    });
}

// Modal functions
function closeModal() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.classList.remove('show');
    });
}

// Charts rendering (simplified version without external libraries)
function renderCharts() {
    // Bar chart for most liked dishes
    renderBarChart('likes-chart', 'Pratos Mais Curtidos', getDishLikesData());

    // Line chart for feedbacks per day
    renderLineChart('feedbacks-chart', 'Feedbacks por Dia', getFeedbacksPerDayData());

    // Pie chart for dish categories
    renderPieChart('categories-chart', 'Distribuição por Categoria', getCategoriesData());
}

function getDishLikesData() {
    const dishLikes = {};
    mockData.feedbacks.forEach(f => {
        dishLikes[f.dishId] = (dishLikes[f.dishId] || 0) + f.likes;
    });

    return Object.entries(dishLikes).map(([dishId, likes]) => {
        const dish = mockData.dishes.find(d => d.id == dishId);
        return { label: dish?.name || 'Prato', value: likes };
    }).sort((a, b) => b.value - a.value).slice(0, 5);
}

function getFeedbacksPerDayData() {
    const days = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
    const data = new Array(7).fill(0);

    mockData.feedbacks.forEach(f => {
        const date = new Date(f.date);
        const dayIndex = date.getDay();
        data[dayIndex]++;
    });

    return days.map((day, index) => ({ label: day, value: data[index] }));
}

function getCategoriesData() {
    const categories = {};
    mockData.dishes.forEach(dish => {
        categories[dish.category] = (categories[dish.category] || 0) + 1;
    });

    return Object.entries(categories).map(([category, count]) => ({
        label: category,
        value: count
    }));
}

// Simplified chart rendering functions
function renderBarChart(canvasId, title, data) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    const maxValue = Math.max(...data.map(d => d.value));

    ctx.clearRect(0, 0, width, height);

    // Draw bars
    const barWidth = (width - 100) / data.length;
    const barSpacing = 10;

    data.forEach((item, index) => {
        const barHeight = (item.value / maxValue) * (height - 100);
        const x = 50 + index * (barWidth + barSpacing);
        const y = height - 50 - barHeight;

        // Bar
        ctx.fillStyle = '#3b82f6';
        ctx.fillRect(x, y, barWidth, barHeight);

        // Label
        ctx.fillStyle = '#374151';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(item.label, x + barWidth/2, height - 20);

        // Value
        ctx.fillText(item.value.toString(), x + barWidth/2, y - 5);
    });
}

function renderLineChart(canvasId, title, data) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    const maxValue = Math.max(...data.map(d => d.value));

    ctx.clearRect(0, 0, width, height);

    // Draw line
    ctx.strokeStyle = '#10b981';
    ctx.lineWidth = 3;
    ctx.beginPath();

    data.forEach((item, index) => {
        const x = 50 + (index / (data.length - 1)) * (width - 100);
        const y = height - 50 - (item.value / maxValue) * (height - 100);

        if (index === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }

        // Point
        ctx.fillStyle = '#10b981';
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, 2 * Math.PI);
        ctx.fill();

        // Label
        ctx.fillStyle = '#374151';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(item.label, x, height - 20);
    });

    ctx.stroke();
}

function renderPieChart(canvasId, title, data) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    const centerX = width / 2;
    const centerY = height / 2;
    const radius = Math.min(width, height) / 2 - 40;

    const total = data.reduce((sum, item) => sum + item.value, 0);
    let startAngle = 0;

    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];

    ctx.clearRect(0, 0, width, height);

    data.forEach((item, index) => {
        const sliceAngle = (item.value / total) * 2 * Math.PI;
        const endAngle = startAngle + sliceAngle;

        // Slice
        ctx.fillStyle = colors[index % colors.length];
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, startAngle, endAngle);
        ctx.closePath();
        ctx.fill();

        // Label
        const labelAngle = startAngle + sliceAngle / 2;
        const labelX = centerX + Math.cos(labelAngle) * (radius + 20);
        const labelY = centerY + Math.sin(labelAngle) * (radius + 20);

        ctx.fillStyle = '#374151';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(`${item.label}: ${item.value}`, labelX, labelY);

        startAngle = endAngle;
    });
}

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('pt-BR');
}

function getStatusLabel(status) {
    switch(status) {
        case 'active': return 'Ativo';
        case 'blocked': return 'Bloqueado';
        default: return status;
    }
}

// Data persistence (simulated with localStorage)
function saveData() {
    localStorage.setItem('admin-dashboard-data', JSON.stringify(mockData));
}

function loadData() {
    const saved = localStorage.getItem('admin-dashboard-data');
    if (saved) {
        const parsed = JSON.parse(saved);
        Object.assign(mockData, parsed);
    }
}

// Populate feedback filter options
function populateFeedbackFilters() {
    const filterSelect = document.getElementById('feedback-filter');
    if (!filterSelect) return;

    // Add dish options
    mockData.dishes.forEach(dish => {
        const option = document.createElement('option');
        option.value = `dish-${dish.id}`;
        option.textContent = `Prato: ${dish.name}`;
        filterSelect.appendChild(option);
    });
}