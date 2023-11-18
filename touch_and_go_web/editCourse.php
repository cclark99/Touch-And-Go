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

// Get the course ID from the URL parameter
$courseId = $_GET['courseId'] ?? '';

// Validate and sanitize the course ID
$courseId = filter_var($courseId, FILTER_VALIDATE_INT);

// Check if a valid course ID is provided
if (!$courseId) {
    $_SESSION['reg_msg'] = 'Invalid course ID';
    header('Location: editCourse.php');
    exit();
}

// Prepare and execute the SQL query to retrieve course details
if ($stmt = $con->prepare('SELECT * FROM course WHERE id = ?')) {
    $stmt->bind_param('i', $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Check if a course was found
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();

        // Display the course details in an edit form
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <title>Edit Course</title>
            <link rel="stylesheet" type="text/css" href="../styles.css">
            <style>
                h3 {
                    color: #10222E;
                    font-size: 24pt;
                    text-align: center;
                    margin-top: 5%;
                }

                form.edit_course {
                    max-width: 600px;
                    margin: auto;
                    background-color: #FFFFFF;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    margin-top: 20px;
                }

                form.edit_course label {
                    display: block;
                    margin-top: 10px;
                }

                form.edit_course input[type="text"] {
                    width: 50%;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin-top: 5px;
                    box-sizing: border-box;
                }

                form.edit_course input[type="submit"] {
                    width: 100%;
                    padding: 15px 0;
                    font-size: 18px;
                    border: 0;
                    color: #fff;
                    cursor: pointer;
                    border-radius: 5px;
                    background: #4CAF50;
                    transition: background 0.3s ease-in-out;
                    margin-top: 20px;
                }

                form.edit_course input[type="submit"]:hover {
                    background: #397d13;
                }
            </style>
        </head>

        <body>
            <ul>
                <li><a class="link" href="adminHome.php">Home</a></li>
                <li><a class="link" href="#">Courses</a></li>
                <li id="fakeNav"><a></a></li>
                <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
                <li id="fakeNav"><a></a></li>
                <li id="fakeNav"><a></a></li>
                <li><a class='link' href="logout.php">Logout</a></li>
            </ul>

            <h1>Edit Course</h1>

            <h3 class="center">Edit Course Details</h3>
            <form class="edit_course" method="post" action="process_edit_course.php">
                <input type="hidden" name="courseId" value="<?php echo $course['id']; ?>">

                <label for="prefix">Course Prefix:</label>
                <input type="text" maxlength="6" name="prefix" value="<?php echo $course['prefix']; ?>" required>

                <label for="name">Course Name:</label>
                <input type="text" name="name" value="<?php echo $course['name']; ?>" required>

                <label for="description">Description:</label>
                <input type="text" name="description" value="<?php echo $course['description']; ?>">

                <label for="location">Location:</label>
                <input type="text" maxlength="5" name="location" value="<?php echo $course['location']; ?>" required>

                <label for="startDate">Start Date:</label>
                <input type="date" name="startDate" value="<?php echo $course['startDate']; ?>">

                <label for="endDate">End Date:</label>
                <input type="date" name="endDate" value="<?php echo $course['endDate']; ?>">

                <fieldset>
                    <legend>Days of the Week:</legend>
                    <input type="checkbox" name="daysOfWeek[]" value="Monday" <?php echo strpos($course['daysOfWeek'], 'Monday') !== false ? 'checked' : ''; ?>> Monday
                    <input type="checkbox" name="daysOfWeek[]" value="Tuesday" <?php echo strpos($course['daysOfWeek'], 'Tuesday') !== false ? 'checked' : ''; ?>> Tuesday
                    <input type="checkbox" name="daysOfWeek[]" value="Wednesday" <?php echo strpos($course['daysOfWeek'], 'Wednesday') !== false ? 'checked' : ''; ?>> Wednesday
                    <input type="checkbox" name="daysOfWeek[]" value="Thursday" <?php echo strpos($course['daysOfWeek'], 'Thursday') !== false ? 'checked' : ''; ?>> Thursday
                    <input type="checkbox" name="daysOfWeek[]" value="Friday" <?php echo strpos($course['daysOfWeek'], 'Friday') !== false ? 'checked' : ''; ?>> Friday
                    <input type="checkbox" name="daysOfWeek[]" value="Saturday" <?php echo strpos($course['daysOfWeek'], 'Saturday') !== false ? 'checked' : ''; ?>> Saturday
                    <input type="checkbox" name="daysOfWeek[]" value="Sunday" <?php echo strpos($course['daysOfWeek'], 'Sunday') !== false ? 'checked' : ''; ?>> Sunday
                </fieldset>

                <label for="startTime">Start Time:</label>
                <input type="time" name="startTime" value="<?php echo $course['startTime']; ?>" required>

                <label for="endTime">End Time:</label>
                <input type="time" name="endTime" value="<?php echo $course['endTime']; ?>" required>

                <input type="submit" value="Save Changes">
            </form>
        </body>

        </html>
        <?php
    } else {
        // No course found with the specified ID
        $_SESSION['reg_msg'] = 'No course found with the specified ID';
        header('Location: editCourse.php');
        exit();
    }
}

// Close the database connection
$con->close();
?>