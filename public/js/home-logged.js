// Mock data for dishes and feedbacks
const mockData = {
    dishes: [
        {
            id: 1,
            name: "Arroz com Feijão",
            category: "Prato Principal",
            description: "Clássico nutritivo, combinação perfeita para o almoço do refeitório.",
            image: "https://images.unsplash.com/photo-1562967916-eb82221dfb25?auto=format&fit=crop&w=800&q=80",
            likes: 24,
            liked: false
        },
        {
            id: 2,
            name: "Salada Tropical",
            category: "Acompanhamento",
            description: "Verduras frescas com toque cítrico para equilibrar a refeição.",
            image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80",
            likes: 18,
            liked: false
        },
        {
            id: 3,
            name: "Gelatina de Frutas",
            category: "Sobremesa",
            description: "Doce leve e colorido para fechar a refeição com suavidade.",
            image: "https://images.unsplash.com/photo-1525755662778-989d0524087e?auto=format&fit=crop&w=800&q=80",
            likes: 12,
            liked: false
        },
        {
            id: 4,
            name: "Suco Natural",
            category: "Bebida",
            description: "Bebida fresca preparada com frutas da estação.",
            image: "https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80",
            likes: 31,
            liked: false
        },
        {
            id: 5,
            name: "Massa ao Molho",
            category: "Prato Principal",
            description: "Massa saborosa com molho caseiro e ervas aromáticas.",
            image: "https://images.unsplash.com/photo-1500315331616-db0c55f5a0b2?auto=format&fit=crop&w=800&q=80",
            likes: 27,
            liked: false
        },
        {
            id: 6,
            name: "Bife de Carne",
            category: "Prato Principal",
            description: "Corte suculento preparado na perfeição.",
            image: "https://images.unsplash.com/photo-1546833999-b9f581a1996d?auto=format&fit=crop&w=800&q=80",
            likes: 35,
            liked: false
        }
    ],
    feedbacks: [
        {
            id: 1,
            dishId: 1,
            author: "João Silva",
            date: "2026-05-12",
            text: "Adorei o arroz com feijão hoje! Bem temperado e muito saboroso.",
            likes: 8,
            liked: false
        },
        {
            id: 2,
            dishId: 1,
            author: "Maria Santos",
            date: "2026-05-12",
            text: "Perfeito como sempre. O feijão estava no ponto certo!",
            likes: 5,
            liked: false
        },
        {
            id: 3,
            dishId: 2,
            author: "Pedro Costa",
            date: "2026-05-11",
            text: "A salada estava muito fresca hoje. Recomendo!",
            likes: 12,
            liked: false
        },
        {
            id: 4,
            dishId: 4,
            author: "Ana Oliveira",
            date: "2026-05-11",
            text: "O suco natural é sempre uma boa pedida para acompanhar a refeição.",
            likes: 6,
            liked: false
        }
    ]
};

// DOM elements
let menuGrid, feedbackModal, dishFeedbacksModal, feedbackForm, feedbackTextarea, feedbackSection;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    menuGrid = document.getElementById('menu-grid');
    feedbackModal = document.getElementById('feedback-modal');
    dishFeedbacksModal = document.getElementById('dish-feedbacks-modal');
    feedbackForm = document.getElementById('feedback-form');
    feedbackTextarea = document.getElementById('feedback-textarea');
    feedbackSection = document.getElementById('feedback-section');

    // Initialize components
    initMenu();
    initFeedbackModal();
    initDishFeedbacksModal();
    initMobileMenu();
    initScrollEffects();
});

// Initialize menu grid
function initMenu() {
    if (!menuGrid) return;

    menuGrid.innerHTML = mockData.dishes.map(dish => `
        <article class="menu-card" data-dish-id="${dish.id}">
            <img src="${dish.image}" alt="${dish.name}">
            <div class="menu-card-body">
                <div class="menu-card-header">
                    <div>
                        <h3 class="menu-card-title">${dish.name}</h3>
                        <p>${dish.description}</p>
                    </div>
                    <span class="menu-category">${dish.category}</span>
                </div>
                <div class="menu-card-footer">
                    <div class="menu-actions">
                        <button class="btn-like ${dish.liked ? 'liked' : ''}" data-dish-id="${dish.id}">
                            <span>👍</span>
                            <span class="like-count">${dish.likes}</span>
                        </button>
                        <button class="btn-feedback" data-dish-id="${dish.id}">💬 Feedback</button>
                        <button class="btn-view-feedbacks" data-dish-id="${dish.id}">👁️ Ver Feedbacks</button>
                    </div>
                </div>
            </div>
        </article>
    `).join('');

    // Add event listeners
    document.querySelectorAll('.btn-like').forEach(btn => {
        btn.addEventListener('click', handleLike);
    });

    document.querySelectorAll('.btn-feedback').forEach(btn => {
        btn.addEventListener('click', handleFeedbackClick);
    });

    document.querySelectorAll('.btn-view-feedbacks').forEach(btn => {
        btn.addEventListener('click', handleViewFeedbacks);
    });
}

// Handle like button click
function handleLike(e) {
    const dishId = parseInt(e.currentTarget.dataset.dishId);
    const dish = mockData.dishes.find(d => d.id === dishId);

    if (!dish) return;

    dish.liked = !dish.liked;
    dish.likes += dish.liked ? 1 : -1;

    // Update UI
    const btn = e.currentTarget;
    const countSpan = btn.querySelector('.like-count');

    btn.classList.toggle('liked', dish.liked);
    countSpan.textContent = dish.likes;

    // Save to localStorage (simulate persistence)
    saveData();
}

// Handle view feedbacks button click
function handleViewFeedbacks(e) {
    const dishId = parseInt(e.currentTarget.dataset.dishId);
    const dish = mockData.dishes.find(d => d.id === dishId);

    if (!dish) return;

    // Get feedbacks for this dish
    const dishFeedbacks = mockData.feedbacks.filter(f => f.dishId === dishId);

    // Update modal title
    const modalTitle = document.getElementById('dish-feedbacks-modal-title');
    modalTitle.textContent = `Feedbacks sobre ${dish.name}`;

    // Populate modal with feedbacks
    const feedbacksContainer = document.getElementById('dish-feedbacks-container');

    if (dishFeedbacks.length === 0) {
        feedbacksContainer.innerHTML = `
            <div class="no-feedbacks">
                <p>Ainda não há feedbacks para este prato.</p>
                <p>Seja o primeiro a deixar sua opinião!</p>
            </div>
        `;
    } else {
        feedbacksContainer.innerHTML = dishFeedbacks.map(feedback => `
            <div class="dish-feedback-item">
                <div class="dish-feedback-header">
                    <span class="dish-feedback-author">${feedback.author}</span>
                    <span class="dish-feedback-date">${formatDate(feedback.date)}</span>
                </div>
                <p class="dish-feedback-text">${feedback.text}</p>
                <div class="dish-feedback-actions">
                    <button class="btn-like-comment ${feedback.liked ? 'liked' : ''}" data-feedback-id="${feedback.id}">
                        <span>👍</span>
                        <span class="like-count">${feedback.likes}</span>
                    </button>
                </div>
            </div>
        `).join('');

        // Add event listeners for feedback likes in modal
        feedbacksContainer.querySelectorAll('.btn-like-comment').forEach(btn => {
            btn.addEventListener('click', handleFeedbackLike);
        });
    }

    // Show modal
    dishFeedbacksModal.classList.add('show');
}

// Initialize dish feedbacks modal
function initDishFeedbacksModal() {
    if (!dishFeedbacksModal) return;

    // Close modal events
    const closeBtn = document.getElementById('dish-feedbacks-modal-close');
    closeBtn.addEventListener('click', () => {
        dishFeedbacksModal.classList.remove('show');
    });

    dishFeedbacksModal.addEventListener('click', (e) => {
        if (e.target === dishFeedbacksModal) {
            dishFeedbacksModal.classList.remove('show');
        }
    });
}

// Initialize feedback modal
function initFeedbackModal() {
    if (!feedbackModal) return;

    // Close modal events
    const closeBtn = document.getElementById('modal-close');
    closeBtn.addEventListener('click', () => {
        feedbackModal.classList.remove('show');
        feedbackTextarea.value = '';
    });

    feedbackModal.addEventListener('click', (e) => {
        if (e.target === feedbackModal) {
            feedbackModal.classList.remove('show');
            feedbackTextarea.value = '';
        }
    });

    // Submit feedback
    feedbackForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const dishId = parseInt(feedbackForm.dataset.dishId);
        const text = feedbackTextarea.value.trim();

        if (!text) return;

        // Create new feedback
        const newFeedback = {
            id: Date.now(),
            dishId: dishId,
            author: "Você", // Current user
            date: new Date().toISOString().split('T')[0],
            text: text,
            likes: 0,
            liked: false
        };

        mockData.feedbacks.push(newFeedback);

        // Update UI
        renderFeedbacks();
        feedbackModal.classList.remove('show');
        feedbackTextarea.value = '';

        // Save to localStorage
        saveData();

        // Show success message (simple alert for now)
        alert('Feedback enviado com sucesso!');
    });
}

// Render feedbacks section
function renderFeedbacks() {
    if (!feedbackSection) return;

    const feedbacksHTML = mockData.feedbacks.map(feedback => {
        const dish = mockData.dishes.find(d => d.id === feedback.dishId);
        return `
            <div class="feedback-card">
                <div class="feedback-header">
                    <div>
                        <span class="feedback-author">${feedback.author}</span>
                        <span class="feedback-date">${formatDate(feedback.date)}</span>
                    </div>
                    <span class="feedback-dish">${dish ? dish.name : 'Prato'}</span>
                </div>
                <p class="feedback-text">${feedback.text}</p>
                <div class="feedback-actions">
                    <button class="btn-like-comment ${feedback.liked ? 'liked' : ''}" data-feedback-id="${feedback.id}">
                        <span>👍</span>
                        <span class="like-count">${feedback.likes}</span>
                    </button>
                </div>
            </div>
        `;
    }).join('');

    feedbackSection.innerHTML = `
        <div class="section-title">
            <h2>Feedbacks dos usuários</h2>
            <p>Veja o que outros estudantes estão dizendo sobre os pratos</p>
        </div>
        ${feedbacksHTML}
    `;

    // Add event listeners for feedback likes
    document.querySelectorAll('.btn-like-comment').forEach(btn => {
        btn.addEventListener('click', handleFeedbackLike);
    });
}

// Handle feedback like
function handleFeedbackLike(e) {
    const feedbackId = parseInt(e.currentTarget.dataset.feedbackId);
    const feedback = mockData.feedbacks.find(f => f.id === feedbackId);

    if (!feedback) return;

    feedback.liked = !feedback.liked;
    feedback.likes += feedback.liked ? 1 : -1;

    // Update UI
    const btn = e.currentTarget;
    const countSpan = btn.querySelector('.like-count');

    btn.classList.toggle('liked', feedback.liked);
    countSpan.textContent = feedback.likes;

    // Save to localStorage
    saveData();
}

// Initialize mobile menu
function initMobileMenu() {
    const menuToggle = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    if (!menuToggle || !navLinks) return;

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('open');
        menuToggle.classList.toggle('active');
    });

    // Close menu when clicking links
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('open');
            menuToggle.classList.remove('active');
        });
    });
}

// Initialize scroll effects
function initScrollEffects() {
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.header');
        if (!header) return;
        header.classList.toggle('scrolled', window.scrollY > 15);
    });
}

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('pt-BR');
}

function saveData() {
    // Save to localStorage for persistence simulation
    localStorage.setItem('portal-refeitorio-data', JSON.stringify(mockData));
}

function loadData() {
    // Load from localStorage
    const saved = localStorage.getItem('portal-refeitorio-data');
    if (saved) {
        const parsed = JSON.parse(saved);
        Object.assign(mockData, parsed);
    }
}

// Load data on init
loadData();