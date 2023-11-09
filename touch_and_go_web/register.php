<?php session_start() ?>
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
   <!-- set charset -->
   <meta charset="utf-8">
   <!-- set title -->
   <title>Login</title>
   <!-- link external styles.css sheet -->
   <link rel="stylesheet" type="text/css" href="styles.css">
</head> <!-- end of head tag -->

<body> <!-- start of body tag -->
   <!-- display logo -->
   <img src="../Touch__Go_Logo.jpg" alt="Touch and Go Logo" class="center">

   <!-- Sign In heading -->
   <h1>Register</h1>

   <!-- start of sign in forms -->
   <form method="post" action="reg.php">

      <!-- firstName form with with placeholder -->
      <input name="firstName" type="text" placeholder="First Name" class="center" required>

      <!-- firstName form with with placeholder -->
      <input name="lastName" type="text" placeholder="Last Name" class="center" required>

      <!-- email form with with placeholder -->
      <input name="email" type="text" placeholder="Email Address" class="center" required>

      <!-- password form with placeholder -->
      <input name="password" type="password" placeholder="Password" class="center" required>

      <!-- password re-enter form with placeholder -->
      <input name="passwordVerify" type="password" placeholder="Re-enter Password" class="center" required>

      <!-- userType radio buttons form with placeholder -->
      <input type="radio" id="studentType" name="userType" checked required value="student">
      <label for="studentType">Student</label><br>

      <input type="radio" id="professorType" name="userType" value="professor">
      <label for="professorType">Professor</label><br>

      <!-- submit button -->
      <input class="button" type="submit" value="Register">

      <!-- clear button -->
      <input class="button" type="reset" value="Clear">

   </form> <!-- end of sign in forms -->

   <h1>
      <?php echo $_SESSION['reg_msg'] ?>
   </h1>

   <h3 style="text-align: center;">Already have an account? <a href="index.html">Login Here</a></h2>

</body> <!-- end of body tag -->

</html> <!-- end of html tag -->