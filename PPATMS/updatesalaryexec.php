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
$salary = trim($_POST['salary']);
$sql = "update driver set salary = '$salary' where driverid = '$driver'";     
$retval = mysqli_query($dbc, $sql); 
if(! $retval ) {
  die('Could not update data: ' . mysql_error());
}
echo "Updated data successfully\n";    
header("Location: mainpage.php"); 
*/
?>

</body>
</html> -->

<html>
<head>
    <title>Update Driver Salary</title>
</head>
<body>

<?php
session_start();

require_once('mysqli_connect.php');

// Sanitize user input
$driver = mysqli_real_escape_string($dbc, trim($_POST['driverid']));
$salary = mysqli_real_escape_string($dbc, trim($_POST['salary']));

// Use prepared statement to prevent SQL injection
$sql = "UPDATE driver SET salary = ? WHERE driverid = ?";
$stmt = mysqli_prepare($dbc, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ss', $salary, $driver);
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
