<!DOCTYPE html>
<html lang="en">
    
    <!-- Bootstrap Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                session_start();
                require 'db_connection.php';
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                    $stmt->execute(['email' => $email]);
                    $user = $stmt->fetch();

                    if ($user && password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['role'] = $user['role'];

                        if ($user['role'] === 'admin') {
                            echo "<script>window.location.href='admin/dashboard.php';</script>";
                        } else {
                            echo "<script>window.location.href='user/dashboard.php';</script>";
                        }
                        exit;
                    } else {
                        echo "<p style='color: red;'>Invalid email or password.</p>";
                    }
                }
                ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethiopian Airlines</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo.jpeg" alt="Ethiopian Airlines Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    <li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
</li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="text-center p-5 bg-light">
        <h1 class="display-5">Welcome to Ethiopian Airlines</h1>
        <img src="first.jpeg" class="img-fluid rounded shadow" alt="Ethiopian Airline">
        <p class="lead mt-3">Experience the comfort and reliability of Ethiopian Airlines.</p>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container text-center">
            <h2>About Us</h2>
            <p>We provide the best airline services with exceptional customer care. Discover new destinations with us.</p>
            <div class="row">
                <div class="col-md-4"><img src="fourth.jpeg" class="img-fluid rounded shadow" alt="Flight 1"></div>
                <div class="col-md-4"><img src="second.jpeg" class="img-fluid rounded shadow" alt="Flight 2"></div>
                <div class="col-md-4"><img src="third.jpeg" class="img-fluid rounded shadow" alt="Flight 3"></div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center">Contact Us</h2>
            <form action="contact.php" method="POST" class="w-50 mx-auto">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message:</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        &copy; 2025 Ethiopian Airlines. All Rights Reserved.
    </footer>
</body>
</html>
