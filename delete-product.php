<?php
session_start();
include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Check that the product belongs to the logged-in user
    $result = $conn->query("SELECT image FROM products WHERE id = $id AND user_id = $user_id");

    if ($result->num_rows == 1) {

        $product = $result->fetch_assoc();

        // Delete the image file if it exists
        if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
            unlink("uploads/" . $product['image']);
        }

        // Delete the product from the database
        $conn->query("DELETE FROM products WHERE id = $id AND user_id = $user_id");
    }
}

header("Location: products.php");
exit();
?>