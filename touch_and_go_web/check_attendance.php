<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'] ?? null;
    $userId = $_SESSION['id'] ?? null;

    // Get the current date
    $currentDate = date('Y-m-d');

    $checkInQuery = "SELECT f.checkIn, c.startTime, c.endTime, c.startDate, c.endDate
                 FROM fingerprint f
                 JOIN course c ON f.checkIn BETWEEN CONCAT(c.startDate, ' ', c.startTime) AND CONCAT(c.endDate, ' ', c.endTime)
                 WHERE f.userId = ? AND c.courseId = ? AND DATE(f.checkIn) = CURDATE()
                 ORDER BY f.checkIn DESC
                 LIMIT 1";  // Limit to one result since we only want the latest check-in

    $checkInStmt = $con->prepare($checkInQuery);
    $checkInStmt->bind_param('ii', $userId, $courseId);
    $checkInStmt->execute();
    $checkInStmt->bind_result($checkIn, $startTime, $endTime, $startDate, $endDate);

    if ($checkInStmt->fetch()) {
        // Debugging statement
        echo "Fetched data successfully.\n";
        echo "checkIn: $checkIn, startTime: $startTime, endTime: $endTime, startDate: $startDate, endDate: $endDate";
    } else {
        // Debugging statement
        echo "Failed to fetch data. Error: " . $con->error;
    }

    $checkInStmt->close();
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}
?>