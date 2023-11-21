<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'] ?? null;
    $userId = $_SESSION['id'] ?? null;

    $checkInQuery = "SELECT f.checkIn, c.startTime, c.endTime, c.startDate, c.endDate
                     FROM fingerprint f
                     JOIN course c ON f.checkIn BETWEEN CONCAT(c.startDate, ' ', c.startTime) AND CONCAT(c.endDate, ' ', c.endTime)
                     WHERE f.userId = ? AND c.courseId = ?
                     ORDER BY f.checkIn desc";

    $checkInStmt = $con->prepare($checkInQuery);
    $checkInStmt->bind_param('ii', $userId, $courseId);
    $checkInStmt->execute();
    $checkInStmt->bind_result($checkIn, $startTime, $endTime, $startDate, $endDate);
    $checkInStmt->fetch();
    $checkInStmt->close();

    if ($checkIn) {
        echo "You checked in at: $checkIn during the class from $startTime to $endTime.";
    } else {
        echo "No check-in records found for the specified class.";
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}

?>