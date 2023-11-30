<?php

session_start();

// Include necessary files and establish database connection
include("db_connection.php");

// Retrieve form data and trim whitespace
$userId = trim($_POST['userId']);
$userEmail = trim($_POST['userEmail']);
$userType = trim($_POST['userType']);
$userPassword = trim($_POST['userPassword']);
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);

// Check if the new email already exists in the database
$stmtCheckEmail = $con->prepare("SELECT userId FROM user WHERE userEmail = ?");
$stmtCheckEmail->bind_param("s", $userEmail);
$stmtCheckEmail->execute();
$stmtCheckEmail->store_result();

if ($stmtCheckEmail->num_rows > 0) {
    // Email already exists, inform the user
    $_SESSION['updateMsg'] = 'Email address already exists. Please choose a different email.';
    header('Location: adminHome.php');
    exit();
}

// Continue with the update if the email is unique
$stmtCheckEmail->close();

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