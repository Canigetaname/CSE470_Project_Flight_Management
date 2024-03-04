<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Confirmation</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<?php require 'partials/_nav.php' ?>

<div class="container mt-4">
  <h2>Booking Confirmation</h2>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $conn = mysqli_connect("localhost", "root", "", "test_website"); // Replace with your connection details
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql_user = "SELECT * FROM bookings WHERE id = $id";
    $result_user = mysqli_query($conn, $sql_user);

    if (mysqli_num_rows($result_user) > 0) {
      $user = mysqli_fetch_assoc($result_user);
      echo "<h3>User Details:</h3>";
      echo "<p>Name: " . $user["first_name"] . " " . $user["last_name"] . "</p>";
      echo "<p>Birth Date: " . $user["birth_date"] . "</p>";
      echo "<p>Contact: " . $user["contact"] . "</p>";
      echo "<p>Email: " . $user["email"] . "</p>";
      echo "<p>Passport: " . $user["passport"] . "</p>";
      echo "<p>Address: " . $user["address"] . "</p>";
      echo "<p>Seat Class: " . $user["seat_class"] . "</p>";
      echo "<p>Number of Adults: " . $user["num_adults"] . "</p>";
      echo "<p>Number of Children: " . $user["num_children"] . "</p>";

      // Retrieve flight details
      $flight_id = $user["flight_id"];
      $sql_flight = "SELECT * FROM flights WHERE id = $flight_id";
      $result_flight = mysqli_query($conn, $sql_flight);

      if (mysqli_num_rows($result_flight) > 0) {
        $flight = mysqli_fetch_assoc($result_flight);
        echo "<h3>Flight Details:</h3>";
        echo "<p>Flight ID: " . $flight["id"] . "</p>";
        echo "<p>From: " . $flight["from_city"] . "</p>";
        echo "<p>To: " . $flight["to_city"] . "</p>";
        echo "<p>Date: " . $flight["departure_date"] . "</p>";
        echo "<p>Departure Time: " . $flight["departure_time"] . "</p>";
        echo "<p>Arrival Time: " . $flight["arrival_time"] . "</p>";
      } else {
        echo "<p>Flight details not found.</p>";
      }
    } else {
      echo "<p>User details not found.</p>";
    }

    mysqli_close($conn);
  } else {
    echo "<p>Error: User ID not provided.</p>";
  }
  ?>

  <div class="mt-4">
    <a href="#" class="btn btn-primary">Confirm Booking</a>
    <a href="#" class="btn btn-secondary">Cancel</a>
  </div>
</div>

</body>
</html>
