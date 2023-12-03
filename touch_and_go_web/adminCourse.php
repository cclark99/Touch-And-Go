<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

require 'db_connection.php';

?>
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
    <!-- set charset -->
    <meta charset="utf-8">
    <!-- set title -->
    <title>Courses</title>
    <!-- link external style.css sheet -->
    <link rel="stylesheet" type="text/css" href="../styles.css">

    <script>
        function confirmLogout() {
            // Show a confirmation dialog
            var result = confirm("Are you sure you want to logout?");

            // If the user clicks "OK," proceed with the logout
            if (result) {
                window.location.href = "logout.php";
            }
            // If the user clicks "Cancel," do nothing
        }
    </script>

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
        }

        form.create_course input[type="text"],
        form.create_course input[type="checkbox"],
        form.create_course input[type="time"],
        form.create_course input[type="date"] {
            width: auto;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form.create_course input[type="text"],
        form.create_course input[type="time"],
        form.create_course input[type="date"] {
            width: 50%;
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
            background: #397d13;
        }

        form.create_course input[type="reset"] {
            background: #FF6347;
        }

        form.create_course input[type="reset"]:hover {
            background: #8b0000;
        }

        form.search_course {
            max-width: 600px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        form.search_course label {
            display: block;
            margin-top: 10px;
        }

        form.search_course input[type="text"] {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form.search_course input[type="submit"] {
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

        form.search_course input[type="submit"]:hover {
            background: #397d13;
        }

        div.search_course {
            max-width: 800px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        div.search_course label {
            display: block;
            margin-top: 10px;
        }

        div.search_course input[type="text"] {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        div.search_course input[type="submit"] {
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

        div.search_course input[type="submit"]:hover {
            background: #397d13;
        }

        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .course-table th,
        .course-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .course-table th {
            background-color: #f2f2f2;
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
        <li><a class="link" href="adminCourse.php">Courses</a></li>
        <!-- list analytics.php link -->
        <li id="fakeNav"><a></a></li>
        <!-- list Touch & Go logo -->
        <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
        <!-- list contact.php link -->
        <li id="fakeNav"><a></a></li>
        <!-- list help.php link -->
        <li id="fakeNav"><a></a></li>
        <!-- list logout.php link -->
        <li><a class='link' href="#" onclick="confirmLogout()">Logout</a></li>
    </ul> <!-- end of ul for menu bar -->

    <!-- this ends the code that was created using information from the 
    following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

    <!-- home header -->
    <h1>Courses</h1>

    <h3 class="center">Create Course</h3>
    <form class="create_course" method="post" action="addCourse.php">
        <label for="prefix">Course Prefix:</label>
        <input type="text" maxlength="6" name="prefix" required>

        <label for="name">Course Name:</label>
        <input type="text" name="name" required>

        <label for="description">Description</label>
        <input type="text" name="description">

        <label for="location">Location:</label>
        <input type="text" maxlength="5" name="location" required>

        <label for="startDate">Start Date</label>
        <input type="date" name="startDate" value="2023-08-28">

        <label for="endDate">End Date</label>
        <input type="date" name="endDate" value="2023-12-16">

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
        <input type="time" name="startTime" placeholder="HH:MM AM/PM" required>

        <label for="endTime">End Time:</label>
        <input type="time" name="endTime" placeholder="HH:MM AM/PM" required>

        <input type="submit" value="Create Course">
        <input type="reset" value="Clear">
        <?php
        if (isset($_SESSION['createMsg'])) {
            echo '<h2 class="update-message">' . $_SESSION['createMsg'] . '</h2>';
            unset($_SESSION['createMsg']);
        }
        ?>
    </form>

    <h3 class="center">Edit Courses</h3>
    <div class="search_course">
        <form id="courseSearch" onsubmit="return courseSearch();">
            <label for="courseName">Course Name:</label>
            <input type="hidden" name="courseId" value="<?= htmlspecialchars($course['courseId']) ?>">
            <input type="text" name="courseName" required>

            <input type="submit" value="Search">
        </form>
        <div id="courseResults"></div>
        <?php
        if (isset($_SESSION['updateMsg'])) {
            echo '<h2 class="update-message">' . $_SESSION['updateMsg'] . '</h2>';
            unset($_SESSION['updateMsg']);
        }
        ?>
    </div>


    <h3 class="center">Edit students taking courses</h3>
    <div class="search_course">
        <form id="studentSearch" onsubmit="return studentSearch();">
            <label for="studentName">Student Name:</label>
            <input type="text" name="studentName" required>
            <input type="submit" value="Search">
        </form>
        <div id="studentResults"></div>
        <?php
        if (isset($_SESSION['updateMsg'])) {
            echo '<h2 class="update-message">' . $_SESSION['updateMsg'] . '</h2>';
            unset($_SESSION['updateMsg']);
        }
        ?>
    </div>

    <h3 class="center">Edit professors teaching courses</h3>
    <div class="search_course">
        <form id="professorSearchForm" onsubmit="return professorSearch();">
            <label for="professorName">Professor Name:</label>
            <input type="text" name="professorName" required>
            <input type="submit" value="Search">
        </form>
        <div id="professorResults"></div>
        <?php
        if (isset($_SESSION['updateMsg'])) {
            echo '<h2 class="update-message">' . $_SESSION['updateMsg'] . '</h2>';
            unset($_SESSION['updateMsg']);
        }
        ?>
    </div>

    <script>
        function courseSearch() {
            // Get search term
            var data = new FormData(document.getElementById("courseSearch"));
            data.append("ajax", 1);

            // AJAX search request
            fetch("courseSearch.php", { method: "POST", body: data })
                .then(res => res.json())
                .then(res => {
                    var wrapper = document.getElementById("courseResults");
                    if (res.length > 0) {
                        wrapper.innerHTML = ""; // Clear previous results

                        // Create a table and header row
                        let table = document.createElement("table");
                        table.classList.add("course-table"); // Add a class for styling
                        let headerRow = document.createElement("tr");
                        headerRow.innerHTML = "<th>Course Prefix</th><th>Course Name</th><th>Meeting Days</th><th>Start Time</th><th>End Time</th><th>Action</th>"; // Add header cells
                        table.appendChild(headerRow);

                        // Loop through each result
                        for (let r of res) {
                            let courseId = r["courseId"] || "";
                            let name = r["name"] || "";
                            let prefix = r["prefix"] || "";
                            let daysOfWeek = r["daysOfWeek"] || "";
                            let startTime = r["startTime"] || "";
                            let endTime = r["endTime"] || "";

                            // Create a new table row for each course
                            let line = document.createElement("tr");

                            // Add the courseId as a hidden input
                            let courseIdInput = document.createElement("input");
                            courseIdInput.type = "hidden";
                            courseIdInput.name = "courseId";
                            courseIdInput.value = courseId;
                            line.appendChild(courseIdInput);

                            // Add the prefix cell
                            let prefixCell = document.createElement("td");
                            prefixCell.textContent = prefix;
                            line.appendChild(prefixCell);

                            // Add the course name cell
                            let nameCell = document.createElement("td");
                            nameCell.textContent = name;
                            line.appendChild(nameCell);

                            // Add the daysOfWeek cell
                            let daysCell = document.createElement("td");
                            daysCell.textContent = daysOfWeek;
                            line.appendChild(daysCell);

                            // Add the startTime cell
                            let startTimeCell = document.createElement("td");
                            startTimeCell.textContent = startTime;
                            line.appendChild(startTimeCell);

                            // Add the endTime cell
                            let endTimeCell = document.createElement("td");
                            endTimeCell.textContent = endTime;
                            line.appendChild(endTimeCell);

                            // Add the "Edit" button
                            let editButton = document.createElement("button");
                            editButton.textContent = "Edit";
                            editButton.onclick = function () {
                                editCourse(courseId);
                            };

                            // Add the action cell
                            let actionCell = document.createElement("td");
                            actionCell.appendChild(editButton);
                            line.appendChild(actionCell);

                            // Append the new table row to the table
                            table.appendChild(line);
                        }

                        // Append the table to the wrapper
                        wrapper.appendChild(table);
                    } else {
                        wrapper.innerHTML = "No results found";
                    }
                })
            return false;
        }

        function editCourse(courseId) {
            // Redirect to the edit.php page with user type, email, first name, and last name as parameters
            window.location.href = `courseEdit.php?courseId=${courseId}`;
        }

        function studentSearch() {
            var data = new FormData(document.getElementById("studentSearch"));
            data.append("ajax", 1);

            fetch("studentSearch.php", { method: "POST", body: data })
                .then(res => res.json())
                .then(res => {
                    var wrapper = document.getElementById("studentResults");
                    if (res.length > 0) {
                        wrapper.innerHTML = ""; // Clear previous results

                        // Create a table and header row
                        let table = document.createElement("table");
                        table.classList.add("course-table"); // Add a class for styling
                        let headerRow = document.createElement("tr");
                        headerRow.innerHTML = "<th>Student Name</th><th>Action</th>"; // Add header cells
                        table.appendChild(headerRow);

                        // Assuming that the response is an array of students
                        for (let student of res) {
                            let studentId = student["userId"] || "";
                            let studentName = student["firstName"] + " " + student["lastName"] || "";

                            // Create a new table row for each student
                            let line = document.createElement("tr");

                            // Add the student name cell
                            let nameCell = document.createElement("td");
                            nameCell.textContent = studentName;
                            line.appendChild(nameCell);

                            // Add the "Edit" button
                            let editButton = document.createElement("button");
                            editButton.textContent = "Edit";
                            editButton.onclick = function () {
                                editStudentCourse(studentId, studentName);
                            };

                            // Add the action cell with the "Edit" button
                            let actionCell = document.createElement("td");
                            actionCell.appendChild(editButton);
                            line.appendChild(actionCell);

                            // Append the new table row to the table
                            table.appendChild(line);
                        }

                        // Append the table to the wrapper
                        wrapper.appendChild(table);
                    } else {
                        wrapper.innerHTML = "No results found";
                    }
                })

            return false;
        }

        function editStudentCourse(studentId, studentName) {
            // Redirect for editing students taking courses
            window.location.href = `editStudentCourse.php?studentId=${studentId}&studentName=${studentName}`;
        }

        function professorSearch() {
            var data = new FormData(document.getElementById("professorSearchForm"));
            data.append("ajax", 1);

            fetch("professorSearch.php", { method: "POST", body: data })
                .then(res => res.json())
                .then(res => {
                    var wrapper = document.getElementById("professorResults");
                    if (res.length > 0) {
                        wrapper.innerHTML = ""; // Clear previous results

                        // Create a table and header row
                        let table = document.createElement("table");
                        table.classList.add("course-table"); // Add a class for styling
                        let headerRow = document.createElement("tr");
                        headerRow.innerHTML = "<th>Professor Name</th><th>Action</th>"; // Add header cells
                        table.appendChild(headerRow);

                        // Assuming that the response is an array of professors
                        for (let professor of res) {
                            let professorId = professor["userId"] || "";
                            let professorName = professor["firstName"] + " " + professor["lastName"] || "";

                            // Create a new table row for each professor
                            let line = document.createElement("tr");

                            // Add the professor name cell
                            let nameCell = document.createElement("td");
                            nameCell.textContent = professorName;
                            line.appendChild(nameCell);

                            // Add the "Edit" button
                            let editButton = document.createElement("button");
                            editButton.textContent = "Edit";
                            editButton.onclick = function () {
                                editProfessorCourse(professorId, professorName);
                            };

                            // Add the action cell with the "Edit" button
                            let actionCell = document.createElement("td");
                            actionCell.appendChild(editButton);
                            line.appendChild(actionCell);

                            // Append the new table row to the table
                            table.appendChild(line);
                        }

                        // Append the table to the wrapper
                        wrapper.appendChild(table);
                    } else {
                        wrapper.innerHTML = "No results found";
                    }
                })
            return false;
        }

        function editProfessorCourse(professorId, professorName) {
            // Redirect for editing professor teaching courses
            window.location.href = `editProfessorCourse.php?professorId=${professorId}&professorName=${professorName}`;
        }
    </script>
</body>

</html>