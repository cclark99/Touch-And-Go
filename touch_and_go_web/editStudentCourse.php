<?php
// editStudentCourse.php

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
        // Fetch student's current courses
        $currentCoursesQuery = "SELECT courseId FROM student_course WHERE userId = ?";
        $currentCoursesStmt = $con->prepare($currentCoursesQuery);
        $currentCoursesStmt->bind_param('i', $studentId);
        $currentCoursesStmt->execute();
        $currentCoursesStmt->bind_result($courseId);
        $currentCourses = [];

        while ($currentCoursesStmt->fetch()) {
            $currentCourses[] = $courseId;
        }

        $currentCoursesStmt->close();

        // Check if the course is already in the student's courses
        if (in_array($addCourseId, $currentCourses)) {
            $_SESSION['updateMsg'] = 'The student is already taking this course.';
        } else {
            // Add the course to the student's courses
            $addCourseQuery = "INSERT INTO student_course (userId, courseId) VALUES (?, ?)";
            $addCourseStmt = $con->prepare($addCourseQuery);
            $addCourseStmt->bind_param('ii', $studentId, $addCourseId);
            $addCourseStmt->execute();
            $addCourseStmt->close();
        }
    }

    if ($removeCourseId) {
        // Remove the course from the student's courses
        $removeCourseQuery = "DELETE FROM student_course WHERE userId = ? AND courseId = ?";
        $removeCourseStmt = $con->prepare($removeCourseQuery);
        $removeCourseStmt->bind_param('ii', $studentId, $removeCourseId);
        $removeCourseStmt->execute();
        $removeCourseStmt->close();
    }

    // Store the student name in a session variable
    $_SESSION['studentName'] = $_POST['studentName'];

    // Redirect back to the page with a success message
    header("Location: editStudentCourse.php?studentId=$studentId");
    exit();
}

// Retrieve studentId from GET parameter
$studentId = $_GET['studentId'] ?? null;

// Check if the studentName is in the session, use it, and then unset it
if (isset($_SESSION['studentName'])) {
    $studentName = $_SESSION['studentName'];
    unset($_SESSION['studentName']);
} else {
    $studentName = $_GET['studentName'] ?? null;
}

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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px;
            font-size: 14px;
            background-color: transparent;
            /* No background color */
            border: none;
            cursor: pointer;
        }

        .no-courses-message {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #555;
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

    <?php if (empty($currentCourses)): ?>
        <p class="no-courses-message">This student has no courses.</p>
    <?php else: ?>

        <form method="post" action="editStudentCourse.php">
            <input type="hidden" name="studentId" value="<?= $studentId ?>">
            <input type="hidden" name="studentName" value="<?= $studentName ?>">

            <table>
                <tr>
                    <th>Prefix</th>
                    <th>Course Name</th>
                    <th>Edit</th>
                </tr>
                <?php
                foreach ($currentCourses as $course) {
                    echo '<tr>';
                    echo "<td>{$course['coursePrefix']}</td>";
                    echo "<td>{$course['courseName']}</td>";
                    echo "<td><button type='submit' class='removeButton' name='removeCourseId' value='{$course['courseId']}'>Remove</button></td>";
                    echo '</tr>';
                }
                ?>
            </table>
        </form>

        <h3 class="center">Add New Courses</h3>

        <form method="post" action="editStudentCourse.php">
            <input type="hidden" name="studentId" value="<?= $studentId ?>">
            <input type="hidden" name="studentName" value="<?= $studentName ?>">

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
            <?php
            if (isset($_SESSION['updateMsg'])) {
                echo '<h2 class="update-message">' . $_SESSION['updateMsg'] . '</h2>';
                unset($_SESSION['updateMsg']);
            }
            ?>
        </form>

    <?php endif; ?>

</body>

</html>