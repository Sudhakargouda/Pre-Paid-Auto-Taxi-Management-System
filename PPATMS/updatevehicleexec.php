<html>
<head>
    <title>Add Customer</title>
</head>
<body>

<?php
session_start();
require_once('mysqli_connect.php');

$vehicle = trim($_POST['vehicle']);
$cust = $_SESSION['cust'];

// Update the 'vehicle' column in the 'customer' table
$sql = "UPDATE customer SET vehicle = '$vehicle' WHERE custid = '$cust'";
$retval = mysqli_query($dbc, $sql);

if (!$retval) {
    die('Could not update vehicle data: ' . mysqli_error($dbc));
}

$user = $_SESSION['username'];

// Retrieve the 'location' for the logged-in user from the 'employee' table
$sql = "SELECT location FROM employee WHERE username = '$user'";
$res = mysqli_query($dbc, $sql);

if (!$res) {
    die('Error retrieving user location: ' . mysqli_error($dbc));
}

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_array($res);
    $location = $row['location'];

    // Update the 'location' column in the 'customer' table
    $updateLocationQuery = "UPDATE customer SET location = '$location' WHERE custid = '$cust'";
    $updateLocationResult = mysqli_query($dbc, $updateLocationQuery);

    if (!$updateLocationResult) {
        die('Could not update location data: ' . mysqli_error($dbc));
    }

    echo "Updated data successfully\n";
    header("Location: mainpage.php");
} else {
    echo "Error: Could not retrieve user location.";
}

?>

</body>
</html>
