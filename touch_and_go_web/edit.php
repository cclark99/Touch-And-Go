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

        /* start of class style rules for editBox */
        .editBox {
            width: 50%;
            margin: auto;
            text-align: center;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #FFFFFF;
        }

        /* Add modern styling for the form inputs and labels */
        .editBox label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        .editBox input[type="number"],
        .editBox input[type="password"],
        .editBox input[type="text"] {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .editBox input[type="submit"] {
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

        .editBox input.update {
            background: #4CAF50;
            /* Green background for the update button */
        }

        .editBox input.delete {
            background: #FF6347;
            /* Red background for the delete button */
        }


        .editBox input[type="submit"]:hover {
            background: #2a3c4e;
        }

        .editBox input.update:hover {
            background: #397d13;
            /* Darker green color for update button on hover */
        }

        .editBox input.delete:hover {
            background: #8b0000;
            /* Darker red color for delete button on hover */
        }
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
    <div class="editBox">
        <form method="post" action="update_user.php">
            <label for="userEmail">User ID#: </label>
            <input type="number" name="userId" value="<?= htmlspecialchars($userData['userId']) ?>" readonly>

            <label for="userType">User Type: </label>
            <input type="text" name="userType" value="<?= htmlspecialchars($userData['userType']) ?>" readonly>

            <label for="userEmail">Password: </label>
            <input type="password" name="userPassword" value="<?= htmlspecialchars($userData['userPassword']) ?>">

            <label for="userPassword">Email: </label>
            <input type="text" name="userEmail" value="<?= htmlspecialchars($userData['userEmail']) ?>">


            <input type="submit" class="update" value="Update">
            <input type="submit" class="delete" name="delete" value="Delete"
                onclick="return confirm('Are you sure you want to delete this user?')">
        </form>
    </div>
</body>

</html>