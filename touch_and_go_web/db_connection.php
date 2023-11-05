<?php
session_start();

// Enable error reporting for mysqli before attempt to make connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'test';
$DATABASE_PASS = 'test123';
$DATABASE_NAME = 'touch_and_go_test';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Error Checking
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

?>