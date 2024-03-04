<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $passport = $_POST['passport'];
    $address = $_POST['address'];
    $seat_class = $_POST['seat_class'];
    $num_adults = $_POST['num_adults'];
    $num_children = $_POST['num_children'];
    $flight_id = $_POST['flight_id']; // Add flight_id field

    $sql_insert = "INSERT INTO bookings (flight_id, first_name, last_name, birth_date, contact, email, passport, address, seat_class, num_adults, num_children)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql_insert);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", $flight_id, $first_name, $last_name, $birth_date, $contact, $email, $passport, $address, $seat_class, $num_adults, $num_children);

        if (mysqli_stmt_execute($stmt)) {
            $showAlert = true;
        } else {
            $showError = mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        $showError = "Statement preparation failed";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
</head>
<body>

<?php require 'partials/_nav.php' ?>

<div class="container mt-4">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['flight_id'])) {
        $flight_id = $_GET['flight_id'];

        $conn = mysqli_connect("localhost", "root", "", "test_website");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql_flight = "SELECT * FROM flights WHERE flight_id = $flight_id";
        $result_flight = mysqli_query($conn, $sql_flight);

        if (mysqli_num_rows($result_flight) > 0) {
            $flight = mysqli_fetch_assoc($result_flight);
            echo "<h2>Flight Details (for reference):</h2>";
            echo "<h5>Flight ID: " . $flight["flight_id"] . "</h5>";
            echo "<h5>From: " . $flight["from_city"] . "</h5>";
            echo "<h5>To: " . $flight["to_city"] . "</h5>";
            echo "<h5>Date: " . $flight["departure_date"] . "</h5>";
            echo "<h5>Departure Time: " . $flight["departure_time"] . "</h5>";
            echo "<h5>Arrival Time: " . $flight["arrival_time"] . "</h5>";
        } else {
            echo "<p>Flight not found.</h5>";
        }

        echo "<h3>Enter User Details Below:</h3>";

        mysqli_close($conn);
    }
    ?>
    <form class="needs-validation" novalidate method="post"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Add flight_id input field -->
        <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="birth_date">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="passport">Passport</label>
                <input type="text" class="form-control" id="passport" name="passport" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="seat_class">Seat Class</label>
                <select class="custom-select" id="seat_class" name="seat_class" required>
                    <option value="">Choose...</option>
                    <option value="business">Business Class</option>
                    <option value="economy">Economy Class</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="num_adults">Number of Adults</label>
                <input type="number" class="form-control" id="num_adults" name="num_adults" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="num_children">Number of Children</label>
                <input type="number" class="form-control" id="num_children" name="num_children" required>
            </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Confirm Booking</button>
    </form>

    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Booking details saved successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $showError . '.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    ?>
</div>
</body>
</html>
