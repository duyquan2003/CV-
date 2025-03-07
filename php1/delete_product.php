<?php
$conn = new mysqli('localhost', 'root', '', 'masv_examphp1');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$product_id = $_GET['id'];

$conn->query("DELETE FROM products WHERE product_id = $product_id");

header('Location: index.php');
exit;
