<?php
session_start();
include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Products - Campus Market</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand fw-bold" href="index.php">
🎓 Campus Market
</a>

<div class="d-flex align-items-center">

<span class="text-white me-3">
Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>
</span>

<a href="sell-item.php" class="btn btn-warning me-2">
Sell Item
</a>

<a href="my-messages.php" class="btn btn-light me-2">
📨 Messages
</a>

<a href="logout.php" class="btn btn-danger">
Logout
</a>

</div>

</div>

</nav>



<div class="container my-5">


<h2 class="text-center mb-4">
Available Products
</h2>
<form method="GET" class="mb-4">

    <div class="input-group">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search by product name..."
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

        <button class="btn btn-primary" type="submit">
            Search
        </button>

    </div>

</form>



<div class="row g-4">

<?php

if (isset($_GET['search']) && $_GET['search'] != "") {

    $search = $conn->real_escape_string($_GET['search']);

    $sql = "SELECT * FROM products
            WHERE product_name LIKE '%$search%'
            ORDER BY created_at DESC";

} else {

    $sql = "SELECT * FROM products
            ORDER BY created_at DESC";

}

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

?>

<div class="col-md-4">

    <div class="card shadow h-100">

        <img src="uploads/<?php echo $row['image']; ?>"
             class="card-img-top"
             style="height:250px; object-fit:cover;">

        <div class="card-body">

           <h5><?php echo $row['product_name']; ?></h5>

            <p><?php echo $row['description']; ?></p>

            <h4 class="text-primary">
                KSh <?php echo $row['price']; ?>
            </h4>

            <p><strong>Category:</strong> <?php echo $row['category']; ?></p>

           <p>
    <strong>Contact:</strong>
    <?php echo htmlspecialchars($row['contact']); ?>
</p>

<?php if ($row['user_id'] != $_SESSION['user_id']) { ?>

    <!-- Contact Seller button -->
    <a href="contact-seller.php?product_id=<?php echo $row['id']; ?>"
       class="btn btn-success w-100 mb-2">
        💬 Contact Seller
    </a>

<?php } else { ?>

    <!-- Edit Product -->
    <a href="edit-product.php?id=<?php echo $row['id']; ?>"
       class="btn btn-warning w-100 mb-2">
        Edit Product
    </a>

    <!-- Delete Product -->
    <a href="delete-product.php?id=<?php echo $row['id']; ?>"
       class="btn btn-danger w-100"
       onclick="return confirm('Are you sure you want to delete this product?');">
        Delete Product
    </a>

<?php } ?>

          </div>

    </div>

</div>

<?php

    } // closes while loop

} else {

    echo "<h4 class='text-center'>No products available.</h4>";

}

?>

</div>

<footer class="bg-primary text-white text-center p-3">

© 2026 Campus Market

</footer>

</body>

</html>