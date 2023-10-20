<?php
// Database connection
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'test';
$DATABASE_PASS = 'test123';
$DATABASE_NAME = 'touch_and_go_test';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
   // If there is an error with the connection, stop the script and display the error.
   exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if(!isset($_POST['id'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'])) {
   exit('Please complete the registration form!');
}

if (empty($_POST['id']) || empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['password']) ) {
   exit('Please complete the registration form!');
}

if ($stmt = $con->prepare('SELECT studentId, studentPassword FROM student WHERE studentEmail = ?')) {
   $stmt->bind_param('s', $_POST['email']);
   $stmt->execute();
   $stmt->store_result();
   // Store the result so we can check if the account exists in the database.
   if ($stmt->num_rows > 0) {
      // User already exists
      echo 'Email already exists, please choose your Kutztown University email address!';
   } else {

      if ($stmt = $con->prepare('INSERT INTO student (studentId, studentFirstName, studentLastName, studentEmail, studentPassword) VALUES (?, ?, ?, ?, ?)')) {
         $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
         $stmt->bind_param('issss', $_POST['id'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $password);
         $stmt->execute();
         echo 'You have successfully registered! You can now login!';
      }
   }
   $stmt->close();
} else {
   echo 'Could not prepare statement!';
}

$con->close();

?>
