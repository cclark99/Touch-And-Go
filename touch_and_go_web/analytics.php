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

  <style>
    form {
      padding: 20px;
      margin: auto;
      border: 1px solid #eee;
      background: #f7f7f7;
      display: grid;
      align-content: center;
    }

    input {
      display: block;
      padding: 10px;
    }

    input[type=text] {
      border: 1px solid #ddd;
    }

    input[type=submit] {
      margin-top: 20px;
      border: 0;
      color: #fff;
      background: #10222e;
      cursor: pointer;
    }

    #results div {
      padding: 10px;
      border: 1px solid #eee;
      background: #f7f7f7;
      width: 60%;
      margin: auto;
    }

    #results div:nth-child(even) {
      background: #fff;
    }
    .searchBox {
      width: 50%;
      margin: auto;
    }

     /* start of style rules for h3 tag */
     h3 {
        color: #10222E; /* make color blue */
        font-size: 24pt; /* make font size 24 pt */
        text-align: center; /* center align text */
        /*margin-top: 2%; /* make margin-top 2% */
       } /* end of style rules for h3 tag */
       .dropdown {
           width: 30%; /* make width 25% */
        } /* end of class style rules for dropdown */
  </style>

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


<!-- analytics header -->
<h1>Analytics</h1>


  <div class="searchBox">
    <form id="form" onsubmit="return asearch();">
      <input type="text" name="search" placeholder="Search..." required>
      <input type="submit" value="Search">
    </form>

    <!-- (B) SEARCH RESULTS -->
    <div id="results"></div>
  </div>

    <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
      <!-- display Today's Attendance -->
      <h3>Today's Attendance</h3>

      <div class="dropdown"> <!-- start of ul tag with dropdown class -->
       
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display first question -->
            <span>CSC 341 Introduction to Information Security</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to first question -->
            <p>Status: Present</p>
          </div> <!-- end of div tag -->
        
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display second question -->
            <span>CSC 256 SQL Programming</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to second question -->
            <p>Status: Late</p>
          </div> <!-- end of div tag -->

          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display third question -->
            <span>CSC 355 Software Engineering II</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to third question -->
            <p>Status: Awaiting Attendance</p>
          </div> <!-- end of div tag -->

          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display third question -->
            <span>CSC 242 Server-Side Web Development</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to third question -->
            <p>Status: Awaiting Attendance</p>
          </div> <!-- end of div tag -->
        </div> <!-- end of ul tag -->
    </section> <!-- end of section tag -->

    <hr>

    <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
      <!-- display Total Semester Attendance -->
      <h3>Total Semester Attendance</h3>

      <div class="dropdown"> <!-- start of ul tag with dropdown class -->
       
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display first question -->
            <span>CSC 341 Introduction to Information Security</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to first question -->
            <p>Present: 33/37 <br>
               Late: 1/37 <br>
               You have attended 92% of classes this semester.
            </p>
          </div> <!-- end of div tag -->
        
          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display second question -->
            <span>CSC 256 SQL Programming</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to second question -->
            <p>Present: 33/37 <br>
              Late: 1/37 <br>
              You have attended 92% of classes this semester.
           </p>
          </div> <!-- end of div tag -->

          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display third question -->
            <span>CSC 355 Software Engineering II</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to third question -->
            <p>Present: 33/37 <br>
              Late: 1/37 <br>
              You have attended 92% of classes this semester. 
           </p>
          </div> <!-- end of div tag -->

          <div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display third question -->
            <span>CSC 242 Server-Side Web Development</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to third question -->
            <p>Present: 33/37 <br>
              Late: 1/37 <br>
              You have attended 92% of classes this semester.
           </p>
          </div> <!-- end of div tag -->
        </div> <!-- end of ul tag -->
    </section> <!-- end of section tag -->

  <script>
    function asearch() {
      // (A) GET SEARCH TERM
      var data = new FormData(document.getElementById("form"));
      data.append("ajax", 1);

      // (B) AJAX SEARCH REQUEST
      fetch("search.php", { method: "POST", body: data })
        .then(res => res.json())
        .then(res => {
          var wrapper = document.getElementById("results");
          if (res.length > 0) {
            wrapper.innerHTML = "<table><tr><th>First Name</th><th>Email</th></tr>";
            for (let r of res) {
              let line = document.createElement("tr");
              line.innerHTML = `<tr><td>${r["studentFirstName"]}</td><td>${r["studentEmail"]}</td></tr>`;
              wrapper.appendChild(line);
            }
            line.innerHTML = "</table>";
            wrapper.appendChild(line);
          } else { wrapper.innerHTML = "No results found"; }
        });
      return false;
    }

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
  </script>
</body> <!-- end of body tag -->

</html> <!-- end of html tag -->