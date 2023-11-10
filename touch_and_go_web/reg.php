<?php
session_start();

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

if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['passwordVerify'], $_POST['userType'])) {
   $_SESSION['reg_msg'] = 'Could not prepare statement';
   header("Location: register.php");
   exit();
}

if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['passwordVerify']) || empty($_POST['userType'])) {
   $_SESSION['reg_msg'] = 'Could not prepare statement';
   header("Location: register.php");
   exit();
}

if ($stmt = $con->prepare('SELECT userPassword FROM user WHERE userEmail = ?')) {
   $stmt->bind_param('s', $_POST['email']);
   $stmt->execute();
   // Store the result so we can check if the account exists in the database.
   $stmt->store_result();
   if ($stmt->num_rows > 0) {
      $_SESSION['reg_msg'] = 'Email already exists, please choose your Kutztown University email address!';
      header("Location: register.php");
      exit();
   } else {
      if ($_POST['passwordVerify'] !== $_POST['password']) {
         $_SESSION['reg_msg'] = 'Passwords did not match. Make sure to enter the same passwords';
         header("Location: register.php");
         exit();
      } else if ($stmt = $con->prepare('INSERT INTO user (userEmail, userPassword, userType) VALUES (?, ?, ?)')) {
         $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
         $userType = $_POST['userType'];
         $stmt->bind_param('sss', $_POST['email'], $password, $userType);
         $stmt->execute();
         
         if($idStmt = mysqli_prepare($con, "SELECT userId FROM user WHERE userEmail = ? LIMIT 1"))
         {
            mysqli_stmt_bind_param($idStmt, 's', $_POST['email']);
            mysqli_stmt_execute($idStmt);

            /* bind variables to prepared statement */
            mysqli_stmt_bind_result($idStmt, $uid);


         }

         switch (true) {
            case $userType == 'student':
               $stmt1 = $con->prepare('SELECT userId FROM user WHERE userEmail = ?');
               $stmt1->bind_param('s', $_POST['email']);
               $stmt1->execute();
               $stmt1->bind_result($userId);
               $stmt1->close();

               $stmt2 = $con->prepare('INSERT INTO student (studentId, studentFirstName, studentLastName) VALUES (?, ?, ?)');
               $stmt2->bind_param('iss', $userId, $_POST['firstName'], $_POST['lastName']);
               $stmt2->execute();
               $stmt2->close();
               break;
            case $userType == 'professor';
               $stmt1 = $con->prepare('SELECT userId FROM user WHERE userEmail = ?');
               $stmt1->bind_param('s', $_POST['email']);
               $stmt1->execute();
               $stmt1->bind_result($userId);
               $stmt1->close();

               $stmt2 = $con->prepare('INSERT INTO professor (professorId, professorFirstName, professorLastName) VALUES (?, ?, ?)');
               $stmt2->bind_param('iss', $userId, $_POST['firstName'], $_POST['lastName']);
               $stmt2->execute();
               $stmt2->close();
               break;
            default:
               // Need to hope that we don't ever get to this switch statement lol
               $_SESSION['reg_msg'] = 'Contact Touch And Go Administration - There is a problem with your account...';
               header('Location: register.php');
               exit();
         }

         $_SESSION['reg_msg'] = 'You have successfully registered! You can now login! Click the login link';
         header("Location: register.php");


      }
   }
   $stmt->close();
} else {
   $_SESSION['reg_msg'] = 'Could not prepare statement';
   header("Location: register.php");
   exit();
}

$con->close();

?>