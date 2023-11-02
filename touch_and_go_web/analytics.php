<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.html');
  exit();
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'test';
$DATABASE_PASS = 'test123';
$DATABASE_NAME = 'touch_and_go_test';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error.
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
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
</head> <!-- end of head tag -->
<table> <!-- start of table tag -->
  <thead> <!-- start of thead tag -->
    <tr> <!-- start of row -->

      <th> <!-- start of Home cell -->
        <h2><a class='link' href="home.php">Home</h2>
      </th> <!-- end of Home cell -->

      <th> <!-- start of Schedule cell -->
        <h2><a class='link' href="schedule.php">Schedule</h2>
      </th> <!-- end of Schedule cell -->

      <th> <!-- start of Analytics cell -->
        <h2><a class='link' href="analytics.php">Analytics</h2>
      </th> <!-- end of Analytics cell -->

      <th> <!-- start of Logo cell -->
        <img src="../Touch__Go_Logo.jpg" alt="Touch and Go Logo" class="center" height="90">
      </th><!-- end of Logo cell -->

      <th> <!-- start of Contact cell -->
        <h2><a class='link' href="contact.php">Contact</h2>
      </th> <!-- end of Contact cell -->

      <th> <!-- start of Help cell -->
        <h2><a class='link' href="help.php">Help</h2>
      </th> <!-- end of Help cell -->

      <th> <!-- start of Logout cell -->
        <h2><a class='link' href="logout.php">Logout</h2>
      </th> <!-- end of Logout cell -->

    </tr> <!-- end of row -->
  </thead> <!-- end of thead tag -->
</table> <!-- end of table tag -->
<!-- analytics header -->
<h1>Analytics</h1>


<body> <!-- start of body tag -->

  <!-- SEARCH FORM -->
  <form method="post" action="2-form.php">
    <input type="text" name="search" placeholder="Search..." required>
    <input type="submit" value="Search">
  </form>

  <?php
  // (PROCESS SEARCH WHEN FORM SUBMITTED
  if (isset($_POST["search"])) {
    // SEARCH FOR USERS
    require "3-search.php";

    // (B2) DISPLAY RESULTS
    if (count($results) > 0) {
      foreach ($results as $r) {
        printf("<div>%s - %s</div>", $r["name"], $r["email"]);
      }
    } else {
      echo "No results found";
    }
  }
  ?>

</body> <!-- end of body tag -->

</html> <!-- end of html tag -->