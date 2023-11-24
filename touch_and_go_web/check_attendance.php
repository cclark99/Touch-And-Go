<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'] ?? null;
    $userId = $_SESSION['id'] ?? null;

    // Debugging statement
    echo "UserID: $userId, CourseID: $courseId<br>";

    $checkInQuery = "SELECT f.checkIn
                     FROM fingerprint f
                     JOIN course c ON f.checkIn BETWEEN CONCAT(c.startDate, ' ', c.startTime) AND CONCAT(c.endDate, ' ', c.endTime)
                     WHERE f.userId = ? AND c.courseId = ?
                     AND f.checkIn >= CURDATE() AND f.checkIn < CURDATE() + INTERVAL 1 DAY
                     ORDER BY f.checkIn DESC
                     LIMIT 1";

    $checkInStmt = $con->prepare($checkInQuery);

    if (!$checkInStmt) {
        // Debugging statement
        die("Prepare failed: (" . $con->errno . ") " . $con->error);
    } else {
        $checkInStmt->bind_param('ii', $userId, $courseId);
        $checkInStmt->execute();

        if ($checkInStmt->errno) {
            // Debugging statement
            die("Execute failed: (" . $checkInStmt->errno . ") " . $checkInStmt->error);
        } else {
            $checkInStmt->bind_result($checkIn);

            if ($checkInStmt->fetch()) {
                // Debugging statement
                echo "Attendance recorded. CheckIn: $checkIn";
            } else {
                // Debugging statement
                echo "No attendance recorded.";
            }
        }

        $checkInStmt->close();
    }
} else {
    // Debugging statement
    echo "Invalid request method.";
}
?>