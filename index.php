<?php
include "config/database.php";

/*
    Get the 3 newest products from the database
*/
$sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Market - Buy & Sell on Campus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {
            background: #f5f7fa;
        }

        /* Navbar */
        .navbar {
            padding: 12px 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        /* Hero */
        .hero {
            background:
                linear-gradient(rgba(0,0,0,.60), rgba(0,0,0,.60)),
                url('https://images.unsplash.com/photo-1523240795612-9a054b0db644');

            background-size: cover;
            background-position: center;

            min-height: 82vh;

            color: white;
        }

        .hero h1 {
            font-size: 4rem;
        }

        .hero p {
            max-width: 900px;
            margin: 20px auto;
        }

        /* Product cards */
        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-7px);
        }

        .product-card img {
            height: 230px;
            object-fit: cover;
        }

        .price {
            font-size: 1.6rem;
            font-weight: bold;
            color: #0d6efd;
        }

        /* Why choose section */
        .why-section {
            background: #0d6efd;
        }

        .feature {
            padding: 20px;
        }

        .feature-icon {
            font-size: 3rem;
        }

        /* Footer */
        .footer {
            background: #084298;
            color: white;
            padding: 25px;
        }

        @media (max-width: 768px) {

            .hero h1 {
                font-size: 2.7rem;
            }

            .hero {
                min-height: 75vh;
            }

        }

    </style>

</head>


<body>


<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            🎓 Campus Market
        </a>


        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        Home
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="products.php">
                        Products
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="sell-item.php">
                        Sell Item
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        Login
                    </a>
                </li>


                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">

                    <a class="btn btn-light px-4" href="register.php">
                        Register
                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- ================= HERO ================= -->

<section class="hero d-flex align-items-center">

    <div class="container text-center">

        <h1 class="display-3 fw-bold">
            Buy & Sell on Campus
        </h1>


        <p class="lead fs-4">

            The easiest way for university students to buy and sell
            textbooks, electronics, furniture and more.

        </p>


        <div class="mt-4">

            <a
                href="products.php"
                class="btn btn-warning btn-lg px-5 py-3 fw-bold">

                🛒 Browse Products

            </a>

            <a
                href="sell-item.php"
                class="btn btn-outline-light btn-lg px-5 py-3 ms-2">

                Sell an Item

            </a>

        </div>

    </div>

</section>



<!-- ================= LATEST PRODUCTS ================= -->

<div class="container my-5">

    <h2 class="text-center fw-bold mb-2">
        Latest Products
    </h2>

    <p class="text-center text-muted mb-5">
        Discover the newest items listed by students
    </p>


    <div class="row g-4">


        <?php

        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

            <div class="col-md-4">

                <div class="card product-card shadow h-100">


                    <?php if (!empty($row['image'])) { ?>

                        <img
                            src="uploads/<?php echo htmlspecialchars($row['image']); ?>"
                            class="card-img-top"
                            alt="<?php echo htmlspecialchars($row['product_name']); ?>">

                    <?php } else { ?>

                        <div
                            class="bg-light d-flex align-items-center justify-content-center"
                            style="height:230px;">

                            <span class="text-muted">
                                No image available
                            </span>

                        </div>

                    <?php } ?>


                    <div class="card-body d-flex flex-column">


                        <h4 class="card-title fw-bold">

                            <?php echo htmlspecialchars($row['product_name']); ?>

                        </h4>


                        <p class="text-muted">

                            <?php

                            $description = htmlspecialchars($row['description']);

                            if (strlen($description) > 90) {

                                echo substr($description, 0, 90) . "...";

                            } else {

                                echo $description;

                            }

                            ?>

                        </p>


                        <div class="price mb-3">

                            KSh <?php echo number_format($row['price'], 2); ?>

                        </div>


                        <a
                            href="login.php"
                            class="btn btn-primary w-100 mt-auto">

                            View Product

                        </a>


                    </div>

                </div>

            </div>


        <?php

            }

        } else {

        ?>

            <div class="col-12 text-center">

                <div class="alert alert-info">

                    No products have been listed yet.

                    <br>

                    <a href="register.php" class="btn btn-primary mt-3">
                        Register and Sell an Item
                    </a>

                </div>

            </div>

        <?php

        }

        ?>


    </div>


    <div class="text-center mt-5">

        <a
            href="products.php"
            class="btn btn-outline-primary btn-lg px-5">

            View All Products →

        </a>

    </div>

</div>



<!-- ================= WHY CHOOSE CAMPUS MARKET ================= -->

<section class="why-section text-white py-5">

    <div class="container">


        <h2 class="text-center fw-bold mb-5">

            Why Choose Campus Market?

        </h2>


        <div class="row text-center">


            <div class="col-md-4 feature">

                <div class="feature-icon">
                    💰
                </div>

                <h4 class="fw-bold mt-3">
                    Affordable Prices
                </h4>

                <p>
                    Buy quality second-hand items at
                    student-friendly prices.
                </p>

            </div>


            <div class="col-md-4 feature">

                <div class="feature-icon">
                    🎓
                </div>

                <h4 class="fw-bold mt-3">
                    Student Community
                </h4>

                <p>
                    Connect with fellow students to
                    buy and sell items easily.
                </p>

            </div>


            <div class="col-md-4 feature">

                <div class="feature-icon">
                    🔒
                </div>

                <h4 class="fw-bold mt-3">
                    Secure Marketplace
                </h4>

                <p>
                    Registered users can communicate
                    directly through the Campus Market platform.
                </p>

            </div>


        </div>

    </div>

</section>



<!-- ================= FOOTER ================= -->

<footer class="footer text-center">

    <div class="container">

        <p class="mb-1 fw-bold">
            🎓 Campus Market
        </p>

        <p class="mb-0">
            © 2026 Campus Market. All Rights Reserved.
        </p>

    </div>

</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>