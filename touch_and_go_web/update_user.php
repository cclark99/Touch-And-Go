<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files and establish database connection
include("db_connection.php");




// Retrieve form data
$userId = $_POST['userId'];
$userEmail = $_POST['userEmail'];
$userType = $_POST['userType'];
$userPassword = $_POST['userPassword'];

switch (true) {
    case $userType == 'student':
        if ($stmt = $con->prepare('SELECT firstName, lastName FROM student WHERE userId = ?')) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($firstName, $lastName);
                $stmt->fetch();
            }
            $stmt->close();
        }
        break;

    case $userType == 'professor':
        if ($stmt = $con->prepare('SELECT firstName, lastName FROM professor WHERE userId = ?')) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($firstName, $lastName);
                $stmt->fetch();
            }
            $stmt->close();
        }
        break;

    case $userType == 'admin':
        if ($stmt = $con->prepare('SELECT firstName, lastName FROM admin WHERE userId = ?')) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($firstName, $lastName);
                $stmt->fetch();
            }
            $stmt->close();
        }
        break;

    default:
        include 'logout.php';
        break;
}


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
            header('Location: analytics.php?success=1');
            exit();

        case 'professor':
            // Update the professor table
            $stmtProfessor = $con->prepare("UPDATE professor SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtProfessor->bind_param("ssi", $firstName, $lastName, $userId);
            $stmtProfessor->execute();
            // Redirect back to the search page with a success message
            header('Location: analytics.php?success=1');
            exit();

        case 'admin':
            // Update the admin table
            $stmtAdmin = $con->prepare("UPDATE admin SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtAdmin->bind_param("ssi", $firstName, $lastName, $userId);
            $stmtAdmin->execute();
            // Redirect back to the search page with a success message
            header('Location: analytics.php?success=1');
            exit();

        default:
            // Failed to update the user table (e.g., user not found)
            // Redirect back to the search page with an error message
            header('Location: analytics.php?error=1');
            exit();
    }

} else {
    // Failed to update the user table (e.g., user not found)
    // Redirect back to the search page with an error message
    header('Location: analytics.php?error=1');
    exit();
}
?>