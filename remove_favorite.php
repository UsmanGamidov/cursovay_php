<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'Не авторизован']);
    exit();
}

$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

if ($product_id && isset($_SESSION['favorites'])) {
    $index = array_search($product_id, $_SESSION['favorites']);
    if ($index !== false) {
        unset($_SESSION['favorites'][$index]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Товар не найден в избранном']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Неверные данные']);
}
?>
