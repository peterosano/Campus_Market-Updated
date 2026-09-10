<?php

session_start();

include "config/database.php";


// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// Get all conversations involving the logged-in user
$stmt = $conn->prepare("
    SELECT
        c.id,
        c.product_id,
        c.buyer_id,
        c.seller_id,
        c.created_at,
        p.product_name,

        CASE
            WHEN c.buyer_id = ? THEN seller.full_name
            ELSE buyer.full_name
        END AS other_user

    FROM conversations c

    JOIN products p
        ON c.product_id = p.id

    JOIN users buyer
        ON c.buyer_id = buyer.id

    JOIN users seller
        ON c.seller_id = seller.id

    WHERE c.buyer_id = ?
       OR c.seller_id = ?

    ORDER BY c.created_at DESC
");

$stmt->bind_param(
    "iii",
    $user_id,
    $user_id,
    $user_id
);

$stmt->execute();

$conversations = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Messages - Campus Market</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>


<body class="bg-light">


<!-- Navbar -->

<nav class="navbar navbar-dark bg-primary">

<div class="container">

<a
href="products.php"
class="navbar-brand fw-bold">

🎓 Campus Market

</a>

<div>

<a
href="products.php"
class="btn btn-light me-2">

Products

</a>

<a
href="logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</div>

</nav>


<!-- Main content -->

<div class="container my-5">

<h2 class="mb-4">

📨 My Messages

</h2>


<?php if ($conversations->num_rows > 0) { ?>


<div class="row g-3">


<?php while ($conversation = $conversations->fetch_assoc()) { ?>


<div class="col-md-6">


<div class="card shadow-sm">


<div class="card-body">


<h5 class="card-title">

<?php

echo htmlspecialchars(
    $conversation['product_name']
);

?>

</h5>


<p class="mb-2">

<strong>Conversation with:</strong>

<?php

echo htmlspecialchars(
    $conversation['other_user']
);

?>

</p>


<p class="text-muted">

Started:

<?php

echo htmlspecialchars(
    $conversation['created_at']
);

?>

</p>


<a
href="messages.php?id=<?php echo $conversation['id']; ?>"
class="btn btn-primary w-100">

💬 Open Conversation

</a>


</div>

</div>


</div>


<?php } ?>


</div>


<?php } else { ?>


<div class="card shadow-sm">

<div class="card-body text-center">

<h4>No messages yet</h4>

<p class="text-muted">

When you contact a seller or someone contacts you,
your conversations will appear here.

</p>

<a
href="products.php"
class="btn btn-primary">

Browse Products

</a>

</div>

</div>


<?php } ?>


</div>


<footer class="bg-primary text-white text-center p-3">

© 2026 Campus Market

</footer>


</body>

</html>