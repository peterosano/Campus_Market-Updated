<?php

session_start();

include "config/database.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


// Check conversation ID
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$conversation_id = intval($_GET['id']);


// Get conversation
$stmt = $conn->prepare("
    SELECT 
        c.id,
        c.buyer_id,
        c.seller_id,
        c.product_id,
        p.product_name
    FROM conversations c
    JOIN products p ON c.product_id = p.id
    WHERE c.id = ?
    AND (c.buyer_id = ? OR c.seller_id = ?)
");

$stmt->bind_param("iii", $conversation_id, $user_id, $user_id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows == 0) {
    die("Conversation not found.");
}

$conversation = $result->fetch_assoc();


// Send message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $message = trim($_POST['message']);

    if ($message != "") {

        $stmt = $conn->prepare("
            INSERT INTO messages
            (conversation_id, sender_id, message)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "iis",
            $conversation_id,
            $user_id,
            $message
        );

        $stmt->execute();

        header("Location: messages.php?id=" . $conversation_id);
        exit();
    }
}


// Get messages
$stmt = $conn->prepare("
    SELECT 
        m.message,
        m.sender_id,
        m.created_at,
        u.full_name
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.conversation_id = ?
    ORDER BY m.created_at ASC
");

$stmt->bind_param("i", $conversation_id);

$stmt->execute();

$messages = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Messages - Campus Market</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


<nav class="navbar navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand fw-bold" href="products.php">
🎓 Campus Market
</a>

<a href="products.php" class="btn btn-light">
Back to Products
</a>

</div>

</nav>


<div class="container my-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">
💬 Conversation about <?php echo htmlspecialchars($conversation['product_name']); ?>
</h4>

</div>


<div class="card-body" style="height: 400px; overflow-y: auto;">

<?php if ($messages->num_rows > 0) { ?>

    <?php while ($msg = $messages->fetch_assoc()) { ?>

        <?php if ($msg['sender_id'] == $user_id) { ?>

            <div class="text-end mb-3">

                <div class="d-inline-block bg-primary text-white p-3 rounded">

                    <?php echo nl2br(htmlspecialchars($msg['message'])); ?>

                </div>

                <small class="d-block text-muted">
                    You
                </small>

            </div>

        <?php } else { ?>

            <div class="text-start mb-3">

                <div class="d-inline-block bg-light border p-3 rounded">

                    <?php echo nl2br(htmlspecialchars($msg['message'])); ?>

                </div>

                <small class="d-block text-muted">

                    <?php echo htmlspecialchars($msg['full_name']); ?>

                </small>

            </div>

        <?php } ?>

    <?php } ?>

<?php } else { ?>

    <p class="text-center text-muted">
        No messages yet. Start the conversation!
    </p>

<?php } ?>

</div>


<div class="card-footer">

<form method="POST">

<div class="input-group">

<input
    type="text"
    name="message"
    class="form-control"
    placeholder="Type your message..."
    required
>

<button class="btn btn-primary" type="submit">
Send
</button>

</div>

</form>

</div>

</div>

</div>


</body>

</html>