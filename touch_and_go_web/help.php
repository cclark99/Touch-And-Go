<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
  <!-- set charset -->
  <meta charset="utf-8">
  <!-- set title -->
  <title>Help</title>
  <!-- link external style.css sheet -->
  <link rel="stylesheet" type="text/css" href="../styles.css">

  <!-- start of style tag -->
  <style>
      /* start of style rules for h3 tag */
      h3 {
        color: #10222E; /* make color blue */
        font-size: 24pt; /* make font size 24 pt */
        text-align: center; /* center align text */
        margin-top: 5%; /* make margin-top 5% */
       } /* end of style rules for h3 tag */
    </style> <!-- end of style tag -->

  <table> <!-- start of table tag -->
    <thead> <!-- start of thead tag -->
      <tr> <!-- start of row -->

        <th> <!-- start of Home cell -->
          <h2><a class='link' href="home.php">Home</a></h2>
        </th> <!-- end of Home cell -->

        <th> <!-- start of Schedule cell -->
          <h2><a class='link' href="schedule.php">Schedule</a></h2>
        </th> <!-- end of Schedule cell -->

        <th> <!-- start of Analytics cell -->
          <h2><a class='link' href="analytics.php">Analytics</a></h2>
        </th> <!-- end of Analytics cell -->

        <th> <!-- start of Logo cell -->
          <img src="../Touch__Go_Logo.jpg" alt="Touch and Go Logo" class="center" height="90">
        </th><!-- end of Logo cell -->

        <th> <!-- start of Contact cell -->
          <h2><a class='link' href="contact.php">Contact</a></h2>
        </th> <!-- end of Contact cell -->

        <th> <!-- start of Help cell -->
          <h2><a class='link' href="help.php">Help</a></h2>
        </th> <!-- end of Help cell -->

        <th> <!-- start of Logout cell -->
          <h2><a class='link' href="logout.php">Logout</a></h2>
        </th> <!-- end of Logout cell -->

      </tr> <!-- end of row -->
    </thead> <!-- end of thead tag -->
  </table> <!-- end of table tag -->
  <!-- help header -->
  <h1>Help</h1>
</head> <!-- end of head tag -->
  
  <body> <!-- start of body tag -->
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
      <!-- FAQ header -->
      <h3>Frequently Asked Questions</h3>
      <!-- horizintal line -->
      <hr>

      <ul class="dropdown"> <!-- start of ul tag with dropdown class -->
        <li> <!-- start of li (first question) -->
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
        </li> <!-- end of li tag -->

        <li> <!-- start of li (second question) -->
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
        </li> <!-- end of li tag -->

        <li> <!-- start of li (third question) -->
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
        </li> <!-- end of li tag -->
      </ul> <!-- end of ul tag -->
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