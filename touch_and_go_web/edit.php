<?php

include("db_connection.php");

// Retrieve user type and email from the parameters
$userType = $_GET['userType'];
$userEmail = $_GET['userEmail'];

// Fetch user data based on user type and email from the database
$stmt = $con->prepare("SELECT * FROM user WHERE userEmail = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// If user data is not found, you may want to handle this scenario, e.g., redirect to an error page
if (!$userData) {
    header('Location: analytics.php');
    exit();
}

// Fetch user data based on user type and email from the database
// Perform necessary database queries to retrieve user data

// Display a form with the current user data for editing
?>

<!-- HTML form for editing user data -->
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
    <!-- set charset -->
    <meta charset="utf-8">
    <!-- set title -->
    <title>Contact</title>
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
            /*margin-top: 5%; /* make margin-top 5% */
        }

        /* end of style rules for h3 tag */

        /* start of class style rules for dropdown */
        .dropdown {
            width: 25%;
            /* make width 25% */
        }

        /* end of class style rules for dropdown */
    </style> <!-- end of style tag -->
</head> <!-- end of head tag -->

<body> <!-- start of body tag -->

    <!-- The following code was created on October 30, 2023, using 
    information from the following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

    <ul> <!-- start of ul for menu bar -->
        <!-- list home.php link -->
        <li><a class="link" href="home.php">Home</a></li>
        <!-- list schedule.php link -->
        <li><a class="link" href="schedule.php">Schedule</a></li>
        <!-- list analytics.php link -->
        <li><a class="link" href="analytics.php">Analytics</a></li>
        <!-- list Touch & Go logo -->
        <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
        <!-- list contact.php link -->
        <li><a class='link' href="contact.php">Contact</a></li>
        <!-- list help.php link -->
        <li><a class='link' href="help.php">Help</a></li>
        <!-- list logout.php link -->
        <li><a class='link' href="logout.php">Logout</a></li>
    </ul> <!-- end of ul for menu bar -->

    <!-- this ends the code that was created using information from the 
    following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

    <!-- contact header -->
    <h1>Contact</h1>
    <form method="post" action="update_user.php">
        <!-- Display current user data in form fields -->
        <!-- Include form fields for editing user information -->
        <!-- <input type="text" name="firstName" value="...">
        <input type="text" name="lastName" value="..."> -->

        <label for="userEmail">Email:</label>
        <input type="text" name="userEmail" value="<?= htmlspecialchars($userData['userEmail']) ?>"
            readonly><!-- User email is readonly -->

        <label for="userType">userType:</label>
        <input type="text" name="userType" value="<?= htmlspecialchars($userData['userType']) ?>"
            readonly><!-- User type is readonly -->

        <!-- Add other form fields for additional user information -->

        <!-- Add a submit button to update user information -->
        <input type="submit" value="Update">
    </form>
</body>

</html>