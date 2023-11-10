<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_course.php';

?>

<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
  <!-- set charset -->
  <meta charset="utf-8">
  <!-- set title -->
  <title>Schedule</title>
  <!-- link external style.css sheet -->
  <link rel="stylesheet" type="text/css" href="../styles.css">

  <!-- start of style tag -->
  <style>
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
  </style> <!-- end of style tag -->
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

  <!-- schedule header -->
  <h1>Schedule</h1>

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
    <!-- display Today's Schedule -->
    <h3>Today's Schedule</h3>

    <div class="dropdown"> <!-- start of ul tag with dropdown class -->

      <?php
      if ($course_array) {
        foreach ($course_array as $row) {
          echo '<div class="question"> <!-- start of div tag with question class -->
          <!-- create arrow -->
          <span class="arrow"></span>
          <!-- display first question -->
          <span>' . $row['courseName'] . '</span>
        </div> <!-- end of div tag -->
        <div class="answer"> <!-- start of div tag with answer class -->
          <!-- display answer to first question -->
          <p>Time: ' . date('g:i A', strtotime($row['courseStartTime'])) . ' - ' . date('g:i A', strtotime($row['courseEndTime'])) . '<br>
            Professor: '. $row['professorLastName']  .' <br>
            Location: ' . $row['courseLocation'] . ' <br>
          </p>
        </div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes today </span>';
      }

      ?>
    </div> <!-- end of ul tag -->
  </section> <!-- end of section tag -->

  <hr>

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->

    <!-- display Semester Schedule -->
    <h3>Semester Schedule</h3>

    <div class="dropdown"> <!-- start of ul tag with dropdown class -->

      <?php
      if ($course_array) {
        foreach ($course_array as $row) {
          echo '<div class="question"> <!-- start of div tag with question class -->
          <!-- create arrow -->
          <span class="arrow"></span>
          <!-- display first question -->
          <span>' . $row['courseName'] . '</span>
        </div> <!-- end of div tag -->
        <div class="answer"> <!-- start of div tag with answer class -->
          <!-- display answer to first question -->
          <p>Time: ' . date('g:i A', strtotime($row['courseStartTime'])) . ' - ' . date('g:i A', strtotime($row['courseEndTime'])) . '<br>
            Professor: ' . $row['professorLastName'] . '<br>
            Location: ' . $row['courseLocation'] . ' <br>
          </p>
        </div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes found...</span>';
      }

      ?>

    </div> <!-- end of ul tag -->
  </section> <!-- end of section tag -->


  <!-- start of script tag -->
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
  </script> <!-- end of script tag -->
  <!-- this ends the code that was created using information from the 
    following link:
    https://www.youtube.com/watch?v=bwe-PsEoot4 -->
</body> <!-- end of body tag -->

</html> <!-- end of html tag -->