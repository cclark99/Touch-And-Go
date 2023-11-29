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

// Retrieve the existing hashed password from the database
$stmtExistingPassword = $con->prepare("SELECT userPassword FROM user WHERE userId = ?");
$stmtExistingPassword->bind_param("i", $userId);
$stmtExistingPassword->execute();
$stmtExistingPassword->bind_result($existingPassword);
$stmtExistingPassword->fetch();
$stmtExistingPassword->close();

// Check if a new password is provided and if it's different from the existing password
if (!empty($userPassword) && $userPassword != $existingPassword) {
    $newPassword = password_hash($userPassword, PASSWORD_BCRYPT);

    // Update the user table with the new hashed password
    $stmtUser = $con->prepare("UPDATE user SET userEmail = ?, userPassword = ? WHERE userId = ?");
    $stmtUser->bind_param("ssi", $userEmail, $newPassword, $userId);
    $stmtUser->execute();
    $stmtUser->close();

} else {
    // Use the existing hashed password if no new password is provided or if it's the same
    $stmtUser = $con->prepare("UPDATE user SET userEmail = ? WHERE userId = ?");
    $stmtUser->bind_param("si", $userEmail, $userId);
    $stmtUser->execute();
    $stmtUser->close();
}

// Close the database connection before redirecting
// $con->close();

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
?>