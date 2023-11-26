<?php
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if (
  $stmt = $con->prepare('select * from course 
                            inner join professor_course on professor_course.courseId = course.courseId 
                            inner join professor on professor_course.userId = professor.userId 
                         where professor.userId = ?')
) {
  $stmt->bind_param('s', $_SESSION['id']);

  if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $rows = $result->fetch_all(MYSQLI_ASSOC);
      $course_array = array();

      $currentDate = date('Y-m-d');

      foreach ($rows as $row) {
        // Check if the current date is within the range of startDate and endDate
        if ($currentDate >= $row['startDate'] && $currentDate <= $row['endDate']) {
          $course_array[] = $row;
        }
      }
    }
  } else {
    echo 'Error executing the query: ' . $stmt->error;
  }

  $stmt->close();
} else {
  echo 'Error preparing the statement: ' . $con->error;
}
?>