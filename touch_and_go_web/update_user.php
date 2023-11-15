<?php
// Include necessary files and establish database connection
include("db_connection.php");

// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$userEmail = $_POST['userEmail'];
$userType = $_POST['userType'];

// Update the user table
$stmtUser = $con->prepare("UPDATE user SET firstName = ?, lastName = ? WHERE userEmail = ?");
$stmtUser->bind_param("sss", $firstName, $lastName, $userEmail);
$stmtUser->execute();

// Check if the update was successful
if ($stmtUser->affected_rows > 0) {

    // Check the user type to update the corresponding table
    switch ($userType) {
        case 'student':
            // Update the student table
            $stmtStudent = $con->prepare("UPDATE student SET firstName = ?, lastName = ? WHERE userEmail = ?");
            $stmtStudent->bind_param("sss", $firstName, $lastName, $userEmail);
            $stmtStudent->execute();
            break;

        case 'professor':
            // Update the professor table
            $stmtProfessor = $con->prepare("UPDATE professor SET firstName = ?, lastName = ? WHERE userEmail = ?");
            $stmtProfessor->bind_param("sss", $firstName, $lastName, $userEmail);
            $stmtProfessor->execute();
            break;

        case 'admin':
            // Update the admin table
            $stmtAdmin = $con->prepare("UPDATE admin SET firstName = ?, lastName = ? WHERE userEmail = ?");
            $stmtAdmin->bind_param("sss", $firstName, $lastName, $userEmail);
            $stmtAdmin->execute();
            break;

        default:
            // Handle unknown user types if needed
            break;
    }

    // Redirect back to the search page with a success message
    header('Location: search.php?success=1');
    exit();
} else {
    // Failed to update the user table (e.g., user not found)
    // Redirect back to the search page with an error message
    header('Location: search.php?error=1');
    exit();
}
?>