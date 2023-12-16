<?php
// Opens a connection to the database
// Since it is a php file it won't open in a browser 
// It should be saved outside of the main web documents folder
// and imported when needed

/*
Command that gives the database user the least amount of power
as is needed.
GRANT INSERT, SELECT, DELETE, UPDATE ON test3.* 
TO 'studentweb'@'localhost' 
IDENTIFIED BY 'turtledove';
SELECT : Select rows in tables
INSERT : Insert new rows into tables
UPDATE : Change data in rows
DELETE : Delete existing rows (Remove privilege if not required)
*/

// Define database connection constants
/*
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'project');

// Create a connection to the database
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if the connection was successful
if (!$dbc) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

// Set character set to utf8 (assuming it's suitable for your application)
mysqli_set_charset($dbc, 'utf8');

// Optionally, you can enable error reporting for development
// Comment or remove the following line in a production environment
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
*/
?>

<?php
// Define connection parameters
$servername = 'localhost'; //
$username = 'root'; // 
$password = ''; // 
$dbname = 'ppatms'; 

// Create a connection to the database
$dbc = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$dbc) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

// Set character set to utf8 (assuming it's suitable for your application)
mysqli_set_charset($dbc, 'utf8');

// Optionally, you can enable error reporting for development
// Comment or remove the following line in a production environment
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
