<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'professor') {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_professor_analytics.php';

?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Analytics</title>
  <link rel="stylesheet" type="text/css" href="../styles.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <style>
    /* Your existing styles */

    /* Add these styles to your existing CSS */
    /* Style for the dropdown menu */
    .searchBox select {
      padding: 10px;
      margin-right: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    /* Style for the search form */
    .searchBox form {
      padding: 20px;
      margin: auto;
      border: 1px solid #eee;
      background: #f7f7f7;
      display: grid;
      align-content: center;
    }

    .searchBox input {
      display: block;
      padding: 10px;
    }

    .searchBox input[type=text],
    .searchBox select {
      width: 50%;
      /* Adjust the width as needed */
    }

    .searchBox input[type=submit] {
      margin-top: 20px;
      border: 0;
      color: #fff;
      background: #10222e;
      cursor: pointer;
    }

    /* Style for the search results */
    #results {
      margin-top: 20px;
    }

    #results table {
      width: 80%;
      margin: auto;
      border-collapse: collapse;
    }

    #results th,
    #results td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    #results th {
      background-color: #10222e;
      color: #fff;
    }

    #results tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    /* start of style rules for h3 tag */
    h3 {
      color: #10222E;
      font-size: 24pt;
      text-align: center;
    }

    /* end of style rules for h3 tag */
    .dropdown {
      width: 30%;
    }
  </style>

  <script>
    function checkAttendance(courseId) {
      $.ajax({
        type: 'POST',
        url: 'check_attendance.php',
        data: {
          courseId: courseId
        },
        success: function (response) {
          $('#status_' + courseId).html('Status: ' + response);
        },
        error: function () {
          alert('Error checking attendance.');
        }
      });
    }

    function checkAllAttendances() {
      <?php
      if ($course_array) {
        foreach ($course_array as $row) {
          echo "checkAttendance({$row['courseId']});\n";
        }
      }
      ?>
    }

    $(document).ready(function () {
      checkAllAttendances();
    });
  </script>

</head>

<body>
  <ul> <!-- start of ul for menu bar -->
    <!-- list home.php link -->
    <li><a class="link" href="professorHome.php">Home</a></li>
    <!-- list schedule.php link -->
    <li><a class="link" href="professorSchedule.php">Schedule</a></li>
    <!-- list analytics.php link -->
    <li><a class="link" href="professorAnalytics.php">Analytics</a></li>
    <!-- list Touch & Go logo -->
    <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
    <!-- list contact.php link -->
    <li><a class='link' href="professorContact.php">Contact</a></li>
    <!-- list help.php link -->
    <li><a class='link' href="professorHelp.php">Help</a></li>
    <!-- list logout.php link -->
    <li><a class='link' href="logout.php">Logout</a></li>
  </ul> <!-- end of ul for menu bar -->

  <h1>Analytics</h1>

  <section class="dropdown-section">
    <h3>Student Check-In Details</h3>
    <div class="dropdown">
      <?php
      if ($student_checkIn_array) {
        $currentStudent = null;
        $currentCourse = null;

        foreach ($student_checkIn_array as $row) {
          $studentFullName = $row['studentFirstName'] . ' ' . $row['studentLastName'];
          $courseName = $row['courseName'];

          if ($currentStudent !== $studentFullName || $currentCourse !== $courseName) {
            if ($currentStudent !== null && $currentCourse !== null) {
              echo '</div>';
            }

            echo '<div class="question">
                                <span class="arrow"></span>
                                <span>' . $courseName . ' - ' . $studentFullName . '</span>
                            </div>
                            <div class="answer">';
            $currentStudent = $studentFullName;
            $currentCourse = $courseName;
          }

          // Convert the database datetime string to a DateTime object
          $checkInDateTime = new DateTime($row['firstCheckInTime']);

          // Format the date and time
          $formattedDateTime = $checkInDateTime->format('l, F j, Y g:i A');

          echo '<p>Check-In Time: ' . $formattedDateTime . '</p>';
          // You can add other details here
        }

        echo '</div>';
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No student check-in details found...</span>';
      }
      ?>
    </div>
  </section>
  <script>
    const question = document.querySelectorAll('.question');
    const answer = document.querySelectorAll('.answer');
    const arrow = document.querySelectorAll('.arrow');

    for (let i = 0; i < question.length; i++) {
      question[i].addEventListener('click', () => {
        answer[i].classList.toggle('answer-opened');
        arrow[i].classList.toggle('arrow-rotated');
      });
    }
  </script>
</body>

</html>