<?php
include('db_connection.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

$sql = "SELECT * FROM products WHERE name LIKE ?";
$params = ["%$search%"];

if ($sort == 'priceAsc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort == 'priceDesc') {
    $sql .= " ORDER BY price DESC";
} elseif ($sort == 'nameAsc') {
    $sql .= " ORDER BY name ASC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $params[0]); // Привязываем параметр
$stmt->execute();

$result = $stmt->get_result();
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode(['products' => $products]);
?>
