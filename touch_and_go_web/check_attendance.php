<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'] ?? null;
    $userId = $_SESSION['id'] ?? null;

    // Get the current date and time
    $currentDateTime = date('Y-m-d H:i:s');

    $checkInQuery = "SELECT f.checkIn
                     FROM fingerprint f
                     JOIN course c ON f.checkIn BETWEEN CONCAT(c.startDate, ' ', c.startTime) AND CONCAT(c.endDate, ' ', c.endTime)
                     WHERE f.userId = ? AND c.courseId = ? AND DATE(f.checkIn) = CURDATE()
                     ORDER BY f.checkIn DESC
                     LIMIT 1";

    $checkInStmt = $con->prepare($checkInQuery);

    if (!$checkInStmt) {
        die("Prepare failed: (" . $con->errno . ") " . $con->error);
    } else {
        $checkInStmt->bind_param('ii', $userId, $courseId);
        $checkInStmt->execute();

        if ($checkInStmt->errno) {
            die("Execute failed: (" . $checkInStmt->errno . ") " . $checkInStmt->error);
        } else {
            $checkInStmt->bind_result($checkIn);

            if ($checkInStmt->fetch()) {
                // Check if the retrieved check-in time is within an acceptable range
                // You may need to adjust this condition based on your specific requirements
                if (strtotime($checkIn) >= strtotime($currentDateTime) - 3600) {
                    echo "Attendance recorded.";
                } else {
                    echo "No attendance recorded within the time range.";
                }
            } else {
                echo "No attendance recorded.";
            }
        }

        $checkInStmt->close();
    }
} else {
    echo "Invalid request method.";
}
?>