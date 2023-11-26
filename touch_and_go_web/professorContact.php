<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'professor') {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_professor_contact.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Contact</title>
  <link rel="stylesheet" type="text/css" href="../styles.css">
  <style>
    h3 {
      color: #10222E;
      font-size: 24pt;
      text-align: center;
    }

    .container {
      max-width: 800px;
      /* Adjust the max-width as needed */
      margin: 0 auto;
      padding: 20px;
    }

    .course-list {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .course-item {
      border: 1px solid #10222E;
      margin-bottom: 10px;
      padding: 10px;
      width: 300px;
      /* Adjust the width as needed */
      margin-right: auto;
      margin-left: auto;
    }

    .student-list {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .student-item li {
      width: auto;

    }

    .student-item {
      border: 1px solid #10222E;
      margin-bottom: 10px;
      padding: 10px;
    }

    .student-item a {
      color: #FAF8D6;;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <ul>
    <li><a class="link" href="professorHome.php">Home</a></li>
    <li><a class="link" href="professorSchedule.php">Schedule</a></li>
    <li><a class="link" href="professorAnalytics.php">Analytics</a></li>
    <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
    <li><a class='link' href="professorContact.php">Contact</a></li>
    <li><a class='link' href="professorHelp.php">Help</a></li>
    <li><a class='link' href="logout.php">Logout</a></li>
  </ul>

  <h1>Contact</h1>
  <h3>Professor Contact Information:</h3>

  <div class="container">
    <?php
    if ($course_array) {
      $currentCourse = null;

      foreach ($course_array as $student) {
        $courseId = $student['courseId'];

        // Display course name only once
        if ($currentCourse != $courseId) {
          // Close previous course if it exists
          if ($currentCourse !== null) {
            echo '</ul></div>';
          }

          echo '<div class="course-item"><strong>' . $student['className'] . '</strong>';
          echo '<ul class="student-list">';
        }

        echo '<li class="student-item">
                        <p>Student: <a class="link" href="mailto:' . $student['userEmail'] . '">' . $student['firstName'] . ' ' . $student['lastName'] . '</a></p>
                      </li>';

        $currentCourse = $courseId;
      }

      // Close the last course
      echo '</ul></div>';
    } else {
      echo '<p style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No student information found. </p>';
    }
    ?>
  </div>
</body>

</html>