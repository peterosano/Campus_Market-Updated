<!DOCTYPE html>
<?php
session_start();
include "config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['full_name'];

            header("Location: products.php");
            exit();

        } else {

            echo "<script>alert('Incorrect password!');</script>";

        }

    } else {

        echo "<script>alert('Email not found!');</script>";

    }
}
?>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - Campus Market</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<nav class="navbar navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand fw-bold" href="index.php">
🎓 Campus Market
</a>

</div>

</nav>



<div class="container my-5">


<div class="row justify-content-center">

<div class="col-md-5">


<div class="card shadow p-4">


<h2 class="text-center mb-4">
Login
</h2>



<form method="POST" action="">


<div class="mb-3">

<label class="form-label">
Email
</label>


<input
type="email"
class="form-control"
id="loginEmail"
name="email"
required>

</div>




<div class="mb-3">

<label class="form-label">
Password
</label>


<input
type="password"
class="form-control"
id="loginPassword"
name="password"
required>

</div>




<button class="btn btn-success w-100">

Login

</button>



<p class="text-center mt-3">

Don't have an account?

<a href="register.php">
Register
</a>

</p>



</form>


</div>


</div>


</div>


</div>



<script src="script.js"></script>


</body>

</html>