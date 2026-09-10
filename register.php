<!DOCTYPE html>
   <?php
include "config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");

    if ($check->num_rows > 0) {

        echo "<script>alert('This email is already registered.');</script>";

    } else {

        $sql = "INSERT INTO users (full_name, email, password)
                VALUES ('$fullname', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {

            echo "<script>
                    alert('Registration successful!');
                    window.location='login.php';
                  </script>";

        } else {

            echo "<script>alert('".$conn->error."');</script>";

        }
    }
}
?>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register - Campus Market</title>

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

<div class="col-md-6">


<div class="card shadow p-4">


<h2 class="text-center mb-4">
Create Account
</h2>



<form method="POST" action="">


<div class="mb-3">

<label class="form-label">
Full Name
</label>

<input 
type="text"
class="form-control"
id="fullName"
name="fullname"
placeholder="Enter your name"
required>
</div>



<div class="mb-3">

<label class="form-label">
Student Email
</label>

<input 
type="email"
class="form-control"
id="email"
name="email"
placeholder="student@email.com"
required>

</div>



<div class="mb-3">

<label class="form-label">
Password
</label>

<input 
type="password"
class="form-control"
id="password"
name="password"
required>
</div>



<button class="btn btn-primary w-100">

Register

</button>



<p class="text-center mt-3">

Already have an account?

<a href="login.php">
Login
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