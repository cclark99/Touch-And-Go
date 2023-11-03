



<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->
  <head> <!-- start of head tag -->
    <!-- set charset -->
    <meta charset="utf-8">
    <!-- set title -->
    <title>Contact</title>
    <!-- link external style.css sheet -->
    <link rel = "stylesheet" type = "text/css" href = "../styles.css">
    
    <!-- start of style tag -->
    <style>
      /* start of style rules for h3 tag */
      h3 {
        color: #10222E; /* make color blue */
        font-size: 24pt; /* make font size 24 pt */
        text-align: center; /* center align text */
        /*margin-top: 5%; /* make margin-top 5% */
       } /* end of style rules for h3 tag */
       
       /* start of class style rules for dropdown */
       .dropdown {
           width: 25%; /* make width 25% */
        } /* end of class style rules for dropdown */
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
  
    <!-- contact header -->
    <h1>Contact</h1>
    <!-- display Professor Contact Information: -->
    <h3>Professor Contact Information:</h3>

    <!-- The following code was created on October 16, 2023, using 
    information from the following link:
    https://www.youtube.com/watch?v=bwe-PsEoot4 */ -->

    <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->

      <ul class="dropdown"> <!-- start of ul tag with dropwdown class -->
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display first professor -->
            <span>Professor Name</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display professor information -->
            <p>Email: <a class="link" href="mailto:professorname@live.kutztown.edu">professorname@live.kutztown.edu</a><br>
              Phone: 610-111-1111<br>
              Office Hours:<br>
              - M/W: 4:30 - 5:00 PM<br>
              - T/TH: 1:00 - 3:00 PM<br>
            </p>
          </div> <!-- end of div tag -->

        
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display second professor -->
            <span>Professor Name</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display professor information -->
            <p>Email: <a class="link" href="mailto:professorname@live.kutztown.edu">professorname@live.kutztown.edu</a><br>
              Phone: 610-111-1111<br>
              Office Hours:<br>
              - M/W: 4:30 - 5:00 PM<br>
              - T/TH: 1:00 - 3:00 PM<br>
            </p>
          </div> <!-- end of div tag -->
       

        
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display third professor -->
            <span>Professor Name</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display professor information -->
            <p>Email: <a class="link" href="mailto:professorname@live.kutztown.edu">professorname@live.kutztown.edu</a><br>
              Phone: 610-111-1111<br>
              Office Hours:<br>
              - M/W: 4:30 - 5:00 PM<br>
              - T/TH: 1:00 - 3:00 PM<br>
            </p>
          </div> <!-- end of div tag -->
        

       
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display fourth professor -->
            <span>Professor Name</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display professor information -->
            <p>Email: <a class="link" href="mailto:professorname@live.kutztown.edu">professorname@live.kutztown.edu</a><br>
              Phone: 610-111-1111<br>
              Office Hours:<br>
              - M/W: 4:30 - 5:00 PM<br>
              - T/TH: 1:00 - 3:00 PM<br>
            </p>
          </div> <!-- end of div tag -->
       

      
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display fifth professor -->
            <span>Professor Name</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display professor information -->
            <p>Email: <a class="link" href="mailto:professorname@live.kutztown.edu">professorname@live.kutztown.edu</a><br>
              Phone: 610-111-1111<br>
              Office Hours:<br>
              - M/W: 4:30 - 5:00 PM<br>
              - T/TH: 1:00 - 3:00 PM<br>
            </p>
          </div> <!-- end of div tag -->
       
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