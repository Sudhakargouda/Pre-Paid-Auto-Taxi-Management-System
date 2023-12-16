<html>
<head>
    <title>Add Customer</title>
</head>
<body>

<?php
session_start();
$fname = trim($_POST['fname']);
$lname = trim($_POST['lname']);
$phone = trim($_POST['phone']);
$num = trim($_POST['numofpass']);
$source = trim($_POST['source']);
$destination = trim($_POST['destination']);
$feature = trim($_POST['feature']);
$cust = 0;

$_SESSION['feature'] = $feature;
$_SESSION['num'] = $num;
$_SESSION['destination'] = $destination;

$data_missing = array();

if (empty($data_missing)) {
    
    require_once('mysqli_connect.php');

    $query = "INSERT INTO customer (fname, lname, source, destination, phone, numofpass)
              VALUES (?, ?, ?, ?, ?, ?)";
        
    $stmt = mysqli_prepare($dbc, $query);
    
    mysqli_stmt_bind_param($stmt, "ssssii", $fname, $lname, $source, $destination, $phone, $num);

    mysqli_stmt_execute($stmt);
    
    $affected_rows = mysqli_stmt_affected_rows($stmt);
    
    $sql = "SELECT custid FROM customer WHERE fname = '$fname' AND lname = '$lname'";
    $res = mysqli_query($dbc, $sql);
    
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $_SESSION['cust'] = $row['custid'];
    }
    
    if ($affected_rows == 1) {
        header("Location: choosevehicle.php");
    } else {
        echo 'Error Occurred<br />';
    }
    
} else {
    echo 'You need to enter the following data<br />';
    foreach ($data_missing as $missing) {
        echo "$missing<br />";
    }
}
    
?>

</body>
</html>
