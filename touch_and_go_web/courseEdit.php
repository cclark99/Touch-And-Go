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

// Check if the courseId is provided in the query string
if (isset($_GET['courseId'])) {
    $courseId = $_GET['courseId'];

    // Retrieve course information based on the courseId
    $stmt = $con->prepare('SELECT * FROM courses WHERE courseId = ?');
    $stmt->bind_param('s', $courseId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the course exists
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();

        // Display the course information in an editable form
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <title>Edit Course</title>
            <link rel="stylesheet" type="text/css" href="../styles.css">
        </head>

        <body>
            <h1>Edit Course</h1>
            <form method="post" action="updateCourse.php">
                <!-- Include input fields for editing course information -->
                <label for="courseName">Course Name:</label>
                <input type="text" name="courseName" value="<?= htmlspecialchars($course['name']) ?>" required>

                <label for="description">Description:</label>
                <input type="text" name="description" value="<?= htmlspecialchars($course['description']) ?>">

                <input type="hidden" name="courseId" value="<?= $courseId ?>">
                <input type="submit" value="Update Course">
            </form>
        </body>

        </html>
        <?php

        $stmt->close();
    } else {
        $_SESSION['updateMsg'] = 'Course not found.';
        header('Location: adminCourse.php');
        exit();
    }
} else {
    $_SESSION['updateMsg'] = 'CourseId not provided.';
    header('Location: adminCourse.php');
    exit();
}
?>