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
$courseName = $_POST['courseName'] ?? '';

// Prepare and execute the SQL query to search for a course
if ($stmt = $con->prepare('SELECT * FROM course WHERE name = ?')) {
    $stmt->bind_param('s', $courseName);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Check if a course was found
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();

        // Redirect to the course editing page with course ID as a parameter
        header("Location: edit_course.php?courseId={$course['id']}");
        exit();
    } else {
        // No course found
        $_SESSION['reg_msg'] = 'No course found with the specified name';
        header('Location: edit_courses.php');
        exit();
    }
}

// Close the database connection
$con->close();
?>