<?php

session_start();

// Include necessary files and establish database connection
include("db_connection.php");




// Retrieve form data
$userId = $_POST['userId'];
$userEmail = $_POST['userEmail'];
$userType = $_POST['userType'];
$userPassword = $_POST['userPassword'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

// Update the user table
if ($stmtUser = $con->prepare("UPDATE user SET userEmail = ?, userPassword= ? WHERE userId = ?")) {
    $newPassword = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
    $stmtUser->bind_param("ssi", $userEmail, $newPassword, $userId);
    $stmtUser->execute();
    switch ($userType) {
        case 'student':
            // Update the student table
            $stmtStudent = $con->prepare("UPDATE student SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtStudent->bind_param("ssi", $firstName, $lastName, $userId);
            $stmtStudent->execute();
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully updated Student: ' . $userId;
            header('Location: adminHome.php');
            exit();

        case 'professor':
            // Update the professor table
            $stmtProfessor = $con->prepare("UPDATE professor SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtProfessor->bind_param("ssi", $firstName, $lastName, $userId);
            $stmtProfessor->execute();
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully updated Professor: ' . $userId;
            header('Location: adminHome.php');
            exit();

        case 'admin':
            // Update the admin table
            $stmtAdmin = $con->prepare("UPDATE admin SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtAdmin->bind_param("ssi", $firstName, $lastName, $userId);
            $stmtAdmin->execute();
            $_SESSION['updateMsg'] = 'Successfully updated Admin: ' . $userId;
            header('Location: adminHome.php?');
            exit();

        default:
            // Failed to update the user table (e.g., user not found)
            // Redirect back to the search page with an error message
            $_SESSION['updateMsg'] = 'Unsuccessfully updated User';
            header('Location: adminHome.php');
            exit();
    }

} else {
    // Failed to update the user table (e.g., user not found)
    // Redirect back to the search page with an error message
    $_SESSION['updateMsg'] = 'Unsuccessfully updated User';
    header('Location: adminHome.php');
    exit();
}
?>