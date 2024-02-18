<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>
    <link rel="stylesheet" href="styles.css"> 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<?php require 'partials/_nav.php' ?>

<div class="container mt-4">
    <?php
    $conn = mysqli_connect("localhost", "root", "", "test_website");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['flight_id'])) {
        $flight_id = $_GET['flight_id'];
        $sql = "SELECT * FROM flights WHERE id = $flight_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $flight = mysqli_fetch_assoc($result);
            echo "<h2>Flight Details</h2>";
            echo "<p><strong>Flight ID:</strong> " . $flight["id"] . "</p>";
            echo "<p><strong>From:</strong> " . $flight["from_city"] . "</p>";
            echo "<p><strong>To:</strong> " . $flight["to_city"] . "</p>";
            echo "<p><strong>Departure Time:</strong> " . $flight["departure_time"] . "</p>";
            echo "<p><strong>Arrival Time:</strong> " . $flight["arrival_time"] . "</p>";
            echo "<p><strong>Duration:</strong> " . $flight["duration"] . "</p>";
            echo "<p><strong>Price:</strong> $" . $flight["price"] . "</p>";
            echo "<p><strong>Airline:</strong> " . $flight["airline"] . "</p>";
            echo "<p><strong>Departure Date:</strong> " . $flight["departure_date"] . "</p>";

            $sql_seat_status = "SELECT * FROM seat_status WHERE flight_id = $flight_id";
            $result_seat_status = mysqli_query($conn, $sql_seat_status);

            echo "<h3>Seat Status</h3>";
            echo "<div class='table-responsive'>";
            echo "<table class='table'>";
            echo "<thead><tr><th>Seat Number</th><th>Status</th></tr></thead>";
            echo "<tbody>";
            while ($seat = mysqli_fetch_assoc($result_seat_status)) {
                echo "<tr><td>" . $seat['seat_number'] . "</td><td>" . $seat['status'] . "</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";

            echo "<a href='home.php' class='btn btn-secondary mr-2'>Go Back</a>";

            echo "<a href='dummy.php?flight_id=$flight_id' class='btn btn-primary'>Book Seats</a>";
        } else {
            echo "<p>Flight not found.</p>";
        }
    } else {
        echo "<p>Flight ID not provided.</p>";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
