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
    $addCourseId = $_POST['addCourseId'] ?? null;
    $removeCourseId = $_POST['removeCourseId'] ?? null;

    if ($addCourseId) {
        // Add the course to the professor's courses
        $addCourseQuery = "INSERT INTO professor_course (userId, courseId) VALUES (?, ?)";
        $addCourseStmt = $con->prepare($addCourseQuery);
        $addCourseStmt->bind_param('ii', $professorId, $addCourseId);
        $addCourseStmt->execute();
        $addCourseStmt->close();
    }

    if ($removeCourseId) {
        // Remove the course from the professor's courses
        $removeCourseQuery = "DELETE FROM professor_course WHERE userId = ? AND courseId = ?";
        $removeCourseStmt = $con->prepare($removeCourseQuery);
        $removeCourseStmt->bind_param('ii', $professorId, $removeCourseId);
        $removeCourseStmt->execute();
        $removeCourseStmt->close();
    }

    // Redirect back to the page with a success message
    $_SESSION['updateMsg'] = 'Professor courses updated successfully';
    header("Location: editProfessorCourse.php?professorId=$professorId");
    exit();
}

// Retrieve professorId from GET parameter
$professorId = $_GET['professorId'] ?? null;
$professorName = $_GET['professorName'] ?? null;

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

    <h3>Current Courses for
        <?php echo $professorName; ?>
    </h3>

    <?php if (empty($currentCourses)): ?>
        <p class="no-courses-message">This professor has no courses.</p>
    <?php else: ?>

        <form method="post" action="editProfessorCourse.php">
            <input type="hidden" name="professorId" value="<?= $professorId ?>">
            <input type="hidden" name="professorName" value="<?= $professorName ?>">

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
    <?php endif; ?>

    <h3>Add New Courses</h3>

    <form method="post" action="editProfessorCourse.php">
        <input type="hidden" name="professorId" value="<?= $professorId ?>">
        <input type="hidden" name="professorName" value="<?= $professorName ?>">

        <div>
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
        </div>
    </form>

</body>

</html>