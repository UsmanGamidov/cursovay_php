<?php
session_start();
require "db_connection.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Пользователь не авторизован"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['cart_id'])) {
    echo json_encode(["success" => false, "error" => "Неверные данные"]);
    exit;
}

$cartId = intval($data['cart_id']);
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT product_id FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cartId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cartItem = $result->fetch_assoc();
    $productId = $cartItem['product_id'];
    $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $productId);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->bind_param("i", $cartId);
        $stmt->execute();

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Ошибка оформления заказа"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Товар не найден в корзине"]);
}

$stmt->close();
$conn->close();
?>