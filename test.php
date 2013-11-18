<!DOCTYPE HTML>
<html>
<head>
</head>
<body> 


<?php

// CONNECT TO THE DATABASE
$DB_NAME = 'iapt';
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';

$mysqli = new mysqli ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );

if (mysqli_connect_errno ()) {
	printf ( "Connect failed: %s\n", mysqli_connect_error () );
	exit ();
}

// A QUICK QUERY ON A FAKE USER TABLE
$query = "SELECT * FROM `Stuff`";
$result = $mysqli->query ( $query ) or die ( $mysqli->error . __LINE__ );

// GOING THROUGH THE DATA
if ($result->num_rows > 0) {
	while ( $row = $result->fetch_assoc () ) {
		echo stripslashes ( $row ['Name'] );
	}
} else {
	echo 'NO RESULTS';
}

// CLOSE CONNECTION
mysqli_close ( $mysqli );

?>

</body>
</html>