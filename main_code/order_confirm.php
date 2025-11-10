<?php 
include 'config.php';

session_start();
$user = $_SESSION['username'];


$params2 = [
    'product_id' => $_POST['product_id'],
    'product_qty' => $_POST['product_qty'],
    'total_amount' => $_POST['product_total'],
    'product_user' => $_SESSION['user_id'],
    'order_date' => date('Y-m-d'),
];
$db = new Database();

$db->insert('order_products',$params2);
$db->getResult();

echo "Order added successfully";

?>