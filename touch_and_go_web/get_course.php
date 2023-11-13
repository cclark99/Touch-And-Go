<?php
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if (
  $stmt = $con->prepare('select course.courseId, 
                                  course.name, 
                                  course.description,
                                  course.date, 
                                  course.dateStart, 
                                  course.endTime, 
                                  courseEndTime, 
                                  courseLocation,
                                  professor.userId,
                                  professor.firstName,
                                  professor.lastName,
                                  professor.professorEmail,
                                  professor.professorPhone
                            from course 
                              inner join student_course on student_course.courseId = course.courseId
                              inner join student on student.studentId = student_course.studentId
                              inner join professor_course on professor_course.courseId = course.courseId
                              inner join professor on professor_course.professorId = professor.professorId 
                            where student.studentId = ?')
) {

  $stmt->bind_param('s', $_SESSION['id']);

  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $course_array = array();
    foreach ($rows as $row) {
      $course_array[] = $row;
    }
  }
  $stmt->close();
  $con->close();
}

?>