<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Want to book a flight!!</title>
  </head>
  <body>
    <?php require 'partials/_nav.php' ?>
    <div class="container my-4">
      <div class="alert alert-success" role="alert">
        <p>Welcome to Flight Management System. Thank you for coming today. This website will help you organize your flying journey smoothly.</p>
        <hr>
        <form class="form-inline mx-auto" action="/cse470_website_start/home.php" method="GET">
          <div class="input-group mr-2">
            <div class="input-group-prepend">
              <span class="input-group-text">From:</span>
            </div>
            <input type="text" class="form-control" name="from_city" aria-label="From">
          </div>
          <div class="input-group mr-2">
            <div class="input-group-prepend">
              <span class="input-group-text">To:</span>
            </div>
            <input type="text" class="form-control" name="to_city" aria-label="To">
          </div>
          <div class="input-group mr-2">
            <div class="input-group-prepend">
              <span class="input-group-text">Date:</span>
            </div>
            <input type="date" class="form-control" name="departure_date" aria-label="Date" required>
          </div>
          <!-- Advanced Filter: Price Range -->
          <div class="input-group mr-2">
            <div class="input-group-prepend">
              <span class="input-group-text">Price Range:</span>
            </div>
            <input type="range" class="form-control-range" id="priceRange" name="priceRange" min="0" max="1000" step="10" value="0">
            <span id="priceRangeValue"></span>
          </div>
          <button type="submit" class="btn btn-outline-dark">Search</button>
        </form>

        <?php
        // Establish connection to the database
        $conn = mysqli_connect("localhost", "root", "", "test_website");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['departure_date'])) {
            // Retrieve search criteria
            $departure_date = $_GET['departure_date'];
            $from_city = isset($_GET['from_city']) ? $_GET['from_city'] : '';
            $to_city = isset($_GET['to_city']) ? $_GET['to_city'] : '';
            $priceRange = isset($_GET['priceRange']) ? $_GET['priceRange'] : '';

            // Construct SQL query
            $sql = "SELECT * FROM flights WHERE departure_date = '$departure_date'";
            
            // Add filters for from_city, to_city, and priceRange if they are provided
            if ($from_city !== '') {
                $sql .= " AND from_city LIKE '%$from_city%'";
            }
            if ($to_city !== '') {
                $sql .= " AND to_city LIKE '%$to_city%'";
            }
            if ($priceRange !== '') {
                $sql .= " AND price <= $priceRange";
            }

            // Execute query
            $result = mysqli_query($conn, $sql);

            // Check if any rows are returned
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                echo "<div class='mt-4'>";
                echo "<h3>Search Results:</h3>";
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Form to view flight details -->
                    <form action="flight_status.php" method="GET">
                        <input type="hidden" name="flight_id" value="<?php echo $row['id']; ?>">
                        <div class="flight-info">
                            <p>Flight ID: <?php echo $row["id"]; ?> - From: <?php echo $row["from_city"]; ?> To: <?php echo $row["to_city"]; ?></p>
                            <!-- Display more flight details here... -->
                            <button type="submit" class="btn btn-outline-dark">View Details</button>
                        </div>
                    </form>
                    <?php
                }
                echo "</div>";
            } else {
                echo "<p>No flights found for the selected date.</p>";
            }
        }

        // Close connection
        mysqli_close($conn);
        ?>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
      // JavaScript to update the displayed value of the price range slider
      var priceRange = document.getElementById("priceRange");
      var priceRangeValue = document.getElementById("priceRangeValue");
      priceRangeValue.innerHTML = priceRange.value;

      priceRange.oninput = function() {
        priceRangeValue.innerHTML = this.value;
      };
    </script>
  </body>
</html>
