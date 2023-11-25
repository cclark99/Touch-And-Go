<?php

session_start();

// Include necessary files and establish database connection
include("db_connection.php");


// Retrieve form data
$userId = $_POST['userId'];
$userType = $_POST['userType'];
// Update the user table
if ($stmtUser = $con->prepare("DELETE FROM user WHERE userId = ?")) {
    $stmtUser->bind_param("i", $userId);
    $stmtUser->execute();
    switch ($userType) {
        case 'student':
            // Update the student table
            $stmtStudent = $con->prepare("DELETE FROM student WHERE userId = ?");
            $stmtStudent->bind_param("i", $userId);
            $stmtStudent->execute();

            $stmtFingerprint = $con->prepare("DELETE FROM fingerprint WHERE userId = ?");
            $stmtFingerprint->bind_param("i", $userId);
            $stmtFingerprint->execute();
            
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully updated Student: ' . $userId;
            header('Location: adminHome.php');
            exit();

        case 'professor':
            // Update the professor table
            $stmtProfessor = $con->prepare("DELETE FROM professor WHERE userId = ?");
            $stmtProfessor->bind_param("i", $userId);
            $stmtProfessor->execute();
            // Redirect back to the search page with a success message
            $_SESSION['updateMsg'] = 'Successfully updated Professor: ' . $userId;
            header('Location: adminHome.php');
            exit();

        case 'admin':
            // Update the admin table
            $stmtAdmin = $con->prepare("DELETE FROM admin WHERE userId = ?");
            $stmtAdmin->bind_param("i", $userId);
            $stmtAdmin->execute();
            $_SESSION['updateMsg'] = 'Successfully updated Admin: ' . $userId;
            header('Location: adminHome.php?');
            exit();

        default:
            // Failed to update the user table (e.g., user not found)
            // Redirect back to the search page with an error message
            $_SESSION['updateMsg'] = 'Unsuccessfully deleted User';
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