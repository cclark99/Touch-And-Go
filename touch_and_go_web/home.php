<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';

// Get user's name based on what account type they are, as well as userId

if ($_SESSON['userType'] === 'student')
{
  echo'<h3>STUDENT</h3>';
}

switch (true) {
  case $_SESSION['userType'] === 'student':
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if (
      $stmt = $con->prepare('SELECT user.userId, 
                                      firstName, 
                                      lastName 
                              FROM student 
                                inner join user on user.userId = student.userId
                              WHERE userEmail = ?')
    ) {
      $stmt->bind_param('s', $_SESSION['email']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName']);
        $stmt->fetch();
      }
      $stmt->close();
    }
    break;

    case $_SESSION['userType'] === 'professor':
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT firstName, lastName FROM professor WHERE userEmail = ?')) {
      $stmt->bind_param('s', $_SESSION['email']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($_SESSION['firstName'], $_SESSION['lastName']);
        $stmt->fetch();
      }
      $stmt->close();
    }
    break;

    case $_SESSION['userType'] === 'admin':
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT firstName, lastName FROM admin WHERE userEmail = ?')) {
      $stmt->bind_param('s', $_SESSION['email']);
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

  <?php echo '<h3>'. $_SESSION['email'] . $_SESSION['userId'] . $_SESSION['lastName'] . '</h3>'?>

  <!-- display hello message with student's name -->
  <h3>Hello
    <?php echo $_SESSION['userId'] . ' ' . $_SESSION['lastName'] ?>
  </h3>

  <!-- display today is (day of the week, month, day, and year)-->
  <div id="output"></div>
  <!-- display percentage of attended classes of today -->
  <div>You have attended __% of your classes today.</div>
  <!-- display percentage of attended classes of the semester -->
  <div>You have attended __% of you classes this semester.</div>

  <script>
    // set variables
    var d = new Date();
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var dayOfWeek = d.getDay();
    var month = d.getMonth();
    var day = d.getDate();
    var year = d.getFullYear();

    // switch statement to find the day of the week
    switch (dayOfWeek) {
      case 0:
        dayOfWeek = "Today is Sunday ";
        break;
      case 1:
        dayOfWeek = "Today is Monday ";
        break;
      case 2:
        dayOfWeek = "Today is Tuesday ";
        break;
      case 3:
        dayOfWeek = "Today is Wednesday ";
        break;
      case 4:
        dayOfWeek = "Today is Thursday ";
        break;
      case 5:
        dayOfWeek = "Today is Friday ";
        break;
      case 6:
        dayOfWeek = "Today is Saturday ";
        break;
    }

    // display the day of the week, month, day, and year of the current day
    output.innerHTML = dayOfWeek + monthNames[month] + " " + day + ", " + year;

  </script> <!-- end of script tag -->
</body> <!-- end of body tag -->

</html> <!-- end of html tag -->