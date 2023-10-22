<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
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
    <link rel = "stylesheet" type = "text/css" href = "../styles.css">

    <!-- start of style tag -->
    <style>
      /* start of style rules for h3 tag */
      h3 {
        color: #10222E; /* make color blue */
        font-size: 24pt; /* make font size 24 pt */
        text-align: center; /* center align text */
        margin-top: 5%; /* make margin-top 5% */
       } /* end of style rules for h3 tag */
       
      /* start of style rules for div tag */
      div{
        background-color: #10222E; /* make background-color blue */
        color: #FAF8D6; /* make color yellow */
        text-align: center; /* center align text */
        font-size: 20pt; /* make font size 20pt */
        padding: 3%; /* make padding 3% */
        width: 40%; /* make width 40% */
        margin: 2% auto; /* make margin 2% auto to center */
      } /* end of style rules for div tag */
    </style> <!-- end of style tag -->
    
    <table> <!-- start of table tag -->
      <thead> <!-- start of thead tag -->
        <tr> <!-- start of row -->
            
          <th> <!-- start of Home cell -->
            <h2><a class='link' href = "home.php">Home</h2>
          </th> <!-- end of Home cell -->
            
          <th> <!-- start of Schedule cell -->
            <h2><a class='link' href = "schedule.php">Schedule</h2>
          </th> <!-- end of Schedule cell -->
            
          <th> <!-- start of Analytics cell -->
            <h2><a class='link' href = "analytics.php">Analytics</h2>
          </th> <!-- end of Analytics cell -->
            
          <th> <!-- start of Logo cell -->
            <img src="../Touch__Go_Logo.jpg" alt="Touch and Go Logo" class="center" height="90">
          </th><!-- end of Logo cell -->
            
          <th> <!-- start of Contact cell -->
            <h2><a class='link' href = "contact.php">Contact</h2>
          </th> <!-- end of Contact cell -->
            
          <th> <!-- start of Help cell -->
            <h2><a class='link' href = "help.php">Help</h2>
          </th> <!-- end of Help cell -->
            
          <th> <!-- start of Logout cell -->
            <h2><a class='link' href = "logout.php">Logout</h2>
          </th> <!-- end of Logout cell -->
         
        </tr> <!-- end of row -->
      </thead> <!-- end of thead tag -->
    </table> <!-- end of table tag -->

  </head> <!-- end of head tag -->
  
  <body> <!-- start of body tag -->
    <!-- home header -->
    <h1>Home</h1>
    <!-- display hello message with student's name -->
    <h3>Hello <?php $_SESSION['email'] ?> !</h3>
    
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
      switch(dayOfWeek){
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
          dayOfWeek = "Today is Friday " ;
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
