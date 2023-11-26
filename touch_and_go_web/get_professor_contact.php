<?php
$course_array = array(); // Initialize an array to store student information

// Prepare our SQL statement to prevent SQL injection
if (
  $stmt = $con->prepare('
    SELECT s.userId, s.firstName, s.lastName, u.userEmail, c.courseId, c.name AS className
    FROM student s
    INNER JOIN student_course sc ON s.userId = sc.userId
    INNER JOIN professor_course pc ON sc.courseId = pc.courseId
    INNER JOIN user u ON s.userId = u.userId
    INNER JOIN course c ON sc.courseId = c.courseId
    WHERE pc.userId = ?
    ORDER BY c.courseId')
) {
  $stmt->bind_param('s', $_SESSION['id']);

  if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // Fetch all rows as an associative array and store in $course_array
      $course_array = $result->fetch_all(MYSQLI_ASSOC);
    }
  } else {
    echo 'Error executing the query: ' . $stmt->error;
  }

  $stmt->close();
} else {
  echo 'Error preparing the statement: ' . $con->error;
}
?>