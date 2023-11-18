<?php

session_start();

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
$daysOfWeek = isset($_POST['daysOfWeek']) ? implode(', ', $_POST['daysOfWeek']) : '';
$startTime = $_POST['startTime'] ?? '';
$endTime = $_POST['endTime'] ?? '';

// Prepare and execute the SQL query to insert course data into the database
if ($stmt = $con->prepare('INSERT INTO courses (prefix, name, description, location, startDate, endDate, daysOfWeek, startTime, endTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
    $stmt->bind_param('sssssssss', $prefix, $name, $description, $location, $startDate, $endDate, $daysOfWeek, $startTime, $endTime);

    if ($stmt->execute()) {
        // Course created successfully
        header('Location: adminHome.php?success=Course created successfully');
        exit();
    } else {
        // Error inserting course data
        header('Location: adminHome.php?error=Error creating course');
        exit();
    }

    $stmt->close();
}

// Close the database connection
$con->close();
?>