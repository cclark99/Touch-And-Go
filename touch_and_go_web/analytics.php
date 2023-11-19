<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include other necessary files and HTML structure

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_course.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Assuming you have a form field named 'courseId'
  $courseId = $_POST['courseId'] ?? null;

  // Assuming you have the student's userId stored in the session
  $userId = $_SESSION['userId'] ?? null;

  // Check if the student has already checked in for today's class
  $checkInQuery = "SELECT f.checkIn, c.startTime, c.endTime
                   FROM fingerprint f
                   JOIN course c ON f.checkIn BETWEEN CONCAT(CURDATE(), ' ', c.startTime) AND CONCAT(CURDATE(), ' ', c.endTime)
                   WHERE f.userId = ? AND c.courseId = ?";

  // Check if the connection is open before preparing the statement
  if (!$con->connect_error) {
    $checkInStmt = $con->prepare($checkInQuery);

    if ($checkInStmt) {
      $checkInStmt->bind_param('ii', $userId, $courseId);
      $checkInStmt->execute();
      $checkInStmt->bind_result($checkIn, $startTime, $endTime);
      $checkInStmt->fetch();
      $checkInStmt->close();

      if ($checkIn) {
        echo "You checked in at: $checkIn during the class from $startTime to $endTime.";
      } else {
        echo "No check-in records found for the specified class.";
      }
    } else {
      echo "Failed to prepare the statement.";
    }
  } else {
    echo "Database connection error.";
  }
}

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

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
    <!-- display Today's Attendance -->
    <h3>Today's Attendance</h3>

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
            <!-- display answer to first question -->
            <p>Status: </p>
          </div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes found...</span>';
      }
      ?>
    </div> <!-- end of ul tag -->
  </section> <!-- end of section tag -->

  <section class="dropdown-section">
    <h3>Check-In</h3>
    <div class="dropdown">
      <form method="post" action="analytics.php">
        <select name="courseId">
          <?php
          if ($course_array) {
            foreach ($course_array as $row) {
              echo "<option value='{$row['courseId']}'>{$row['name']}</option>";
            }
          } else {
            echo '<option value="">No courses found...</option>';
          }
          ?>
        </select>
        <input type="submit" value="Check-In">
      </form>
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
          <!-- display answer to first question -->
          <p>Present: <br>
             Late: <br>
             You have attended % of classes this semester.
          </p>
        </div>';
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