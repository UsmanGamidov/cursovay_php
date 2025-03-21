<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm-password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];

        if ($password !== $confirm_password) {
            echo "<script>alert('Пароли не совпадают!'); window.history.back();</script>";
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Пользователь с таким именем уже существует.'); window.history.back();</script>";
            exit;
        }
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Пользователь с таким email уже существует.'); window.history.back();</script>";
            exit;
        }
        $query = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Регистрация прошла успешно!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Ошибка регистрации: " . $stmt->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Все поля должны быть заполнены!'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Все для кондитера</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <form class="auth-form" action="register.php" method="POST">
            <h2>Регистрация</h2>
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Подтверждение пароля:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" class="auth-submit">Зарегистрироваться</button>
            <p class="auth-link">
                Уже есть аккаунт? <a href="login.php">Войти</a>
            </p>
            <a href="index.php" class="back-to-home">На главную</a>
        </form>
    </div>
</body>
</html>
