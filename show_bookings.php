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
        $conn = mysqli_connect("localhost", "root", "", "test_website");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql_book = "SELECT * FROM bookings";
        $result_book = mysqli_query($conn, $sql_book);

        if (mysqli_num_rows($result_book) > 0) {
            while ($row = mysqli_fetch_assoc($result_book)) {
                ?>
                <form action="dummy.php" method="GET">
                    <input type="hidden" name="flight_id" value="<?php echo $row['first_name']; ?>">
                    <div class="flight-info">
                        <p>First Name: <?php echo $row["first_name"]; ?> <br> Last Name: <?php echo $row["last_name"]; ?> <br> Email Address: <?php echo $row["email"]; ?> <br> Flight ID: <?php echo $row["flight_id"]; ?> </p>
                        <hr>
                    </div>
                </form>
                <?php
            }
            
        } else {
            echo "<p>No user bookings found.</h5>";
        }
        mysqli_close($conn);
?>