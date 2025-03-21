<?php
session_start();

if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_id = $_SESSION['user_id']; 
} else {
    $user_name = "";
    $user_email = "";
    $user_id = null;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все для кондитера</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <h1>Все для кондитера</h1>
            </div>
            <nav class="desktop-nav">
                <ul>
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#catalog">Каталог</a></li>
                    <li><a href="#about">О нас</a></li>
                    <li><a href="#contact">Контакты</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="cart.php" class="cart-btn">Корзина</a></li>
                        <li><a href="orders.php" class="cart-btn">Заказы</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="header-buttons">
            <?php if (!empty($user_name)): ?>
                    <span class="user-info" style="
                        font-size:10px;
                        color: brown;">
                        <?php echo $user_name; ?> (<?php echo $user_email; ?>)
                    </span>
                    <a href="favorites.php" class="favorites-btn">
                        <i class="fas fa-heart"></i>
                        <span class="favorites-count">0</span>
                    </a>
                    <a href="logout.php" class="auth-btn">Выйти</a>
                <?php else: ?>
                    <a href="login.php" class="auth-btn">Войти</a>
                    <a href="register.php" class="auth-btn">Регистрация</a>
                <?php endif; ?>
                <button class="burger-menu" id="burgerMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <div class="mobile-menu" id="mobileMenu">
        <nav>
            <ul>
                <li><a href="#home">Главная</a></li>
                <li><a href="#catalog">Каталог</a></li>
                <li><a href="#new">Новинки</a></li>
                <li><a href="#about">О нас</a></li>
                <li><a href="#contact">Контакты</a></li>
                <li><a href="#!">Корзина</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="login.php" class="auth-btn">Войти</a>
                    <a href="register.php" class="auth-btn">Регистрация</a>
                <?php else: ?>
                    <a href="logout.php" class="auth-btn">Выйти</a>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <section id="home" class="hero">
        <div class="container">
            <h2>Все для вашей кондитерской мечты</h2>
            <p>Качественные ингредиенты и инструменты для создания идеальных десертов</p>
            <a href="#catalog" class="cta-button">Смотреть каталог</a>
        </div>
    </section>

    <section id="categories" class="categories">
        <div class="container">
            <h2>Категории товаров</h2>
            <div class="categories-grid">
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?w=500" alt="Формы">
                    <h3>Формы для выпечки</h3>
                </div>
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1587248720327-8eb72564be1e?w=500" alt="Ингредиенты">
                    <h3>Ингредиенты</h3>
                </div>
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1591985666643-1ecc67616216?w=500" alt="Инструменты">
                    <h3>Инструменты</h3>
                </div>
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?w=500" alt="Декор">
                    <h3>Декор</h3>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog" class="catalog">
        <div class="container">
            <h2>Каталог товаров</h2>
            <div class="catalog-filters">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Поиск товаров...">
                </div>
                <div class="sort-box">
                    <select id="sortSelect">
                        <option value="default">По умолчанию</option>
                        <option value="priceAsc">Цена: по возрастанию</option>
                        <option value="priceDesc">Цена: по убыванию</option>
                        <option value="nameAsc">По названию: А-Я</option>
                    </select>
                </div>
            </div>
            <div class="products-grid" id="productsGrid">
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <h2>О нас</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>Мы специализируемся на поставке высококачественных товаров для кондитеров любого уровня. Наш магазин предлагает широкий ассортимент инструментов, ингредиентов и декора для создания идеальных десертов.</p>
                </div>
                <div class="about-features">
                    <div class="feature">
                        <i class="fas fa-truck"></i>
                        <h3>Быстрая доставка</h3>
                    </div>
                    <div class="feature">
                        <i class="fas fa-medal"></i>
                        <h3>Гарантия качества</h3>
                    </div>
                    <div class="feature">
                        <i class="fas fa-headset"></i>
                        <h3>Поддержка 24/7</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <div class="container">
            <h2>Контакты</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>ул. Примерная, 123, Город</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <p>+7 (999) 123-45-67</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p>info@confectionery.ru</p>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm">
                        <input type="text" placeholder="Ваше имя" required>
                        <input type="email" placeholder="Email" required>
                        <textarea placeholder="Сообщение" required></textarea>
                        <button type="submit">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Все для кондитера</h3>
                    <p>Ваш надежный партнер в мире кондитерского искусства</p>
                </div>
                <div class="footer-section">
                    <h3>Меню</h3>
                    <ul>
                        <li><a href="#home">Главная</a></li>
                        <li><a href="#catalog">Каталог</a></li>
                        <li><a href="#about">О нас</a></li>
                        <li><a href="#contact">Контакты</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Социальные сети</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-vk"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        var user_name = "<?php echo isset($user_name) ? $user_name : ''; ?>";
    </script>
    <script src="js/main.js"></script>
</body>
</html>
