<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

require 'db_connection.php';

// Check if the courseId is provided in the query string
if (isset($_GET['courseId'])) {
    $courseId = $_GET['courseId'];

    // Retrieve course information based on the courseId
    $stmt = $con->prepare('SELECT * FROM course WHERE courseId = ?');
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
            <style>
                .update_course {
                    max-width: 800px;
                    margin: auto;
                    background-color: #FFFFFF;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    margin-top: 20px;
                }

                .update_course label {
                    display: block;
                    margin-top: 10px;
                }

                .update_course input[type="text"],
                .update_course input[type="checkbox"],
                .update_course input[type="time"],
                .update_course input[type="date"] {
                    width: auto;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin-top: 5px;
                    box-sizing: border-box;
                }

                .update_course input[type="text"],
                .update_course input[type="time"],
                .update_course input[type="date"] {
                    width: 50%;
                }

                .update_course input[type="submit"],
                .update_course input[type="reset"] {
                    width: 100%;
                    padding: 15px 0;
                    font-size: 18px;
                    border: 0;
                    color: #fff;
                    cursor: pointer;
                    border-radius: 5px;
                    transition: background 0.3s ease-in-out;
                    margin-top: 20px;
                }

                .update_course input[type="checkbox"] {
                    width: auto;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin-top: 5px;
                    box-sizing: border-box;
                }

                .update_course legend {
                    font-weight: bold;

                }

                .update_course fieldset {
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    padding: 10px;
                    margin-top: 10px;
                }

                .update_course input[type="submit"] {
                    background: #4CAF50;
                }

                .update_course input[type="submit"]:hover {
                    background: #397d13;
                }

                .update_course input[type="reset"] {
                    background: #FF6347;
                }

                .update_course input[type="reset"]:hover {
                    background: #8b0000;
                }
            </style>
        </head>

        <body>
            <h1>Edit Course</h1>
            <div class="update_course">
                <form method="post" action="updateCourse.php">
                    <!-- Include input fields for editing course information -->
                    <label for="courseName">Course Prefix:</label>
                    <input type="text" name="prefix" value="<?= htmlspecialchars($course['prefix']) ?>" required>

                    <label for="courseName">Course Name:</label>
                    <input type="text" name="courseName" value="<?= htmlspecialchars($course['name']) ?>" required>

                    <label for="description">Description:</label>
                    <input type="text" name="description" value="<?= htmlspecialchars($course['description']) ?>">

                    <label for="location">Location:</label>
                    <input type="text" name="location" value="<?= htmlspecialchars($course['location']) ?>" required>

                    <label for="startDate">Start Date</label>
                    <input type="date" name="startDate" value="<?= htmlspecialchars($course['startDate']) ?>" required>

                    <label for="endDate">End Date</label>
                    <input type="date" name="endDate" value="<?= htmlspecialchars($course['endDate']) ?>" required>

                    <fieldset>
                        <legend>Days of the Week:</legend>
                        <input type="checkbox" name="daysOfWeek[]" value="Monday"> Monday
                        <input type="checkbox" name="daysOfWeek[]" value="Tuesday"> Tuesday
                        <input type="checkbox" name="daysOfWeek[]" value="Wednesday"> Wednesday
                        <input type="checkbox" name="daysOfWeek[]" value="Thursday"> Thursday
                        <input type="checkbox" name="daysOfWeek[]" value="Friday"> Friday
                        <input type="checkbox" name="daysOfWeek[]" value="Saturday"> Saturday
                        <input type="checkbox" name="daysOfWeek[]" value="Sunday"> Sunday
                    </fieldset>

                    <label for="startTime">Start Time:</label>
                    <input type="time" name="startTime" value="<?= htmlspecialchars($course['startTime']) ?>" required>

                    <label for="endTime">End Time:</label>
                    <input type="text" name="endTime" value="<?= htmlspecialchars($course['endTime']) ?>" required>

                    <input type="hidden" name="courseId" value="<?= $courseId ?>">
                    <input type="submit" value="Update Course">
                </form>
            </div>
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