<?php

session_start();

include "config/database.php";


// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$buyer_id = $_SESSION['user_id'];


// Check product ID
if (!isset($_GET['product_id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['product_id']);


// Get product and seller
$stmt = $conn->prepare("
    SELECT id, product_name, user_id
    FROM products
    WHERE id = ?
");

$stmt->bind_param("i", $product_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

$seller_id = $product['user_id'];


// Don't allow seller to contact themselves
if ($buyer_id == $seller_id) {
    header("Location: products.php");
    exit();
}


// Check if conversation already exists
$stmt = $conn->prepare("
    SELECT id
    FROM conversations
    WHERE buyer_id = ?
    AND seller_id = ?
    AND product_id = ?
");

$stmt->bind_param("iii", $buyer_id, $seller_id, $product_id);
$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows > 0) {

    $conversation = $result->fetch_assoc();

    $conversation_id = $conversation['id'];

} else {

    // Create new conversation
    $stmt = $conn->prepare("
        INSERT INTO conversations
        (buyer_id, seller_id, product_id)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("iii", $buyer_id, $seller_id, $product_id);

    $stmt->execute();

    $conversation_id = $conn->insert_id;
}


// Open messaging page
header("Location: messages.php?id=" . $conversation_id);
exit();

?>