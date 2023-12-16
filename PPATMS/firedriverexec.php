<!-- <html>
<head>
<title>Add Customer</title>
</head>
<body>

<?php
/*
session_start();

require_once('C:\Apache24\htdocs\mysqli_connect.php');
$driver = trim($_POST['driverid']);
$sql = "delete from driver where driverid = '".$_POST['driverid']."'";     
$retval = mysqli_query($dbc, $sql); 
if(! $retval ) {
  die('Could not delete data: ' . mysql_error());
}
echo "Deleted data successfully\n";    
header("Location: mainpage.php"); 
 */  
?>

</body>
</html> -->

<html>
<head>
    <title>Delete Driver</title>
</head>
<body>

<?php
session_start();
require_once('mysqli_connect.php');

// Sanitize user input
$driver = mysqli_real_escape_string($dbc, trim($_POST['driverid']));

// Use prepared statement to prevent SQL injection
$sql = "DELETE FROM driver WHERE driverid = ?";
$stmt = mysqli_prepare($dbc, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $driver);
    $success = mysqli_stmt_execute($stmt);

    if (!$success) {
        die('Could not delete data: ' . mysqli_error($dbc));
    }

    echo "Deleted data successfully\n";
    header("Location: mainpage.php");
} else {
    die('Could not prepare statement: ' . mysqli_error($dbc));
}

?>

</body>
</html>
