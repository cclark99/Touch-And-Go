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

        .searchBox {
            width: 50%;
            margin: auto;
            text-align: center;
            margin-top: 20px;
            /* Add margin-top for better spacing */
            border-radius: 10px;
            /* Add border-radius for rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add a subtle box shadow for depth */
            padding: 20px;
            /* Add padding for space inside the box */
            background-color: #FFFFFF;
            /* Set a white background color */
        }

        .searchBox form {
            display: flex;
            /* Use flexbox for easier spacing */
            flex-wrap: wrap;
            /* Allow items to wrap to the next line if there's not enough space */
            align-items: center;
            /* Align items vertically in the center */
            justify-content: center;
            /* Center items horizontally */
        }

        /* Add modern styling for the search input */
        .searchBox input[type="text"] {
            flex: 2;
            /* Make the search input twice as wide as the dropdown */
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0 5px;
            /* Add some horizontal margin */
        }

        /* Add modern styling for the dropdown */
        .searchBox select {
            flex: 1;
            /* Make the dropdown one-third as wide as the search input */
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0 5px;
            /* Add some horizontal margin */
        }

        /* Add modern styling for the search button */
        .searchBox input[type="submit"] {
            flex: 1;
            /* Make the search button one-third as wide as the search input */
            padding: 15px 30px;
            font-size: 18px;
            border: 0;
            color: #fff;
            background: #10222e;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
            margin: 0 5px;
            /* Add some horizontal margin */
        }

        /* Change background color on hover for the search button */
        .searchBox input[type="submit"]:hover {
            background: #2a3c4e;
        }

        #results {
            margin-top: 20px;
            width: 90%;
            margin: auto;
        }

        #results table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin-top: 10px;
        }

        #results th,
        #results td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        #results th {
            background-color: #10222e;
            color: #fff;
        }

        #results tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #results button {
            padding: 8px;
            font-size: 14px;
            background: #10222e;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #results button:hover {
            background: #2a3c4e;
        }

        #results p {
            font-size: 20px;
            /* Increase font size */
            color: #555;
            /* Change text color to a subdued gray */
            margin-top: 20px;
            /* Add some top margin */
        }


        #fakeNav a:hover {
            background-color: #0f222e;
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

        .row-container button {
            padding: 8px;
            font-size: 14px;
            background: #10222e;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .row-container button:hover {
            background: #2a3c4e;
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
    <h1>Home</h1>

    <h3 class="center">Search & Edit Users</h3>
    <div class="searchBox">
        <form id="search" onsubmit="return asearch();">
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
        if (isset($_SESSION['updateMsg'])) {
            echo '<h2 class="update-message">' . $_SESSION['updateMsg'] . '</h2>';
            unset($_SESSION['updateMsg']);
        }
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
                        wrapper.innerHTML = ""; // Clear previous results

                        // Create a table and header row
                        let table = document.createElement("table");
                        table.innerHTML = "<tr><th>User Type</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th></tr>";

                        // Loop through each result
                        for (let r of res) {
                            let userType = r["userType"] || "";
                            let firstName = r[`${userType}FirstName`] || "";
                            let lastName = r[`${userType}LastName`] || "";
                            let userEmail = r["userEmail"] || "";

                            // Create a new table row for each user
                            let line = document.createElement("tr");

                            // Add the "row-container" class to each cell in the row
                            let userTypeCell = document.createElement("td");
                            userTypeCell.textContent = userType;
                            userTypeCell.classList.add("row-container");
                            line.appendChild(userTypeCell);

                            let firstNameCell = document.createElement("td");
                            firstNameCell.textContent = firstName;
                            firstNameCell.classList.add("row-container");
                            line.appendChild(firstNameCell);

                            let lastNameCell = document.createElement("td");
                            lastNameCell.textContent = lastName;
                            lastNameCell.classList.add("row-container");
                            line.appendChild(lastNameCell);

                            let userEmailCell = document.createElement("td");
                            userEmailCell.textContent = userEmail;
                            userEmailCell.classList.add("row-container");
                            line.appendChild(userEmailCell);

                            // Create the "Edit" button
                            let editButton = document.createElement("button");
                            editButton.textContent = "Edit";
                            editButton.onclick = function () {
                                editUser(userType, userEmail, firstName, lastName);
                            };

                            // Add the "row-container" class to the action cell
                            let actionCell = document.createElement("td");
                            actionCell.appendChild(editButton);
                            actionCell.classList.add("row-container");
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
                .catch(error => console.error("Error:", error)); // Add this line for error handling
            return false;
        }

        function editUser(userType, userEmail, firstName, lastName) {
            // Redirect to the edit.php page with user type, email, first name, and last name as parameters
            window.location.href = `edit.php?userType=${userType}&userEmail=${userEmail}&firstName=${firstName}&lastName=${lastName}`;
        }
    </script>

</body>

</html>