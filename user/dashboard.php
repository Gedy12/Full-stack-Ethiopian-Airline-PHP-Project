<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../db_connection.php';
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.avif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .header {
            background-color: rgb(0, 128, 6);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            flex-wrap: wrap;
        }
        .header nav {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .header nav a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .dashboard-content {
            text-align: center;
            color: white;
        }
        .dashboard-content h2 {
            font-size: 2rem;
        }
        .dashboard-content p {
            font-size: 1.2rem;
        }
        .image-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .image-section img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgb(255, 255, 255);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .image-section img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        /* Flight Table */
        .flight-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            overflow: hidden;
        }
        .flight-table th, .flight-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .flight-table th {
            background: rgb(0, 128, 6);
            color: white;
        }
        /* Book Now Button */
        .book-now-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(234, 165, 26);
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }
        .book-now-btn:hover {
            background-color: rgb(10, 247, 128);
            transform: translateY(-2px);
        }
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            .header nav {
                flex-direction: column;
                align-items: center;
            }
            .flight-table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($email); ?></h1>
        <nav>
            <a href="view_flights.php">Available Flights</a>
            <a href="search_flights.php">Search Flights</a>
            <a href="booking_history.php">Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="dashboard-content">
            <h2>User Dashboard</h2>
            <p>Select an option from the menu above to proceed.</p>

            <!-- Image Section -->
            <div class="image-section">
                <img src="first.jpeg" alt="Flight Image 1">
                <img src="third.jpeg" alt="Flight Image 2">
            </div>
        </div>
    </div>
</body>
</html>
