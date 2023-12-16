<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trip Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    table {
      border-collapse: collapse;
      width: 80%;
      margin: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #4CAF50;
      color: #fff;
    }

    tr:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>

<?php
// Database connection details
$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "ppatms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve information about Auto and Taxi
$sql = "SELECT
            vehicle.name AS vehicle_type,
            COUNT(*) AS total_trips,
            SUM(customer.numofpass) AS total_passengers,
            SUM(customer.total_fare) AS total_fare_collected
        FROM
            customer
        JOIN vehicle ON customer.vehicle = vehicle.vehicleid
        WHERE
            vehicle.name IN ('Auto', 'Taxi')
        GROUP BY
            vehicle.name";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Vehicle Type</th><th>Total Trips</th><th>Total Passengers</th><th>Total Fare Collected</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["vehicle_type"]. "</td><td>" . $row["total_trips"]. "</td><td>" . $row["total_passengers"]. "</td><td>" . $row["total_fare_collected"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>

</body>
</html>
