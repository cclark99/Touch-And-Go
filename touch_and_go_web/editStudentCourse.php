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
                echo "<td><button type='submit' name='removeCourseId' value='{$course['courseId']}'>Edit</button></td>";
                echo '</tr>';
            }
            ?>
        </table>
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