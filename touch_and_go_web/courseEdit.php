<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

require 'db_connection.php';

// Get user's name based on what account type they are, as well as userId

switch (true) {
    case $_SESSION['userType'] == 'student':
        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
            $stmt->bind_param('s', $_SESSION['email']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($_SESSION['userId']);
                $stmt->fetch();
            }
            $stmt->close();
        }

        if ($stmt = $con->prepare('SELECT firstName, lastName FROM student WHERE userId = ?')) {
            $stmt->bind_param('i', $_SESSION['userId']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
                $stmt->fetch();
            }
            $stmt->close();
        }
        break;

    case $_SESSION['userType'] == 'professor':
        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
            $stmt->bind_param('s', $_SESSION['email']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($_SESSION['userId']);
                $stmt->fetch();
            }
            $stmt->close();
        }

        if ($stmt = $con->prepare('SELECT firstName, lastName FROM professor WHERE userId = ?')) {
            $stmt->bind_param('i', $_SESSION['userId']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
                $stmt->fetch();
            }
            $stmt->close();
        }

        break;

    case $_SESSION['userType'] == 'admin':
        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
            $stmt->bind_param('s', $_SESSION['email']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($_SESSION['userId']);
                $stmt->fetch();
            }
            $stmt->close();
        }

        if ($stmt = $con->prepare('SELECT firstName, lastName FROM admin WHERE userId = ?')) {
            $stmt->bind_param('i', $_SESSION['userId']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
                $stmt->fetch();
            }
            $stmt->close();
        }

        break;
    default:
        include 'logout.php';
        break;
}

?>
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
    <!-- set charset -->
    <meta charset="utf-8">
    <!-- set title -->
    <title>Home</title>
    <!-- link external style.css sheet -->
    <link rel="stylesheet" type="text/css" href="../styles.css">

    <!-- start of style tag -->
    <style>
        /* start of style rules for h3 tag */
        h3 {
            color: #10222E;
            /* make color blue */
            font-size: 24pt;
            /* make font size 24 pt */
            text-align: center;
            /* center align text */
            margin-top: 5%;
            /* make margin-top 5% */
        }

        form.create_course {
            max-width: 800px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        form.create_course label {
            display: block;
            margin-top: 10px;
        }

        form.create_course fieldset {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }

        form.create_course legend {
            font-weight: bold;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form.create_course input[type="text"] {
            width 50%:
        }

        form.create_course input[type="checkbox"] {
            width: auto;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form.create_course input[type="submit"],
        form.create_course input[type="reset"] {
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

        form.create_course input[type="submit"] {
            background: #4CAF50;
        }

        form.create_course input[type="submit"]:hover {
            background: #2a3c4e;
        }

        form.create_course input[type="reset"] {
            background: #FF6347;
        }

        form.create_course input[type="reset"]:hover {
            background: #8b0000;
        }
    </style> <!-- end of style tag -->

<body> <!-- start of body tag -->

    <!-- The following code was created on October 30, 2023, using 
    information from the following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

    <ul> <!-- start of ul for menu bar -->
        <!-- list home.php link -->
        <li><a class="link" href="adminHome.php">Home</a></li>
        <!-- list schedule.php link -->
        <li><a class="link" href="courseEdit.php">Courses</a></li>
        <!-- list analytics.php link -->
        <li id="fakeNav"><a></a></li>
        <!-- list Touch & Go logo -->
        <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
        <!-- list contact.php link -->
        <li id="fakeNav"><a></a></li>
        <!-- list help.php link -->
        <li id="fakeNav"><a></a></li>
        <!-- list logout.php link -->
        <li><a class='link' href="logout.php">Logout</a></li>
    </ul> <!-- end of ul for menu bar -->

    <!-- this ends the code that was created using information from the 
    following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

    <!-- home header -->
    <h1>Courses</h1>

    <h3 class="center">Create Course</h3>
    <form class="create_course" method="post" action="process_course.php">
        <label for="courseName">Course Name:</label>
        <input type="text" name="courseName" required>

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
        <input type="text" name="startTime" placeholder="HH:MM AM/PM" required>

        <label for="endTime">End Time:</label>
        <input type="text" name="endTime" placeholder="HH:MM AM/PM" required>

        <input type="submit" value="Create Course">
        <input type="reset" value="Clear">
    </form>

    <h3 class="center">Edit Courses</h3>
    <div class="searchBox">
        <form id="search" onsubmit="">
            <input type="text" name="search" placeholder="Search..." required>

            <!-- Add a dropdown menu to select user type -->
            <select name="userType">
                <option value="">All Users</option>
                <option value="admin">Admins</option>
                <option value="professor">Professors</option>
                <option value="student">Students</option>
            </select>

            <input type="submit" value="Search">
        </form>

        <div id="results"></div>
        <?php
        echo "<p style='color: green;'>$successMessage</p>";
        echo "<p style='color: red;'>$errorMessage</p>";
        ?>
    </div>

    <h3 class="center">Edit students in course</h3>
    <div class="searchBox">
        <form id="search" onsubmit="">
            <input type="text" name="search" placeholder="Search..." required>

            <!-- Add a dropdown menu to select user type -->
            <select name="userType">
                <option value="">All Users</option>
                <option value="admin">Admins</option>
                <option value="professor">Professors</option>
                <option value="student">Students</option>
            </select>

            <input type="submit" value="Search">
        </form>

        <div id="results"></div>
        <?php
        echo "<p style='color: green;'>$successMessage</p>";
        echo "<p style='color: red;'>$errorMessage</p>";
        ?>
    </div>

    <h3 class="center">Edit Professor in course</h3>
    <div class="searchBox">
        <form id="search" onsubmit="">
            <input type="text" name="search" placeholder="Search..." required>

            <!-- Add a dropdown menu to select user type -->
            <select name="userType">
                <option value="">All Users</option>
                <option value="admin">Admins</option>
                <option value="professor">Professors</option>
                <option value="student">Students</option>
            </select>

            <input type="submit" value="Search">
        </form>

        <div id="results"></div>
        <?php
        echo "<p style='color: green;'>$successMessage</p>";
        echo "<p style='color: red;'>$errorMessage</p>";
        ?>
    </div>

    <script>
        function asearch() {
            // (A) GET SEARCH TERM
            var data = new FormData(document.getElementById("search"));
            data.append("ajax", 1);

            // (B) AJAX SEARCH REQUEST
            fetch("search.php", { method: "POST", body: data })
                .then(res => res.json())
                .then(res => {
                    console.log("JSON Response:", JSON.stringify(res, null, 2)); // Add this line for debugging
                    var wrapper = document.getElementById("results");
                    if (res.length > 0) {
                        wrapper.innerHTML = "<table><tr><th>User Type</th><th>First Name</th><th>Last Name</th><th>Email</th><th> </th></tr>";
                        for (let r of res) {
                            // Check if the user is a student, professor, or admin
                            let userType = r["userType"] ? r["userType"] : "";
                            let firstName = "";
                            let lastName = "";

                            // Set the first name and last name based on the user type
                            if (userType === "student") {
                                firstName = r["studentFirstName"] ? r["studentFirstName"] : "";
                                lastName = r["studentLastName"] ? r["studentLastName"] : "";
                            } else if (userType === "professor") {
                                firstName = r["professorFirstName"] ? r["professorFirstName"] : "";
                                lastName = r["professorLastName"] ? r["professorLastName"] : "";
                            } else if (userType === "admin") {
                                firstName = r["adminFirstName"] ? r["adminFirstName"] : "";
                                lastName = r["adminLastName"] ? r["adminLastName"] : "";
                            }

                            let userEmail = r["userEmail"] ? r["userEmail"] : "";

                            // Create a new table row for each user
                            let line = document.createElement("tr");
                            line.innerHTML = `<td>${userType}</td><td>${firstName}</td><td>${lastName}</td><td>${userEmail}</td><td><button onclick="editUser('${userType}', '${userEmail}')">Edit</button></td>`;

                            // Append the new table row to the table
                            wrapper.querySelector("table").appendChild(line);
                        }
                        // Move the closing </table> outside of the loop
                        wrapper.innerHTML += "</table>";
                    } else {
                        wrapper.innerHTML = "No results found";
                    }
                })
                .catch(error => console.error("Error:", error)); // Add this line for error handling
            return false;
        }

        function editUser(userType, userEmail) {
            // Redirect to the edit.php page with user type and email as parameters
            window.location.href = `edit.php?userType=${userType}&userEmail=${userEmail}`;
        }
    </script>
</body>

</html>