<?php
session_start();
require "db_connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];

$stmt = $conn->prepare("SELECT orders.id, products.name, products.price, products.image, orders.order_date 
                        FROM orders 
                        JOIN products ON orders.product_id = products.id 
                        WHERE orders.user_id = ? 
                        ORDER BY orders.order_date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .user-info-panel {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-info-panel h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .user-info-panel p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }

        .orders-container {
            margin-top: 50px !important;
            margin-bottom: 50px !important;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .order-item .info {
            flex: 1;
        }

        .order-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .order-item p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }

        .order-item .order-date {
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <h1>Все для кондитера</h1>
            </div>
            <nav class="desktop-nav">
                <ul>
                    <li><a href="index.php">Главная</a></li>
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
                <?php if (!empty($userName)): ?>
                    <span class="user-info" style="font-size:10px; color: brown;">
                        <?= $userName ?> (<?= $userEmail ?>)
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

    <h1>Мои заказы</h1>
    <div class="orders-container">
        <div class="user-info-panel">
            <h2>Данные заказчика</h2>
            <p>Имя: <?= $userName ?></p>
            <p>Email: <?= $userEmail ?></p>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="order-item">
                    <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
                    <div class="info">
                        <h3><?= $row['name'] ?></h3>
                        <p style="color:red;"><?= $row['price'] ?> ₽</p>
                        <p class="order-date">Дата заказа: <?= date('d.m.Y H:i', strtotime($row['order_date'])) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>У вас пока нет заказов.</p>
        <?php endif; ?>
    </div>
</body>
</html>