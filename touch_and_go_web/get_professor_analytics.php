<?php
$student_checkIn_array = array(); // Initialize an array to store student information

// Prepare our SQL statement to prevent SQL injection
if (
  $stmt = $con->prepare('
  SELECT
    s.userId AS studentUserId,
    s.firstName AS studentFirstName,
    s.lastName AS studentLastName,
    c.courseId,
    c.name AS courseName,
    c.startDate AS courseStartDate,
    c.endDate AS courseEndDate,
    MIN(f.checkIn) AS firstCheckInTime
  FROM
    student_course sc
  JOIN
    student s ON sc.userId = s.userId
  JOIN
    fingerprint f ON s.userId = f.userId
  JOIN
    course c ON sc.courseId = c.courseId
  JOIN
    professor_course pc ON c.courseId = pc.courseId
  WHERE
    f.checkIn BETWEEN CONCAT(c.startDate, " ", c.startTime) AND CONCAT(c.endDate, " ", c.endTime)
    AND TIME(f.checkIn) BETWEEN c.startTime AND c.endTime
    AND pc.userId = ?
    AND INSTR(c.daysOfWeek, DAYNAME(f.checkIn)) > 0 
  GROUP BY
    s.userId, c.courseId, DATE(f.checkIn)
  ORDER BY
    c.courseId, s.userId, firstCheckInTime;')
) {
  $stmt->bind_param('i', $_SESSION['id']);

  if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // Fetch all rows as an associative array and store in $student_checkIn_array
      $student_checkIn_array = $result->fetch_all(MYSQLI_ASSOC);
    }
  } else {
    echo 'Error executing the query: ' . $stmt->error;
  }

  $stmt->close();
} else {
  echo 'Error preparing the statement: ' . $con->error;
}
?>