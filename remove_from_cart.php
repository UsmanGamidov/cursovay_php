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

$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cartId, $userId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Ошибка удаления из корзины"]);
}

$stmt->close();
$conn->close();
?>