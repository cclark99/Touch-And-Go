<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit();
}

require 'db_connection.php';
include 'get_course.php';

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

    /* Add these styles to your existing CSS */

    /* Style for the dropdown menu */
    .searchBox select {
      padding: 10px;
      margin-right: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    /* Style for the search form */
    .searchBox form {
      padding: 20px;
      margin: auto;
      border: 1px solid #eee;
      background: #f7f7f7;
      display: grid;
      align-content: center;
    }

    .searchBox input {
      display: block;
      padding: 10px;
    }

    .searchBox input[type=text],
    .searchBox select {
      width: 50%;
      /* Adjust the width as needed */
    }

    .searchBox input[type=submit] {
      margin-top: 20px;
      border: 0;
      color: #fff;
      background: #10222e;
      cursor: pointer;
    }

    /* start of style rules for h3 tag */
    h3 {
      color: #10222E;
      /* make color blue */
      font-size: 24pt;
      /* make font size 24 pt */
      text-align: center;
      /* center align text */
      /*margin-top: 2%; /* make margin-top 2% */
    }

    /* end of style rules for h3 tag */
    .dropdown {
      width: 30%;
      /* make width 25% */
    }

    /* end of class style rules for dropdown */
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
    <form id="search" onsubmit="return asearch();">
      <input type="text" name="search" placeholder="Search..." required>

      <!-- Add a dropdown menu to select user type -->
      <select name="userType">
        <option value="">All Users</option>
        <option value="admin">Admins</option>
        <option value="professor">Professors</option>
        <option value="student">Students</option>
      </select>

      <input type="submit" value="Search">
    </form>

    <!-- (B) SEARCH RESULTS -->
    <div id="results"></div>
  </div>

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
    <!-- display Today's Attendance -->
    <h3>Today's Attendance</h3>

    <div class="dropdown"> <!-- start of ul tag with dropdown class -->
      <?php
      if ($course_array) {
        foreach ($course_array as $row) {
          echo '<div class="question"> <!-- start of div tag with question class -->
            <!-- create arrow -->
            <span class="arrow"></span>
            <!-- display first question -->
            <span>' . $row['courseName'] . '</span>
          </div> <!-- end of div tag -->
          <div class="answer"> <!-- start of div tag with answer class -->
            <!-- display answer to first question -->
            <p>Status: </p>
          </div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes found...</span>';
      }
      ?>
    </div> <!-- end of ul tag -->
  </section> <!-- end of section tag -->

  <hr>

  <section class="dropdown-section"> <!-- start of section tag with dropdown-section class -->
    <!-- display Total Semester Attendance -->
    <h3>Total Semester Attendance</h3>

    <div class="dropdown"> <!-- start of ul tag with dropdown class -->

      <?php
      if ($course_array) {
        foreach ($course_array as $row) {
          echo '<div class="question"> <!-- start of div tag with question class -->
          <!-- create arrow -->
          <span class="arrow"></span>
          <!-- display first question -->
          <span>' . $row['courseName'] . '</span>
        </div> <!-- end of div tag -->
        <div class="answer"> <!-- start of div tag with answer class -->
          <!-- display answer to first question -->
          <p>Present: <br>
             Late: <br>
             You have attended % of classes this semester.
          </p>
        </div>';
        }
      } else {
        echo '<span style="color: #FAF8D6; line-height: 1.5em; padding-left: 2%; padding-right: 2%;">No classes found...</span>';
      }
      ?>

      <script>
        function asearch() {
          // (A) GET SEARCH TERM
          var data = new FormData(document.getElementById("search"));
          data.append("ajax", 1);

          // (B) AJAX SEARCH REQUEST
          fetch("search.php", { method: "POST", body: data })
            .then(res => res.json())
            .then(res => {
              console.log("JSON Response:", JSON.stringify(res, null, 2)); // Add this line for debugging
              var wrapper = document.getElementById("results");
              if (res.length > 0) {
                wrapper.innerHTML = "<table><tr><th>User Type</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
                for (let r of res) {
                  // Check if the user is a student, professor, or admin
                  let userType = r["userType"] ? r["userType"] : "";
                  let firstName = "";
                  let lastName = "";

                  // Set the first name and last name based on the user type
                  if (userType === "student") {
                    firstName = r["studentFirstName"] ? r["studentFirstName"] : "";
                    lastName = r["studentLastName"] ? r["studentLastName"] : "";
                  } else if (userType === "professor") {
                    firstName = r["professorFirstName"] ? r["professorFirstName"] : "";
                    lastName = r["professorLastName"] ? r["professorLastName"] : "";
                  } else if (userType === "admin") {
                    firstName = r["adminFirstName"] ? r["adminFirstName"] : "";
                    lastName = r["adminLastName"] ? r["adminLastName"] : "";
                  }

                  let userEmail = r["userEmail"] ? r["userEmail"] : "";

                  // Create a new table row for each user
                  let line = document.createElement("tr");
                  line.innerHTML = `<td>${userType}</td><td>${firstName}</td><td>${lastName}</td><td>${userEmail}</td><td><button onclick="editUser('${userType}', '${userEmail}')">Edit</button></td>`;

                  // Append the new table row to the table
                  wrapper.querySelector("table").appendChild(line);
                }
                // Move the closing </table> outside of the loop
                wrapper.innerHTML += "</table>";
              } else {
                wrapper.innerHTML = "No results found";
              }
            })
            .catch(error => console.error("Error:", error)); // Add this line for error handling
          return false;
        }

        function editUser(userType, userEmail) {
          // Redirect to the edit.php page with user type and email as parameters
          window.location.href = `edit.php?userType=${userType}&userEmail=${userEmail}`;
        }

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
      </script>
</body> <!-- end of body tag -->

</html> <!-- end of html tag -->