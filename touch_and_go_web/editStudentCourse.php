<?php
// editStudentCourse.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

require 'db_connection.php';

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have form fields named 'studentId', 'addCourseId', and 'removeCourseId'
    $studentId = $_POST['studentId'] ?? null;
    $addCourseId = $_POST['addCourseId'] ?? null;
    $removeCourseId = $_POST['removeCourseId'] ?? null;

    if ($addCourseId) {
        // Add the course to the student's courses
        $addCourseQuery = "INSERT INTO student_course (userId, courseId) VALUES (?, ?)";
        $addCourseStmt = $con->prepare($addCourseQuery);
        $addCourseStmt->bind_param('ii', $studentId, $addCourseId);
        $addCourseStmt->execute();
        $addCourseStmt->close();
    }

    if ($removeCourseId) {
        // Remove the course from the student's courses
        $removeCourseQuery = "DELETE FROM student_course WHERE userId = ? AND courseId = ?";
        $removeCourseStmt = $con->prepare($removeCourseQuery);
        $removeCourseStmt->bind_param('ii', $studentId, $removeCourseId);
        $removeCourseStmt->execute();
        $removeCourseStmt->close();
    }

    // Redirect back to the page with a success message
    $_SESSION['updateMsg'] = 'Student courses updated successfully';
    header("Location: editStudentCourse.php?studentId=$studentId");
    exit();
}

// Retrieve studentId from GET parameter
$studentId = $_GET['studentId'] ?? null;
$studentName = $_GET['studentName'] ?? null;

// If studentId is not provided or not a valid number, redirect back
if (!is_numeric($studentId)) {
    header('Location: adminCourse.php');
    exit();
}

// Fetch student's current courses
$currentCoursesQuery = "SELECT c.courseId, c.name, c.prefix FROM student_course sc JOIN course c ON sc.courseId = c.courseId WHERE sc.userId = ?";
$currentCoursesStmt = $con->prepare($currentCoursesQuery);
$currentCoursesStmt->bind_param('i', $studentId);
$currentCoursesStmt->execute();
$currentCoursesStmt->bind_result($courseId, $courseName, $coursePrefix);
$currentCourses = [];

while ($currentCoursesStmt->fetch()) {
    $currentCourses[] = ['courseId' => $courseId, 'courseName' => $courseName, 'coursePrefix' => $coursePrefix];
}

$currentCoursesStmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Courses</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <style>
        form {
            max-width: 600px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-top: 10px;
        }

        form select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form button {
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

        form button:hover {
            background: #397d13;
        }

        .update-message {
            margin-top: 15px;
            padding: 10px;
            font-size: 18px;
            text-align: center;
            background-color: #2a3c4e;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: auto;
            margin-bottom: 20px;
        }

        div {
            margin-bottom: 10px;
        }

        span {
            color: black;
            font-size: larger;
        }

        h3 {
            text-align: center;
            font-size: xx-large;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <ul>
        <li><a class="link" href="adminHome.php">Home</a></li>
        <li><a class="link" href="adminCourse.php">Courses</a></li>
        <li id="fakeNav"><a></a></li>
        <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
        <li id="fakeNav"><a></a></li>
        <li id="fakeNav"><a></a></li>
        <li><a class='link' href="logout.php">Logout</a></li>
    </ul>

    <h3 class="center">Current Courses for
        <?php echo $studentName; ?>
    </h3>

    <form method="post" action="editStudentCourse.php">
        <input type="hidden" name="studentId" value="<?= $studentId ?>">

        <?php
        foreach ($currentCourses as $course) {
            echo '<div>';
            echo "<span>{$course['prefix']}</span>";
            echo "<span>{$course['courseName']}</span>";
            echo "<button type='submit' name='removeCourseId' value='{$course['courseId']}'>Remove</button>";
            echo '</div>';
        }
        ?>
    </form>

    <h3 class="center">Add New Courses</h3>

    <form method="post" action="editStudentCourse.php">
        <input type="hidden" name="studentId" value="<?= $studentId ?>">

        <label for="addCourseId">Add Course:</label>
        <select name="addCourseId">
            <?php
            $availableCoursesQuery = "SELECT courseId, name FROM course";
            $availableCoursesResult = $con->query($availableCoursesQuery);

            while ($course = $availableCoursesResult->fetch_assoc()) {
                echo "<option value='{$course['courseId']}'>{$course['name']}</option>";
            }

            $availableCoursesResult->close();
            ?>
        </select>

        <button type="submit">Add Course</button>
    </form>

    <?php
    if (isset($_SESSION['updateMsg'])) {
        echo '<h2 class="update-message">' . $_SESSION['updateMsg'] . '</h2>';
        unset($_SESSION['updateMsg']);
    }
    ?>

</body>

</html>