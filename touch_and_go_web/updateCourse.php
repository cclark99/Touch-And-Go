<?php

session_start();

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

// Update the user table
if (
    $stmtUser = $con->prepare("UPDATE course 
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
    $_SESSION['updateMsg'] = 'Successfully updated Admin: ' . $userId;
    header('Location: adminHome.php?');

    // Failed to update the user table (e.g., user not found)
    // Redirect back to the search page with an error message
    $_SESSION['updateMsg'] = 'Unsuccessfully updated User';
    header('Location: adminHome.php');
    exit();
} else {
    // Failed to update the user table (e.g., user not found)
    // Redirect back to the search page with an error message
    $_SESSION['updateMsg'] = 'Unsuccessfully updated User';
    header('Location: adminHome.php');
    exit();
}
?>