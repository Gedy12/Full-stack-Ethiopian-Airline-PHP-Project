<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../db_connection.php';

// Fetch unique departure and destination cities for dropdown
$sqlFrom = "SELECT DISTINCT departure_city FROM flights";
$sqlTo = "SELECT DISTINCT destination_city FROM flights";
$fromCities = $pdo->query($sqlFrom)->fetchAll(PDO::FETCH_ASSOC);
$toCities = $pdo->query($sqlTo)->fetchAll(PDO::FETCH_ASSOC);

// Handle search request
$flights = [];
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['from'], $_POST['to'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Check if a flight exists with selected departure and destination
    $stmt = $pdo->prepare("SELECT * FROM flights WHERE departure_city = :from AND destination_city = :to");
    $stmt->execute(['from' => $from, 'to' => $to]);
    $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$flights) {
        $error = "No flights found for the selected route.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Flights</title>
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
            justify-content: space-between;
            align-items: center;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .header nav a:hover {
            text-decoration: underline;
        }
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #004080;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #003366;
        }
        .error-message {
            color: red;
            text-align: center;
        }
        .flight-table {
            width: 100%;
            max-width: 850px;
            background: white;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .flight-table th, .flight-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .flight-table th {
            background-color: #004080;
            color: white;
        }
        .book-btn {
            padding: 8px 12px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .book-btn:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="view_flights.php">Available Flights</a>
            <a href="booking_history.php">Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="main-container">
        <div class="container">
            <h2>Select Flight</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="from">From</label>
                    <select name="from" id="from" required>
                        <option value="" disabled selected>Select Departure City</option>
                        <?php foreach ($fromCities as $city): ?>
                            <option value="<?php echo htmlspecialchars($city['departure_city']); ?>">
                                <?php echo htmlspecialchars($city['departure_city']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="to">To</label>
                    <select name="to" id="to" required>
                        <option value="" disabled selected>Select Destination City</option>
                        <?php foreach ($toCities as $city): ?>
                            <option value="<?php echo htmlspecialchars($city['destination_city']); ?>">
                                <?php echo htmlspecialchars($city['destination_city']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="book_now">Search Flight</button>
            </form>
            <?php if ($error): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>

        <?php if ($flights): ?>
            <table class="flight-table">
                <thead>
                    <tr>
                        <th>Flight Model</th>
                        <th>Name</th>
                        <th>Total Seats</th>
                        <th>Price</th>
                        <th>Departure City</th>
                        <th>Destination City</th>
                        <th>Departure Date</th>
                        <th>Action</th> <!-- Added "Action" Column for Booking -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flights as $flight): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($flight['flight_model']); ?></td>
                            <td><?php echo htmlspecialchars($flight['name']); ?></td>
                            <td><?php echo htmlspecialchars($flight['total_seats']); ?></td>
                            <td><?php echo htmlspecialchars($flight['price']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_city']); ?></td>
                            <td><?php echo htmlspecialchars($flight['destination_city']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_date']); ?></td>
                            <td><form method="POST" action="book_flight.php">
                            <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>">
                            <button type="submit" class="button">Book Now</button>
                    </form>
                            </td> <!-- "Book Now" Button -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
