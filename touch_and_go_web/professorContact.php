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

    /* .dropdown-section {
      width: 50%;
      margin: auto;
    }

    .dropdown {
      list-style-type: none;
      padding: 0;
      cursor: pointer;
    }

    .question,
    .answer {
      display: none;
    }

    .answer-opened {
      display: block;
    }

    .arrow {
      display: inline-block;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 5px 5px 0;
      border-color: #4CAF50 transparent transparent transparent;
    }

    .arrow-rotated {
      transform: rotate(180deg);
    } */

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

  <section class="dropdown-section">

    <?php
    $printedCourseIds = array();

    if ($course_array) {
      echo '<ul class="dropdown">';

      foreach ($course_array as $row) {
        $courseId = $row['courseId'];

        if (!in_array($courseId, $printedCourseIds)) {
          echo '<li class="question">
                  <span class="arrow"></span>
                  <span>' . $row['className'] . '</span>
                </li>
                <li class="answer">
                  <ul>'; // Open a nested list for answers
    
          $printedCourseIds[] = $courseId;
        }

        echo '<li class="answer">
                <p>Student: ' . $row['firstName'] . ' ' . $row['lastName'] . '<br>
                   Email: <a class="link" href="mailto:' . $row['userEmail'] . '">' . $row['userEmail'] . '</a>
                </p>
              </li>';
      }

      echo '</ul>'; // Close the nested list
      echo '</li>'; // Close the answer list item
      echo '</ul>'; // Close the main dropdown list
    } else {
      echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No student information found. </span>';
    }
    ?>
  </section>

  <script>
    const questions = document.querySelectorAll('.question');

    console.log(questions);

    for (let i = 0; i < questions.length; i++) {
      questions[i].addEventListener('click', () => {
        const answers = questions[i].nextElementSibling.querySelectorAll('.answer');
        answers.forEach(answer => answer.classList.toggle('answer-opened'));
        questions[i].querySelector('.arrow').classList.toggle('arrow-rotated');
      });
    }
  </script>
</body>

</html>