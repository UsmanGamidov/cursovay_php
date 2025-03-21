<?php
session_start();
require "db_connection.php";

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получаем данные пользователя из сессии
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Получаем товары из корзины для текущего пользователя
$stmt = $conn->prepare("SELECT cart.id AS cart_id, products.name, products.price, products.image FROM cart 
                        JOIN products ON cart.product_id = products.id 
                        WHERE cart.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .cart-container {
            margin-top: 50px !important;
            margin-bottom: 50px !important;
            margin-top: 100px;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .cart-item .info {
            flex: 1;
        }

        .cart-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .cart-item p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }

        .cart-item button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #ff5956;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cart-item button:hover {
            background-color: #e04a47;
        }

        .cart-item .checkout-btn {
            background-color: #28a745;
            margin-left: 10px;
        }

        .cart-item .checkout-btn:hover {
            background-color: #218838;
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
                <?php if (!empty($user_name)): ?>
                    <span class="user-info" style="font-size:10px; color: brown;">
                        <?= $user_name ?> (<?= $user_email ?>)
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

    <h1>Корзина</h1>
    <div class="cart-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="cart-item">
                <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
                <div class="info">
                    <h3><?= $row['name'] ?></h3>
                    <p><?= $row['price'] ?> ₽</p>
                </div>
                <button class="remove-from-cart" data-id="<?= $row['cart_id'] ?>">Удалить</button>
                <button class="checkout-btn" data-id="<?= $row['cart_id'] ?>">Оформить заказ</button>
            </div>
            
        <?php endwhile; ?>   
    </div>
    <script>
        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', async (event) => {
                const cartId = event.target.dataset.id;

                try {
                    const response = await fetch('remove_from_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ cart_id: cartId })
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Товар удален из корзины');
                        location.reload();
                    } else {
                        alert('Ошибка при удалении товара из корзины: ' + (result.error || 'Неизвестная ошибка'));
                    }
                } catch (error) {
                    console.error('Ошибка при удалении товара из корзины:', error);
                    alert('Ошибка при удалении товара из корзины');
                }
            });
        })

        document.querySelectorAll('.checkout-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
        const cartId = event.target.dataset.id;

        try {
            const response = await fetch('checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cart_id: cartId })
            });

            const result = await response.json();

            if (result.success) {
                alert('Заказ оформлен');
                location.reload(); 
            } else {
                alert('Ошибка при оформлении заказа: ' + (result.error || 'Неизвестная ошибка'));
            }
        } catch (error) {
            console.error('Ошибка при оформлении заказа:', error);
            alert('Ошибка при оформлении заказа');
        }
    });
});
    </script>
</body>
</html>