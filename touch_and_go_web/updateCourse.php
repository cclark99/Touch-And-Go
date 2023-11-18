<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files and establish database connection
include("db_connection.php");

// Retrieve form data
$name = $_POST['name'];
$prefix = $_POST['prefix'];
$description = $_POST['description'];
$location = $_POST['location'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];

// Update the course table
if (
    $stmtCourse = $con->prepare("UPDATE course 
                               SET name = ?, 
                                   prefix= ?,
                                   description= ?, 
                                   location= ?, 
                                   startDate = ?,
                                   endDate = ?,
                                   startTime = ?,
                                   endTime = ?
                               WHERE courseId = ?")
) {
    $stmtCourse->bind_param(
        "ssssssssi",
        $name,
        $prefix,
        $description,
        $location,
        $startDate,
        $endDate,
        $startTime,
        $endTime,
        $courseId
    );
    $stmtCourse->execute();
    $_SESSION['updateMsg'] = 'Successfully updated course: ' . $courseId;
    header('Location: adminCourse.php');
    exit();
} else {
    // Failed to update the course table (e.g., course not found)
    // Redirect back to the search page with an error message
    $_SESSION['updateMsg'] = 'Unsuccessfully updated course';
    header('Location: adminHome.php');
    exit();
}
?>