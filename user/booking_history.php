<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../db_connection.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT b.*, f.name AS flight_name, f.flight_model, f.departure_city, f.destination_city
        FROM bookings b
        JOIN flights f ON b.flight_id = f.id
        WHERE b.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #004080;
            color: white;
            padding: 15px 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }
        .header nav {
            display: flex;
            flex-wrap: wrap;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin: 5px 10px;
        }
        .header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        .booking-list {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .booking-item {
            flex: 1 1 300px;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .button {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
        }
        .button:hover {
            background-color: #003366;
        }
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            .header nav {
                flex-direction: column;
            }
            .booking-item {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="view_flights.php">View Available Flights</a>
            <a href="search_flights.php">Search Flights</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Your Booking History</h2>
        <div class="booking-list">
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-item">
                    <h3><?php echo htmlspecialchars($booking['flight_name']); ?> (<?php echo htmlspecialchars($booking['flight_model']); ?>)</h3>
                    <p>From: <?php echo htmlspecialchars($booking['departure_city']); ?> to <?php echo htmlspecialchars($booking['destination_city']); ?></p>
                    <p>Booking Date: <?php echo htmlspecialchars($booking['created_at']); ?></p>
                    <p>Status: <?php echo htmlspecialchars($booking['payment_status']); ?></p>
                    <form method="POST" action="cancel_booking.php" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                        <button type="submit" class="button" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel Booking</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>