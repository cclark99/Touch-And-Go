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

if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['passwordVerify'])) {
   exit('Please complete the registration form!');
}

if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['passwordVerify'])) {
   exit('Please complete the registration form!');
}

if ($stmt = $con->prepare('SELECT userPassword FROM user WHERE userEmail = ?')) {
   $stmt->bind_param('s', $_POST['email']);
   $stmt->execute();
   $stmt->store_result();
   // Store the result so we can check if the account exists in the database.
   if ($stmt->num_rows > 0) {
      // User already exists
      echo 'Email already exists, please choose your Kutztown University email address!';
   } else {

      if (!$_POST['passwordVerify'] === $_POST['password']) {
         exit('Passwords did not match');
      } else if ($stmt = $con->prepare('INSERT INTO user (userEmail, userPassword, userType) VALUES (?, ?, ?)')) {
         $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
         $userType = "student";
         $stmt->bind_param('sss', $_POST['email'], $password, $userType);
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