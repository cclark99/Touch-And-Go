<?php
// editProfessorCourse.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

require 'db_connection.php';

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have form fields named 'professorId', 'addCourseId', and 'removeCourseId'
    $professorId = $_POST['professorId'] ?? null;

    if ($addCourseId) {
        // Add the course to the professor's courses
        $addCourseQuery = "INSERT INTO professor_course (professorId, courseId) VALUES (?, ?)";
        $addCourseStmt = $con->prepare($addCourseQuery);
        $addCourseStmt->bind_param('ii', $professorId, $addCourseId);
        $addCourseStmt->execute();
        $addCourseStmt->close();
    }

    if ($removeCourseId) {
        // Remove the course from the professor's courses
        $removeCourseQuery = "DELETE FROM professor_course WHERE professorId = ? AND courseId = ?";
        $removeCourseStmt = $con->prepare($removeCourseQuery);
        $removeCourseStmt->bind_param('ii', $professorId, $removeCourseId);
        $removeCourseStmt->execute();
        $removeCourseStmt->close();
    }

    // Redirect back to the page with a success message
    $_SESSION['updateMsg'] = 'Professor courses updated successfully';
    header('Location: adminHome.php');
    exit();
}

// Retrieve professorId from GET parameter
$professorId = $_GET['professorId'] ?? null;
$professorName = $_POST['professorName'] ?? null;

// If professorId is not provided or not a valid number, redirect back
if (!is_numeric($professorId)) {
    header('Location: adminCourse.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Professor Courses</title>
    <!-- link external style.css sheet -->
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>

    <!-- Display current courses with delete buttons -->
    <h2>Current Courses for </h2>
    <form method="post" action="editProfessorCourse.php">
        <input type="hidden" name="professorId" value="<?= $professorId ?>">

        <?php
        $currentCoursesQuery = "SELECT c.courseId, c.name FROM professor_course pc JOIN course c ON pc.courseId = c.courseId WHERE pc.userId = ?";
        $currentCoursesStmt = $con->prepare($currentCoursesQuery);
        $currentCoursesStmt->bind_param('i', $professorId);
        $currentCoursesStmt->execute();
        $currentCoursesStmt->bind_result($courseId, $courseName);

        while ($currentCoursesStmt->fetch()) {
            echo '<div>';
            echo "<span>$courseName</span>";
            echo "<input type='hidden' name='currentCourseIds[]' value='$courseId'>";
            echo "<button type='submit' name='removeCourseId' value='$courseId'>Remove</button>";
            echo '</div>';
        }

        $currentCoursesStmt->close();
        ?>
    </form>

    <!-- Add new courses form -->
    <h2>Add New Courses</h2>
    <form method="post" action="editProfessorCourse.php">
        <input type="hidden" name="professorId" value="<?= $professorId ?>">

        <label for="addCourseId">Add Course:</label>
        <!-- Assuming you have a table named 'course' with courseId and name columns -->
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

</body>

</html>