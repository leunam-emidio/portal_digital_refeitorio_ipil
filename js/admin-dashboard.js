const state = {
    users: normalizeUsers(window.adminData?.users || []),
    dishes: normalizeDishes(window.adminData?.dishes || []),
    feedbacks: normalizeFeedbacks(window.adminData?.feedbacks || []),
    settings: window.adminData?.settings || {},
    currentSection: 'overview'
};

let dishModal;

document.addEventListener('DOMContentLoaded', () => {
    dishModal = document.getElementById('dish-modal');
    setupEventListeners();
    renderOverview();
    updateNavigation();
});

function setupEventListeners() {
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            navigateToSection(event.currentTarget.dataset.section);
        });
    });

    document.querySelectorAll('.modal-close').forEach(button => {
        button.addEventListener('click', closeModal);
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', event => {
            if (event.target === modal) {
                closeModal();
            }
        });
    });

    document.getElementById('user-search')?.addEventListener('input', filterUsers);
    document.getElementById('dish-filter')?.addEventListener('change', filterDishes);
    document.getElementById('feedback-filter')?.addEventListener('change', filterFeedbacks);
    document.getElementById('settings-form')?.addEventListener('submit', saveSettings);

    populateFeedbackFilters();
}

function navigateToSection(section) {
    state.currentSection = section;
    updateNavigation();

    document.querySelectorAll('.section').forEach(sectionElement => {
        sectionElement.style.display = 'none';
    });

    const activeSection = document.getElementById(section);
    if (activeSection) {
        activeSection.style.display = 'block';
    }

    if (section === 'overview') renderOverview();
    if (section === 'menu') renderMenuManagement();
    if (section === 'users') renderUserManagement();
    if (section === 'feedbacks') renderFeedbackManagement();
    if (section === 'reports') renderReports();
    if (section === 'settings') renderSettings();
}

function updateNavigation() {
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.toggle('active', link.dataset.section === state.currentSection);
    });
}

function renderOverview() {
    const activeDishes = state.dishes.filter(dish => dish.status === 'active').length;
    const today = new Date().toISOString().slice(0, 10);
    const todayFeedbacks = state.feedbacks.filter(feedback => feedback.date.slice(0, 10) === today).length;
    const topDish = getDishLikesData()[0]?.label || 'Nenhum';

    setText('total-users', state.users.length);
    setText('total-dishes', activeDishes);
    setText('today-feedbacks', todayFeedbacks);
    setText('top-dish', topDish);
}

function renderMenuManagement() {
    const tbody = document.getElementById('dishes-tbody');
    if (!tbody) return;

    tbody.innerHTML = state.dishes.map(dish => `
        <tr>
            <td>${escapeHtml(dish.name)}</td>
            <td><img class="table-image" src="${escapeHtml(resolveImage(dish.image))}" alt="${escapeHtml(dish.name)}"></td>
            <td>${escapeHtml(dish.category)}</td>
            <td>${escapeHtml(dish.description)}</td>
            <td><span class="status-badge status-${escapeHtml(dish.status)}">${dish.status === 'active' ? 'Ativo' : 'Inativo'}</span></td>
            <td class="action-buttons">
                <button class="btn-icon btn-edit" onclick="editDish(${dish.id})" title="Editar">E</button>
                <button class="btn-icon btn-delete" onclick="deleteDish(${dish.id})" title="Excluir">X</button>
            </td>
        </tr>
    `).join('');
}

function renderUserManagement() {
    const tbody = document.getElementById('users-tbody');
    if (!tbody) return;

    tbody.innerHTML = state.users.map(user => `
        <tr>
            <td>${escapeHtml(user.name)}</td>
            <td>${escapeHtml(user.email)}</td>
            <td>${formatDate(user.registerDate)}</td>
            <td><span class="status-badge status-${escapeHtml(user.status)}">${getStatusLabel(user.status)}</span></td>
            <td class="action-buttons">
                <button class="btn-icon btn-block" onclick="toggleUserStatus(${user.id})" title="${user.status === 'blocked' ? 'Desbloquear' : 'Bloquear'}">${user.status === 'blocked' ? 'A' : 'B'}</button>
                <button class="btn-icon btn-delete" onclick="deleteUser(${user.id})" title="Excluir">X</button>
            </td>
        </tr>
    `).join('');
}

function renderFeedbackManagement() {
    const tbody = document.getElementById('feedbacks-tbody');
    if (!tbody) return;

    tbody.innerHTML = state.feedbacks.map(feedback => `
        <tr>
            <td>${escapeHtml(feedback.author)}</td>
            <td>${escapeHtml(feedback.dishName)}</td>
            <td>${escapeHtml(feedback.comment)}</td>
            <td>${formatDate(feedback.date)}</td>
            <td>${feedback.likes}</td>
            <td class="action-buttons">
                <button class="btn-icon btn-delete" onclick="deleteFeedback(${feedback.id})" title="Excluir">X</button>
            </td>
        </tr>
    `).join('');
}

function renderSettings() {
    setValue('restaurant-name', state.settings.nome_refeitorio || '');
    setValue('description-place', state.settings.descricao_refeitorio || '');
    setValue('welcome-message', state.settings.boas_vinda || '');
    setValue('title-initial', state.settings.titulo_index || '');
    setValue('description-initial', state.settings.descricao_index || '');
    setValue('title-home', state.settings.titulo_home || '');
    setValue('description-menu', state.settings.descricao_home || '');
}

function addDish() {
    openDishModal();
}

function editDish(id) {
    const dish = state.dishes.find(item => item.id === id);
    if (dish) {
        openDishModal(dish);
    }
}

function openDishModal(dish = null) {
    const form = document.getElementById('dish-form');
    const title = document.getElementById('dish-modal-title');
    if (!form || !dishModal) return;

    form.reset();
    document.getElementById('dish-id').value = dish?.id || '';
    title.textContent = dish ? 'Editar Prato' : 'Adicionar Prato';

    if (dish) {
        form.name.value = dish.name;
        form.category.value = dish.category;
        form.description.value = dish.description;
        form.status.value = dish.status;
        form.weekdays.value = dish.weekdays;
        form.tip.value = dish.tip;
        form.image.required = false;
    } else {
        form.image.required = true;
    }

    dishModal.classList.add('show');
}

async function saveDish(event) {
    event.preventDefault();

    const result = await apiPost('menu_save', new FormData(event.target));
    if (!result.success) {
        alert(result.message || 'Não foi possível salvar o prato.');
        return;
    }

    window.location.reload();
}

async function deleteDish(id) {
    if (!confirm('Tem certeza que deseja excluir este prato?')) return;

    const result = await apiPost('menu_delete', { id });
    if (!result.success) {
        alert(result.message || 'Não foi possível excluir o prato.');
        return;
    }

    state.dishes = state.dishes.filter(dish => dish.id !== id);
    state.feedbacks = state.feedbacks.filter(feedback => feedback.dishId !== id);
    renderMenuManagement();
    renderOverview();
}

async function toggleUserStatus(id) {
    const user = state.users.find(item => item.id === id);
    if (!user) return;

    const nextStatus = user.status === 'blocked' ? 'active' : 'blocked';
    const result = await apiPost('user_status', { id, status: nextStatus });
    if (!result.success) {
        alert(result.message || 'Não foi possível alterar o estado do utilizador.');
        return;
    }

    user.status = nextStatus;
    renderUserManagement();
}

async function deleteUser(id) {
    if (!confirm('Tem certeza que deseja excluir este utilizador?')) return;

    const result = await apiPost('user_delete', { id });
    if (!result.success) {
        alert(result.message || 'Não foi possível excluir o utilizador.');
        return;
    }

    state.users = state.users.filter(user => user.id !== id);
    renderUserManagement();
    renderOverview();
}

async function deleteFeedback(id) {
    if (!confirm('Tem certeza que deseja excluir este feedback?')) return;

    const result = await apiPost('feedback_delete', { id });
    if (!result.success) {
        alert(result.message || 'Não foi possível excluir o feedback.');
        return;
    }

    state.feedbacks = state.feedbacks.filter(feedback => feedback.id !== id);
    renderFeedbackManagement();
    renderOverview();
}

async function saveSettings(event) {
    event.preventDefault();

    const result = await apiPost('config_save', new FormData(event.target));
    if (!result.success) {
        alert(result.message || 'Não foi possível salvar as configurações.');
        return;
    }

    state.settings = Object.fromEntries(new FormData(event.target).entries());
    alert('Configurações salvas com sucesso.');
}

function filterUsers(event) {
    const search = event.target.value.toLowerCase();
    document.querySelectorAll('#users-tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
}

function filterDishes(event) {
    const category = event.target.value;
    document.querySelectorAll('#dishes-tbody tr').forEach(row => {
        row.style.display = !category || row.cells[2].textContent === category ? '' : 'none';
    });
}

function filterFeedbacks(event) {
    const filter = event.target.value;
    document.querySelectorAll('#feedbacks-tbody tr').forEach(row => {
        let visible = true;
        if (filter === 'today') {
            visible = row.cells[3].textContent === formatDate(new Date().toISOString());
        } else if (filter.startsWith('dish-')) {
            const dish = state.dishes.find(item => item.id === Number(filter.replace('dish-', '')));
            visible = Boolean(dish && row.cells[1].textContent === dish.name);
        }

        row.style.display = visible ? '' : 'none';
    });
}

function closeModal() {
    document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));
}

function renderReports() {
    setTimeout(() => {
        renderBarChart('likes-chart', getDishLikesData());
        renderLineChart('feedbacks-chart', getFeedbacksPerDayData());
        renderPieChart('categories-chart', getCategoriesData());
    }, 50);
}

function getDishLikesData() {
    const dishLikes = {};
    state.feedbacks.forEach(feedback => {
        dishLikes[feedback.dishId] = (dishLikes[feedback.dishId] || 0) + feedback.likes;
    });

    return Object.entries(dishLikes).map(([dishId, likes]) => {
        const dish = state.dishes.find(item => item.id === Number(dishId));
        return { label: dish?.name || 'Prato', value: likes };
    }).sort((a, b) => b.value - a.value);
}

function getFeedbacksPerDayData() {
    const days = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];
    const values = new Array(7).fill(0);

    state.feedbacks.forEach(feedback => {
        const date = new Date(feedback.date);
        if (!Number.isNaN(date.getTime())) {
            values[date.getDay()]++;
        }
    });

    return days.map((label, index) => ({ label, value: values[index] }));
}

function getCategoriesData() {
    const categories = {};
    state.dishes.forEach(dish => {
        categories[dish.category] = (categories[dish.category] || 0) + 1;
    });

    return Object.entries(categories).map(([label, value]) => ({ label, value }));
}

function renderBarChart(canvasId, data) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    const values = data.slice(0, 5);
    const maxValue = Math.max(1, ...values.map(item => item.value));
    const barWidth = values.length ? (width - 100) / values.length : width - 100;

    ctx.clearRect(0, 0, width, height);
    values.forEach((item, index) => {
        const barHeight = (item.value / maxValue) * (height - 100);
        const x = 50 + index * barWidth;
        const y = height - 50 - barHeight;

        ctx.fillStyle = '#3b82f6';
        ctx.fillRect(x, y, Math.max(24, barWidth - 10), barHeight);
        ctx.fillStyle = '#374151';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(item.label.slice(0, 12), x + barWidth / 2, height - 20);
        ctx.fillText(String(item.value), x + barWidth / 2, y - 5);
    });
}

function renderLineChart(canvasId, data) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    const maxValue = Math.max(1, ...data.map(item => item.value));

    ctx.clearRect(0, 0, width, height);
    ctx.strokeStyle = '#10b981';
    ctx.lineWidth = 3;
    ctx.beginPath();

    data.forEach((item, index) => {
        const x = 50 + (index / Math.max(1, data.length - 1)) * (width - 100);
        const y = height - 50 - (item.value / maxValue) * (height - 100);
        if (index === 0) ctx.moveTo(x, y);
        if (index > 0) ctx.lineTo(x, y);
    });

    ctx.stroke();

    data.forEach((item, index) => {
        const x = 50 + (index / Math.max(1, data.length - 1)) * (width - 100);
        const y = height - 50 - (item.value / maxValue) * (height - 100);
        ctx.fillStyle = '#10b981';
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, 2 * Math.PI);
        ctx.fill();
        ctx.fillStyle = '#374151';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(item.label, x, height - 20);
    });
}

function renderPieChart(canvasId, data) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const total = data.reduce((sum, item) => sum + item.value, 0);
    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];
    let startAngle = 0;

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (!total) return;

    data.forEach((item, index) => {
        const angle = (item.value / total) * 2 * Math.PI;
        ctx.fillStyle = colors[index % colors.length];
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        ctx.arc(canvas.width / 2, canvas.height / 2, 100, startAngle, startAngle + angle);
        ctx.closePath();
        ctx.fill();
        startAngle += angle;
    });
}

async function apiPost(action, payload) {
    const body = payload instanceof FormData ? payload : new FormData();
    if (!(payload instanceof FormData)) {
        Object.entries(payload).forEach(([key, value]) => body.append(key, value));
    }

    const response = await fetch(`../../../index.php?action=${action}`, {
        method: 'POST',
        body
    });

    return response.json();
}

function populateFeedbackFilters() {
    const select = document.getElementById('feedback-filter');
    if (!select) return;

    state.dishes.forEach(dish => {
        const option = document.createElement('option');
        option.value = `dish-${dish.id}`;
        option.textContent = `Prato: ${dish.name}`;
        select.appendChild(option);
    });
}

function normalizeUsers(users) {
    return users.map(user => ({
        id: Number(user.id),
        name: user.name || '',
        email: user.email || '',
        status: user.status || 'active',
        registerDate: user.create_at || user.registerDate || ''
    }));
}

function normalizeDishes(dishes) {
    return dishes.map(dish => ({
        id: Number(dish.id),
        name: dish.name || '',
        category: dish.category || '',
        description: dish.description || '',
        image: dish.url || dish.image || '',
        status: dish.status || 'active',
        weekdays: dish.weekdays || '',
        tip: dish.tip || ''
    }));
}

function normalizeFeedbacks(feedbacks) {
    return feedbacks.map(feedback => ({
        id: Number(feedback.id),
        dishId: Number(feedback.id_menu || feedback.dishId),
        author: feedback.author || 'Utilizador',
        dishName: feedback.menu_name || feedback.dishName || 'Prato',
        comment: feedback.comentary || feedback.comment || '',
        date: feedback.create_at || feedback.date || '',
        likes: Number(feedback.liked || feedback.likes || 0)
    }));
}

function resolveImage(path) {
    if (!path || path.startsWith('http://') || path.startsWith('https://')) {
        return '../../../imgs/ipil-icon.png';
    }

    if (path.startsWith('../')) {
        return path;
    }

    return `../../../${path}`;
}

function formatDate(value) {
    if (!value) return '-';
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return value;
    return date.toLocaleDateString('pt-BR');
}

function getStatusLabel(status) {
    if (status === 'active') return 'Ativo';
    if (status === 'blocked') return 'Bloqueado';
    if (status === 'inactive') return 'Inativo';
    return status;
}

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    }[char]));
}

function setText(id, value) {
    const element = document.getElementById(id);
    if (element) element.textContent = value;
}

function setValue(id, value) {
    const element = document.getElementById(id);
    if (element) element.value = value;
}
