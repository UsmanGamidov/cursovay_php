let favorites = [];
let filteredProducts = [];
let products = [];

const burgerMenu = document.getElementById('burgerMenu');
const mobileMenu = document.getElementById('mobileMenu');
const favoritesModal = document.getElementById('favoritesModal');
const favoritesBtn = document.getElementById('favoritesBtn');
const closeModal = document.querySelector('.close-modal');
const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const productsGrid = document.getElementById('productsGrid');
const favoritesList = document.querySelector('.favorites-list');

var user_name = "<?php echo isset($user_name) ? $user_name : ''; ?>";
var user_id = "<?php echo isset($user_id) ? $user_id : ''; ?>";

async function fetchProducts() {
    try {
        const response = await fetch('products.php');
        const data = await response.json();

        if (data.error) {
            console.error(data.error);
            return;
        }

        products = data;
        filteredProducts = products;
        renderProducts();
    } catch (error) {
        console.error('Ошибка загрузки товаров:', error);
    }
}

function renderProducts() {
    productsGrid.innerHTML = filteredProducts.map(product => `
        <div class="product-card fade-in">
            <img src="${product.image}" alt="${product.name}">
            <div class="product-info">
                <h3>${product.name}</h3>
                <p class="product-price">${product.price} ₽</p>

                <!-- Сердечко только для авторизованных пользователей -->
                ${user_name ? 
                    `<button onclick="toggleFavorite(${product.id})" class="favorite-btn" style="
                    border:none; 
                    background-color:rgb(255, 255, 255);
                    padding: 5px 10px;
                    border-radius: 5px;
                    color:#ff5956;
                    font-size:20px;">
                        <i class="${favorites.includes(product.id) ? 'fas fa-heart' : 'far fa-heart'}"></i>
                    </button>` 
                 : ''}

                <button onclick="addToCart(${product.id})" class="buy-btn" style="
                border:none; 
                background-color: #ff5956;
                padding: 5px 10px;
                border-radius: 5px;
                color:#fff;">В корзину</button>
            </div>
        </div>
    `).join('');
}

async function addToCart(productId) {
    if (!user_id) {
        alert("Вам нужно войти в систему, чтобы добавить товар в корзину.");
        return;
    }

    try {
        const response = await fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: user_id, product_id: productId })
        });

        const result = await response.json();

        if (result.success) {
            alert("Товар добавлен в корзину!");
        } else {
            alert("Ошибка при добавлении в корзину.");
        }
    } catch (error) {
        console.error('Ошибка при добавлении в корзину:', error);
    }
}
function toggleFavorite(productId) {
    const index = favorites.indexOf(productId);
    if (index === -1) {
        favorites.push(productId);
    } else {
        favorites.splice(index, 1);
    }
    updateFavoritesCount();
    renderProducts();
    updateFavoritesList();
}

function updateFavoritesCount() {
    document.querySelector('.favorites-count').textContent = favorites.length;
}

function updateFavoritesList() {
    const favoriteProducts = products.filter(product => favorites.includes(product.id));
    favoritesList.innerHTML = favoriteProducts.map(product => `
        <div class="favorite-item fade-in">
            <img src="${product.image}" alt="${product.name}" style="width: 100px; height: 100px; object-fit: cover;">
            <div class="favorite-info">
                <h3>${product.name}</h3>
                <p>${product.price} ₽</p>
                <button onclick="toggleFavorite(${product.id})">Удалить</button>
            </div>
        </div>
    `).join('');
}

function filterProducts() {
    const searchTerm = searchInput.value.toLowerCase();
    const sortValue = sortSelect.value;

    filteredProducts = products.filter(product =>
        product.name.toLowerCase().includes(searchTerm) ||
        product.category.toLowerCase().includes(searchTerm)
    );

    switch (sortValue) {
        case 'priceAsc':
            filteredProducts.sort((a, b) => a.price - b.price);
            break;
        case 'priceDesc':
            filteredProducts.sort((a, b) => b.price - a.price);
            break;
        case 'nameAsc':
            filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
            break;
        default:
            filteredProducts = [...filteredProducts];
    }

    renderProducts();
}

searchInput.addEventListener('input', filterProducts);
sortSelect.addEventListener('change', filterProducts);

document.addEventListener('DOMContentLoaded', () => {
    fetchProducts();
    updateFavoritesCount();
});

burgerMenu.addEventListener('click', () => {
    mobileMenu.classList.toggle('active');
    burgerMenu.classList.toggle('active');
});

document.querySelectorAll('.mobile-menu a').forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
        burgerMenu.classList.remove('active');
    });
});
