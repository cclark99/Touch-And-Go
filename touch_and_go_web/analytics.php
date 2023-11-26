<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_course.php';
include 'get_weekday_course.php';

?>
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
  <!-- set charset -->
  <meta charset="utf-8">
  <!-- set title -->
  <title>Analytics</title>
  <!-- link external style.css sheet -->
  <link rel="stylesheet" type="text/css" href="../styles.css">

  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <style>
    form {
      padding: 20px;
      margin: auto;
      border: 1px solid #eee;
      background: #f7f7f7;
      display: grid;
      align-content: center;
    }

    input {
      display: block;
      padding: 10px;
    }

    input[type=text] {
      border: 1px solid #ddd;
    }

    input[type=submit] {
      margin-top: 20px;
      border: 0;
      color: #fff;
      background: #10222e;
      cursor: pointer;
    }

    #results div {
      padding: 10px;
      border: 1px solid #eee;
      background: #f7f7f7;
      width: 60%;
      margin: auto;
    }

    #results div:nth-child(even) {
      background: #fff;
    }

    .searchBox {
      width: 50%;
      margin: auto;
    }

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
      /* make color blue */
      font-size: 24pt;
      /* make font size 24 pt */
      text-align: center;
      /* center align text */
      /*margin-top: 2%; /* make margin-top 2% */
    }

    /* end of style rules for h3 tag */
    .dropdown {
      width: 30%;
      /* make width 25% */
    }

    /* end of class style rules for dropdown */
  </style>

  <script>
    // Function to check attendance status
    function checkAttendance(courseId) {
      // Make an AJAX request to the server
      $.ajax({
        type: 'POST',
        url: 'check_attendance.php',
        data: {
          courseId: courseId
        },
        success: function (response) {
          // Update the status in the HTML
          $('#status_' + courseId).html('Status: ' + response);
        },
        error: function () {
          // Handle errors if needed
          alert('Error checking attendance.');
        }
      });
    }

    // Function to check attendance for all courses
    function checkAllAttendances() {
      <?php
      if ($course_array) {
        foreach ($course_array as $row) {
          echo "checkAttendance({$row['courseId']});\n";
        }
      }
      ?>
    }

    // Call the function when the page is loaded
    $(document).ready(function () {
      checkAllAttendances();
    });
  </script>

</head> <!-- end of head tag -->

<body> <!-- start of body tag -->
  <!-- The following code was created on October 30, 2023, using 
    information from the following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

  <ul> <!-- start of ul for menu bar -->
    <!-- list home.php link -->
    <li><a class="link" href="home.php">Home</a></li>
    <!-- list schedule.php link -->
    <li><a class="link" href="schedule.php">Schedule</a></li>
    <!-- list analytics.php link -->
    <li><a class="link" href="analytics.php">Analytics</a></li>
    <!-- list Touch & Go logo -->
    <li><img src="../newLogo.png" alt="Touch and Go Logo" height="60"></li>
    <!-- list contact.php link -->
    <li><a class='link' href="contact.php">Contact</a></li>
    <!-- list help.php link -->
    <li><a class='link' href="help.php">Help</a></li>
    <!-- list logout.php link -->
    <li><a class='link' href="logout.php">Logout</a></li>
  </ul> <!-- end of ul for menu bar -->

  <!-- this ends the code that was created using information from the 
    following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

  <!-- analytics header -->
  <h1>Analytics</h1>

  <!-- Today's Attendance section -->
  <section class="dropdown-section">
    <h3>Today's Attendance</h3>
    <div class="dropdown">
      <?php
      if ($todayCourse_array) {
        foreach ($todayCourse_array as $row) {
          echo '<div class="question">
                  <span class="arrow"></span>
                  <span>' . $row['name'] . '</span>
                </div>
                <div class="answer">
                  <p id="status_' . $row['courseId'] . '">Status: Loading...</p>
                </div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes today.</span>';
      }
      ?>
    </div>
  </section>

  <hr>

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
    <!-- display Total Semester Attendance -->
    <h3>Total Semester Attendance</h3>

    <div class="dropdown"> <!-- start of ul tag with dropdown class -->
      <?php

      if ($course_array) {
        foreach ($course_array as $row) {
          echo '<div class="question"> <!-- start of div tag with question class -->
                <!-- create arrow -->
                <span class="arrow"></span>
                <!-- display first question -->
                <span>' . $row['name'] . '</span>
              </div> <!-- end of div tag -->
              <div class="answer"> <!-- start of div tag with answer class -->
                <!-- display answer to the first question -->
                <p>';

          // Get the days of the week the class meets
          $daysOfWeekString = $row['daysOfWeek'];
          $meetingDayCounts = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);

          // Generate an array of dates within the range of startDate and endDate
          $startDate = new DateTime($row['startDate']);
          $endDate = new DateTime($row['endDate']);
          $interval = new DateInterval('P1D'); // 1 day interval
          $dateRange = new DatePeriod($startDate, $interval, $endDate);

          // Count the occurrences of each day of the week
          foreach ($dateRange as $date) {
            $dayOfWeek = $date->format('l'); // Get the day of the week (e.g., 'Monday')
      
            // Check if the day of the week exists in the string
            if (strpos($daysOfWeekString, $dayOfWeek) !== false) {
              $meetingDayCounts[$dayOfWeek]++;
            }
          }

          // Calculate and print the total meeting times for the entire week
          $totalMeetingTimes = array_sum($meetingDayCounts);
          echo "Total meeting times for the week: $totalMeetingTimes times<br>";

          echo '</p></div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes found...</span>';
      }
      ?>

      <script>
        // set variables
        const question = document.querySelectorAll('.question');
        const answer = document.querySelectorAll('.answer');
        const arrow = document.querySelectorAll('.arrow');

        // for loop to open the answer to the question
        for (let i = 0; i < question.length; i++) {
          question[i].addEventListener('click', () => {
            answer[i].classList.toggle('answer-opened');
            arrow[i].classList.toggle('arrow-rotated');
          });
        } // end of for loop
      </script>
</body> <!-- end of body tag -->

</html> <!-- end of html tag -->