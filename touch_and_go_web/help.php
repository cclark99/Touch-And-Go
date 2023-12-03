<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->
  <head> <!-- start of head tag -->
    <!-- set charset -->
    <meta charset="utf-8">
    <!-- set title -->
    <title>Help</title>
    <!-- link external style.css sheet -->
    <link rel = "stylesheet" type = "text/css" href = "../styles.css">
    
    <script>
    function confirmLogout() {
      // Show a confirmation dialog
      var result = confirm("Are you sure you want to logout?");

      // If the user clicks "OK," proceed with the logout
      if (result) {
        window.location.href = "logout.php";
      }
      // If the user clicks "Cancel," do nothing
    }
  </script>

    <!-- start of style tag -->
    <style>
      /* start of style rules for h3 tag */
      h3 {
        color: #10222E; /* make color blue */
        font-size: 24pt; /* make font size 24 pt */
        text-align: center; /* center align text */
        /*margin-top: 5%; /* make margin-top 5% */
       } /* end of style rules for h3 tag */
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
      <li><a class='link' href="#" onclick="confirmLogout()">Logout</a></li>
    </ul> <!-- end of ul for menu bar -->
   
    <!-- this ends the code that was created using information from the 
    following link:
    https://www.w3schools.com/css/css_navbar_horizontal.asp -->

    <!-- help header -->
    <h1>Help</h1>
  
    <!-- output "Issues with the site?"" -->
    <h2>Issues with the site?</h2>
    <!-- "Contact us at:"" -->
    <h2>Contact us at:</h2>
    <!-- output "Email: touchandgo@kutztown.edu" as a link to automatically bring up default email -->
    <h2>Email: <a class="link" href="mailto:touchandgo@kutztown.edu">touchandgo@kutztown.edu</a></h2>
    <!-- output "Phone: 610-111-1111" -->
    <h2>Phone: 610-111-1111</h2>

    <!-- The following code was created on October 16, 2023, using 
   information from the following link:
   https://www.youtube.com/watch?v=bwe-PsEoot4 -->

    <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
      <!-- horizintal line -->
      <hr>
      <!-- FAQ header -->
      <h3>Frequently Asked Questions</h3>

      <div class="dropdown"> <!-- start of ul tag with dropdown class -->
       
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display first question -->
            <span>My attendance is incorrect on the Touch & Go website, who should I contact?</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to first question -->
            <p>We suggest contacting your professor first. If your professor has you marked as present on the specific day, please contact us via email or phone to resolve the problem.</p>
          </div> <!-- end of div tag -->
       

        
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display second question -->
            <span>When will Touch & Go respond to me regarding my email or phone call?</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to second question -->
            <p>We will do our best to respond to all emails and phone calls within 2 business days.</p>
          </div> <!-- end of div tag -->
        

        
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display third question -->
            <span>Why are all of my classes not showing up on my schedule?</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to third question -->
            <p>Each student's schedule will be posted one week before the start of the semester. If your schedule is not visible to you by this time, please reach out to us via email or phone.</p>
          </div> <!-- end of div tag -->
        
        </div> <!-- end of ul tag -->
    </section> <!-- end of section tag -->

    <!-- start of script tag -->
    <script>
      // set variables
      const question = document.querySelectorAll('.question');
      const answer = document.querySelectorAll('.answer');
      const arrow = document.querySelectorAll('.arrow');
  
      // for loop to open the answer to the question
      for(let i = 0; i < question.length; i++){
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