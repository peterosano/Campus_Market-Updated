<?php
session_start();
include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $contact = $_POST['contact'];

    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];

    $uploadPath = "uploads/" . basename($imageName);

    if (move_uploaded_file($imageTmp, $uploadPath)) {

         $sql = "INSERT INTO products
(user_id, product_name, category, price, description, image, contact)
VALUES
('$user_id', '$title', '$category', '$price', '$description', '$imageName', '$contact')";

        if ($conn->query($sql) === TRUE) {
            header("Location: products.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

    } else {
        echo "Image upload failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sell Item - Campus Market</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand fw-bold" href="index.php">
    🎓 Campus Market
</a>


<div>

<a href="index.php" class="btn btn-light">
Home
</a>

</div>


</div>

</nav>



<div class="container my-5">


<h2 class="text-center mb-4">
Sell Your Item
</h2>



<div class="card shadow p-4">


<form method="POST" action="" enctype="multipart/form-data">


<div class="mb-3">

<label class="form-label">
Product Name
</label>

<input
type="text"
class="form-control"
id="productName"
name="title"
placeholder="Example: Laptop"
required>

</div>



<div class="mb-3">

<label class="form-label">
Category
</label>


<select class="form-select" id="category" name="category" required>

<option>
Electronics
</option>

<option>
Books
</option>

<option>
Furniture
</option>

<option>
Clothing
</option>

<option>
Other
</option>


</select>


</div>



<div class="mb-3">

<label class="form-label">
Price
</label>

<input
type="number"
class="form-control"
id="price"
name="price"
placeholder="Enter price"
required>

</div>




<div class="mb-3">

<label class="form-label">
Description
</label>


<textarea
class="form-control"
id="description"
name="description"
rows="4"
placeholder="Describe your item"
required></textarea>


</div>



<div class="mb-3">

<label class="form-label">
Product Image
</label>


<input
type="file"
class="form-control"
name="image"
required>
</div>




<div class="mb-3">

<label class="form-label">
Your Contact
</label>


<input
type="text"
class="form-control"
name="contact"
placeholder="Phone or email"
required>

</div>




<button class="btn btn-success w-100">

Post Item

</button>



</form>


</div>


</div>



<script src="script.js"></script>


</body>

</html>