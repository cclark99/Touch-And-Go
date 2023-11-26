<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] != 'professor') {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_professor_contact.php';

?>

<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
  <!-- set charset -->
  <meta charset="utf-8">
  <!-- set title -->
  <title>Contact</title>
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
      /*margin-top: 5%; /* make margin-top 5% */
    }

    /* end of style rules for h3 tag */

    /* start of class style rules for dropdown */
    .dropdown {
      width: 25%;
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

  <!-- this ends the code that was created using information from the 
    following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

  <!-- contact header -->
  <h1>Contact</h1>
  <!-- display Professor Contact Information: -->
  <h3>Professor Contact Information:</h3>

  <!-- The following code was created on October 16, 2023, using 
    information from the following link:
    https://www.youtube.com/watch?v=bwe-PsEoot4 */ -->

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->

    <ul class="dropdown"> <!-- start of ul tag with dropdown class -->
      <?php
      $printedCourseIds = array(); // Initialize an array to keep track of printed course IDs
      
      if ($course_array) {
        foreach ($course_array as $row) {
          $courseId = $row['courseId'];

          // Check if the course ID has already been printed
          if (!in_array($courseId, $printedCourseIds)) {
            echo '<div class="question"> <!-- start of div tag with question class -->
                    <!-- create arrow -->
                    <span class="arrow"></span>
                    <!-- display course information -->
                    <span>' . $row['className'] . '</span>
                  </div> <!-- end of div tag -->';

            // Add the course ID to the list of printed IDs
            $printedCourseIds[] = $courseId;
          }

          // Display student information for the course
          echo '<div class="answer"> <!-- start of div tag with answer class -->
                <!-- display student information -->
                <p>Student: ' . $row['firstName'] . ' ' . $row['lastName'] . '<br>
                   Email: <a class="link" href="mailto:' . $row['userEmail'] . '">' . $row['userEmail'] . '</a>
                </p>
              </div><!-- end of div tag -->';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No student information found. </span>';
      }
      ?>
    </ul> <!-- end of ul tag -->
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