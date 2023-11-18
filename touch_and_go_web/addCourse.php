<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

require 'db_connection.php';

// Validate and sanitize form data
$prefix = $_POST['prefix'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$location = $_POST['location'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$daysOfWeek = isset($_POST['daysOfWeek']) ? implode('', $_POST['daysOfWeek']) : '';
$startTime = $_POST['startTime'] ?? '';
$endTime = $_POST['endTime'] ?? '';

// Prepare and execute the SQL query to insert course data into the database
if ($stmt = $con->prepare('INSERT INTO course (prefix, name, description, location, startDate, endDate, daysOfWeek, startTime, endTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
    $stmt->bind_param('sssssssss', $prefix, $name, $description, $location, $startDate, $endDate, $daysOfWeek, $startTime, $endTime);

    if ($stmt->execute()) {
        // Course created successfully
        $stmt->close(); // Close the statement before sending headers
        $_SESSION['updateMsg'] = 'Course created successfully!';
        header('Location: adminCourse.php');
        exit();
    } else {
        // Error inserting course data
        $stmt->close(); // Close the statement before sending headers
        $_SESSION['updateMsg'] = 'Error creating course. Please try again.';
    }
} else {
    // Error in preparing the SQL query
    $_SESSION['updateMsg'] = 'Error preparing SQL query. Please try again.';
}

// Close the database connection
$con->close();
header('Location: adminCourse.php');
exit();
?>