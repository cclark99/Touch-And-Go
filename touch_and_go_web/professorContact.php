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

    .student-list {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .student-item {
      border: 1px solid #10222E;
      margin-bottom: 10px;
      padding: 10px;
    }

    .student-item a {
      color: #10222E;
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

  <?php
  if ($course_array) {
    foreach ($course_array as $row) {
      $courseId = $row['courseId'];

      echo '<ul class="student-list">';
      echo '<li class="student-item"><strong>' . $row['className'] . '</strong></li>';

      // Display students in the course
      foreach ($course_array as $student) {
        if ($student['courseId'] == $courseId) {
          echo '<li class="student-item">
                            <p>Student: <a class="link" href="mailto:' . $student['userEmail'] . '">' . $student['firstName'] . ' ' . $student['lastName'] . '</a></p>
                          </li>';
        }
      }

      echo '</ul>';
    }
  } else {
    echo '<p style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No student information found. </p>';
  }
  ?>

</body>

</html>