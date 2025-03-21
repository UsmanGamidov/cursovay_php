<?php
include('db_connection.php');
header('Content-Type: application/json');

$query = "SELECT * FROM products";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
} else {
    echo json_encode(['error' => 'Товары не найдены']);
}
?>
