<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'] ?? null;
    $userId = $_SESSION['id'] ?? null;

    // Get the current day and current week start and end dates
    $currentDay = date('l'); // 'l' returns the full name of the day
    $currentWeekStart = date('Y-m-d', strtotime('last Monday')); // Assuming Monday is the start of the week
    $currentWeekEnd = date('Y-m-d', strtotime('next Sunday'));

    // Check if the current day is within the daysOfWeek for the course and if the date is within the current week
    $checkInQuery = "SELECT f.checkIn, c.startTime, c.endTime, c.startDate, c.endDate, c.daysOfWeek
                 FROM fingerprint f
                 JOIN course c ON f.checkIn BETWEEN CONCAT(c.startDate, ' ', c.startTime) AND CONCAT(c.endDate, ' ', c.endTime)
                 WHERE f.userId = ? AND c.courseId = ? 
                   AND (
                       FIND_IN_SET(?, REPLACE(c.daysOfWeek, '', ',')) > 0
                       OR c.daysOfWeek LIKE CONCAT('%', ?, '%') -- Check if the current day is in the daysOfWeek string
                   )
                   AND DAYOFWEEK(f.checkIn) = DAYOFWEEK(CURDATE())
                   AND DATE(f.checkIn) BETWEEN ? AND ?
                 ORDER BY f.checkIn DESC";

    $checkInStmt = $con->prepare($checkInQuery);
    $checkInStmt->bind_param('iississs', $userId, $courseId, $currentDay, $currentDay, $currentDay, $currentDay, $currentWeekStart, $currentWeekEnd);
    $checkInStmt->execute();
    $checkInStmt->bind_result($checkIn, $startTime, $endTime, $startDate, $endDate, $daysOfWeek);

    // Fetch all rows
    $attendanceRecords = array();
    while ($checkInStmt->fetch()) {
        $attendanceRecords[] = array(
            'checkIn' => $checkIn,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'daysOfWeek' => $daysOfWeek,
        );
    }

    $checkInStmt->close();

    if (!empty($attendanceRecords)) {
        // Output the attendance records for the current day and week
        foreach ($attendanceRecords as $record) {
            echo "You checked in at: {$record['checkIn']} during the class from {$record['startTime']} to {$record['endTime']} on {$record['startDate']}.";
        }
    } else {
        echo "No check-in records found for the specified class on $currentDay within the current week.";
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}

?>