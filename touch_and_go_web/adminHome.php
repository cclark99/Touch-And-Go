<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] !== 'admin') {
  include 'logout.php';
  exit();
}

require 'db_connection.php';

// Get user's name based on what account type they are, as well as userId

switch (true) {
  case $_SESSION['userType'] == 'student':
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
      $stmt->bind_param('s', $_SESSION['email']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['userId']);
        $stmt->fetch();
      }
      $stmt->close();
    }

    if ($stmt = $con->prepare('SELECT firstName, lastName FROM student WHERE userId = ?')) {
      $stmt->bind_param('i', $_SESSION['userId']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
        $stmt->fetch();
      }
      $stmt->close();
    }
    break;

  case $_SESSION['userType'] == 'professor':
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
      $stmt->bind_param('s', $_SESSION['email']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['userId']);
        $stmt->fetch();
      }
      $stmt->close();
    }

    if ($stmt = $con->prepare('SELECT firstName, lastName FROM professor WHERE userId = ?')) {
      $stmt->bind_param('i', $_SESSION['userId']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
        $stmt->fetch();
      }
      $stmt->close();
    }

    break;

  case $_SESSION['userType'] == 'admin':
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT userId FROM user WHERE userEmail = ?')) {
      $stmt->bind_param('s', $_SESSION['email']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['userId']);
        $stmt->fetch();
      }
      $stmt->close();
    }

    if ($stmt = $con->prepare('SELECT firstName, lastName FROM admin WHERE userId = ?')) {
      $stmt->bind_param('i', $_SESSION['userId']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
        $stmt->fetch();
      }
      $stmt->close();
    }

    break;
  default:
    include 'logout.php';
    break;
}

?>
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
  <!-- set charset -->
  <meta charset="utf-8">
  <!-- set title -->
  <title>Home</title>
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
      margin-top: 5%;
      /* make margin-top 5% */
    }

    /* end of style rules for h3 tag */

    /* start of style rules for div tag */
    div {
      background-color: #10222E;
      /* make background-color blue */
      color: #FAF8D6;
      /* make color yellow */
      text-align: center;
      /* center align text */
      font-size: 20pt;
      /* make font size 20pt */
      padding: 3%;
      /* make padding 3% */
      width: 40%;
      /* make width 40% */
      margin: 2% auto;
      /* make margin 2% auto to center */
    }

    /* end of style rules for div tag */
  </style> <!-- end of style tag -->

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

  <!-- home header -->
  <h1>Home</h1>