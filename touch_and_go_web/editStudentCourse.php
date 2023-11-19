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
$currentCoursesQuery = "SELECT c.courseId, c.name FROM student_course sc JOIN course c ON sc.courseId = c.courseId WHERE sc.userId = ?";
$currentCoursesStmt = $con->prepare($currentCoursesQuery);
$currentCoursesStmt->bind_param('i', $studentId);
$currentCoursesStmt->execute();
$currentCoursesStmt->bind_result($courseId, $courseName);
$currentCourses = [];

while ($currentCoursesStmt->fetch()) {
    $currentCourses[] = ['courseId' => $courseId, 'courseName' => $courseName];
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

    <h2>Current Courses for
        <?php echo $studentName; ?>
    </h2>

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

    <h2>Add New Courses</h2>

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