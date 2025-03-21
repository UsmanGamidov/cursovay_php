<?php
session_start();

if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit();
}

$favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : [];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранные товары</title>
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="favorites.php">Избранные</a></li>
                <li><a href="#about">О нас</a></li>
                <li><a href="#contact">Контакты</a></li>
            </ul>
        </nav>
        <div class="header-buttons">
            <span class="user-info">
                <?php echo $user_name; ?> (<?php echo $user_email; ?>)
            </span>
            <a href="logout.php" class="auth-btn">Выйти</a>
        </div>
    </div>
</header>

<section id="favorites" class="favorites">
    <div class="container">
        <h2>Избранные товары</h2>

        <?php
        if (count($favorites) > 0) {
            echo '<div class="favorites-grid">';
            foreach ($favorites as $product_id) {
                $product = getProductById($product_id); 
                echo '<div class="favorite-item">';
                echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '" style="width: 100px; height: 100px; object-fit: cover;">';
                echo '<div class="favorite-info">';
                echo '<h3>' . $product['name'] . '</h3>';
                echo '<p>' . $product['price'] . ' ₽</p>';
                echo '<button onclick="removeFromFavorites(' . $product['id'] . ')">Удалить</button>';
                echo '</div></div>';
            }
            echo '</div>';
        } else {
            echo '<p>У вас нет избранных товаров.</p>';
        }
        ?>

    </div>
</section>

<script>
    function removeFromFavorites(productId) {
        fetch('remove_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'product_id=' + productId
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  window.location.reload();
              } else {
                  alert('Ошибка удаления товара из избранного');
              }
          });
    }
</script>

</body>
</html>
