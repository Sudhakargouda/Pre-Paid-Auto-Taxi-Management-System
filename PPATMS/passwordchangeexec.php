<!DOCTYPE html>
<html>
<head>
    <title>Password Change</title>
</head>
<body>

<?php

session_start();

require_once('mysqli_connect.php');

// Validate and sanitize user input
$pass1 = trim($_POST['newpass']);
$pass2 = trim($_POST['newpass1']);
$old = trim($_POST['oldpass']);
$user = $_SESSION['username'];

// Check if new passwords match
if ($pass1 !== $pass2) {
    header("Location: passwordchange.php?error=New passwords do not match");
    exit();
}

// Use prepared statements to prevent SQL injection
$sql = "SELECT password FROM employee WHERE username = ?";
$stmt = mysqli_prepare($dbc, $sql);
mysqli_stmt_bind_param($stmt, 's', $user);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);

    // Check if old password is correct
    if (password_verify($old, $hashedPassword)) {
        // Passwords match, update the password
        $hashedNewPassword = password_hash($pass1, PASSWORD_DEFAULT);
        $updateSql = "UPDATE employee SET password = ? WHERE username = ?";
        $updateStmt = mysqli_prepare($dbc, $updateSql);
        mysqli_stmt_bind_param($updateStmt, 'ss', $hashedNewPassword, $user);
        mysqli_stmt_execute($updateStmt);

        if (!$updateStmt) {
            die('Could not update data: ' . mysqli_error($dbc));
        }

        echo "Password updated successfully\n";
        header("Location: mainpage.php");
        exit();
    } else {
        header("Location: passwordchange.php?error=Incorrect old password");
        exit();
    }
} else {
    header("Location: passwordchange.php?error=Username not found");
    exit();
}

?>

</body>
</html>
