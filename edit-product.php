<?php
session_start();
include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Load the product and make sure it belongs to the logged-in user
$sql = "SELECT * FROM products WHERE id = '$id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Product not found or you do not have permission to edit it.");
}

$product = $result->fetch_assoc();

// Update the product
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $contact = $_POST['contact'];

    $update = "UPDATE products
               SET product_name='$product_name',
                   category='$category',
                   price='$price',
                   description='$description',
                   contact='$contact'
               WHERE id='$id' AND user_id='$user_id'";

    if ($conn->query($update) === TRUE) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Product - Campus Market</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="products.php">
            🎓 Campus Market
        </a>
    </div>
</nav>

<div class="container my-5">

<h2 class="text-center mb-4">
Edit Product
</h2>

<div class="card shadow p-4">

<form method="POST">
    <div class="mb-3">
    <label class="form-label">Product Name</label>
    <input
        type="text"
        name="product_name"
        class="form-control"
        value="<?php echo htmlspecialchars($product['product_name']); ?>"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Category</label>

    <select name="category" class="form-select" required>

        <option value="Electronics" <?php if($product['category']=="Electronics") echo "selected"; ?>>Electronics</option>

        <option value="Books" <?php if($product['category']=="Books") echo "selected"; ?>>Books</option>

        <option value="Furniture" <?php if($product['category']=="Furniture") echo "selected"; ?>>Furniture</option>

        <option value="Clothing" <?php if($product['category']=="Clothing") echo "selected"; ?>>Clothing</option>

        <option value="Other" <?php if($product['category']=="Other") echo "selected"; ?>>Other</option>

    </select>

</div>

<div class="mb-3">
    <label class="form-label">Price</label>

    <input
        type="number"
        name="price"
        class="form-control"
        value="<?php echo htmlspecialchars($product['price']); ?>"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>

    <textarea
        name="description"
        class="form-control"
        rows="4"
        required><?php echo htmlspecialchars($product['description']); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Contact</label>

    <input
        type="text"
        name="contact"
        class="form-control"
        value="<?php echo htmlspecialchars($product['contact']); ?>"
        required>
</div>

<button class="btn btn-success w-100">
    Update Product
</button>

</form>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>