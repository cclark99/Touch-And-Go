<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files and establish database connection
include("db_connection.php");

// Retrieve form data
$userEmail = $_POST['userEmail'];
$userType = $_POST['userType'];
$userPassword = $_POST['userPassword'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];

// Update the user table
if ($stmtUser = $con->prepare("INSERT INTO user (userEmail, userPassword, userType) VALUES( ?, ?, ?)")) {
    $newPassword = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
    $stmtUser->bind_param("sss", $userEmail, $newPassword, $userType);
    $stmtUser->execute();
    switch ($userType) {
        case 'student':
            if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
                $stmt->bind_param('s', $userEmail);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($userId);
                    $stmt->fetch();
                }
                $stmt->close();
            }

            // Update the student table
            $stmtStudent = $con->prepare("INSERT INTO student (userId, firstName, lastName) VALUES(?, ?, ?)");
            $stmtStudent->bind_param("iss", $userId, $firstName, $lastName);
            $stmtStudent->execute();
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully created Student: ' . $userId;
            header('Location: adminHome.php');
            exit();

        case 'professor':
            if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
                $stmt->bind_param('s', $userEmail);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($userId);
                    $stmt->fetch();
                }
                $stmt->close();
            }

            // Update the student table
            $stmtProfessor = $con->prepare("INSERT INTO professor (userId, firstName, lastName) VALUES(?, ?, ?)");
            $stmtProfessor->bind_param("iss", $userId, $firstName, $lastName);
            $stmtProfessor->execute();
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully created Professor: ' . $userId;
            header('Location: adminHome.php');
            exit();

        case 'admin':
            if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
                $stmt->bind_param('s', $userEmail);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($userId);
                    $stmt->fetch();
                }
                $stmt->close();
            }

            // Update the student table
            $stmtAdmin = $con->prepare("INSERT INTO admin (userId, firstName, lastName) VALUES(?, ?, ?)");
            $stmtAdmin->bind_param("iss", $userId, $firstName, $lastName);
            $stmtAdmin->execute();
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully created Admin: ' . $userId;
            header('Location: adminHome.php');
            exit();

        default:
            // Failed to update the user table (e.g., user not found)
            // Redirect back to the search page with an error message
            $_SESSION['updateMsg'] = 'Unsuccessfully created User';
            header('Location: adminHome.php');
            exit();
    }

} else {
    // Failed to update the user table (e.g., user not found)
    // Redirect back to the search page with an error message
    $_SESSION['updateMsg'] = 'Unsuccessfully created User';
    header('Location: adminHome.php');
    exit();
}
?>