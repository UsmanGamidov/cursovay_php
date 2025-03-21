<?php
session_start();
require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id']) || !isset($data['product_id'])) {
    echo json_encode(["success" => false, "message" => "Ошибка данных"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($data['product_id']);

$query = "INSERT INTO cart (user_id, product_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Ошибка добавления"]);
}

$stmt->close();
$conn->close();
?>