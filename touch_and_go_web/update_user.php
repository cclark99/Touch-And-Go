<?php
// Include necessary files and establish database connection
include("db_connection.php");

// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$userEmail = $_POST['userEmail'];
$userType = $_POST['userType'];

// Update the user table
$stmtUser = $pdo->prepare("UPDATE user SET userEmail = ? WHERE userEmail = ?");
$stmtUser->execute([$userEmail, $userEmail]);

// Check if the update was successful
if ($stmtUser->rowCount() > 0) {
    // Successful update for the user table

    // Check the user type to update the corresponding table
    switch ($userType) {
        case 'student':
            // Update the student table
            $stmtStudent = $pdo->prepare("UPDATE student SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtStudent->execute([$firstName, $lastName, $userId]);
            break;

        case 'professor':
            // Update the professor table
            $stmtProfessor = $pdo->prepare("UPDATE professor SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtProfessor->execute([$firstName, $lastName, $userId]);
            break;

        case 'admin':
            // Update the admin table
            $stmtAdmin = $pdo->prepare("UPDATE admin SET firstName = ?, lastName = ? WHERE userId = ?");
            $stmtAdmin->execute([$firstName, $lastName, $userId]);
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