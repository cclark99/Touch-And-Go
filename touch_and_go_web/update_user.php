<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files and establish database connection
include("db_connection.php");

// Retrieve form data
// $firstName = $_POST['firstName'];
// $lastName = $_POST['lastName'];
$userId = $_POST['userId'];
$userEmail = $_POST['userEmail'];
$userType = $_POST['userType'];
$userPassword = $_POST['userPassword'];

// Update the user table
$stmtUser = $con->prepare("UPDATE user SET userEmail = ?, userPassword= ? WHERE userId = ?");
$newPassword = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
$stmtUser->bind_param("ssi", $newPassword, $userEmail, $userId);
$stmtUser->execute();

header('Location: analytics.php?success=1');
exit();

// Check if the update was successful
// if ($stmtUser->affected_rows > 0) {

//     // Check the user type to update the corresponding table
//     switch ($userType) {
//         case 'student':
//             // Update the student table
//             $stmtStudent = $con->prepare("UPDATE student SET firstName = ?, lastName = ? WHERE userId = ?");
//             $stmtStudent->bind_param("ssi", $firstName, $lastName, $userId);
//             $stmtStudent->execute();
//             break;

//         case 'professor':
//             // Update the professor table
//             $stmtProfessor = $con->prepare("UPDATE professor SET firstName = ?, lastName = ? WHERE userId = ?");
//             $stmtProfessor->bind_param("ssi", $firstName, $lastName, $userId);
//             $stmtProfessor->execute();
//             break;

//         case 'admin':
//             // Update the admin table
//             $stmtAdmin = $con->prepare("UPDATE admin SET firstName = ?, lastName = ? WHERE userId = ?");
//             $stmtAdmin->bind_param("ssi", $firstName, $lastName, $userId);
//             $stmtAdmin->execute();
//             break;

//         default:
//             // Handle unknown user types if needed
//             break;
//     }

//     // Redirect back to the search page with a success message
//     header('Location: analytics.php?success=1');
//     exit();
// } else {
//     // Failed to update the user table (e.g., user not found)
//     // Redirect back to the search page with an error message
//     header('Location: analytics.php?error=1');
//     exit();
// }
?>