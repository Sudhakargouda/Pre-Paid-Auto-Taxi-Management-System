
<html>
<head>
    <title>Update Fare</title>
</head>
<body>

<?php
require_once('mysqli_connect.php');

// Sanitize user input
$route = mysqli_real_escape_string($dbc, trim($_POST['routeid']));
$fare = mysqli_real_escape_string($dbc, trim($_POST['fare']));

// Use prepared statement to prevent SQL injection
$sql = "UPDATE chart SET fare = ? WHERE routeid = ?";
$stmt = mysqli_prepare($dbc, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ss', $fare, $route);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo "Updated data successfully\n";
        header("Location: mainpage.php");
        exit();
    } else {
        die('Could not update data: ' . mysqli_error($dbc));
    }
} else {
    die('Could not prepare statement: ' . mysqli_error($dbc));
}

?>

</body>
</html>
