<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'admin') {
    include 'logout.php';
    exit();
}

$successMessage = isset($_GET['success']) ? "User information updated successfully!" : "";
$errorMessage = isset($_GET['error']) ? "Failed to update user information." : "";

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
        }

        #results table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            font-size: 18px;
        }

        #results th,
        #results td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        #results th {
            background-color: #10222e;
            color: #fff;
        }

        #results tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #fakeNav a:hover {
            background-color: #0f222e;
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
            echo '<h2 style="margin-top: 15px;">' . $_SESSION['updateMsg'] . '</h2>';
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
                            line.innerHTML = `<td>${userType}</td><td>${firstName}</td><td>${lastName}</td><td>${userEmail}</td><td><button onclick="editUser(this)">Edit</button></td>`;

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

        function editUser(button) {
            let row = button.parentNode.parentNode;

            // Get values from the row
            let userType = row.cells[0].textContent;
            let userEmail = row.cells[3].textContent;
            let firstName = row.cells[1].textContent;
            let lastName = row.cells[2].textContent;

            // Redirect to the edit.php page with user type and email as parameters
            window.location.href = `edit.php?userType=${userType}&userEmail=${userEmail}&firstName=${firstName}&lastName=${lastName}`;
        }
    </script>
</body>

</html>