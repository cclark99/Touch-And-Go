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
  </script>
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
  </style>

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
  <div class="searchBox">
    <form id="form" onsubmit="return asearch();">
      <input type="text" name="search" placeholder="Search..." required>
      <input type="submit" value="Search">
    </form>

    <!-- (B) SEARCH RESULTS -->
    <div id="results"></div>
  </div>
</body> <!-- end of body tag -->

</html> <!-- end of html tag -->