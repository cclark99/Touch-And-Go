<?php session_start() ?>
<!DOCTYPE html>

<html lang="en"> <!-- start of html tag -->

<head> <!-- start of head tag -->
   <!-- set charset -->
   <meta charset="utf-8">
   <!-- set title -->
   <title>Login</title>
   <!-- link external styles.css sheet -->
   <link rel="stylesheet" type="text/css" href="../styles.css">
   <style>
      .faq-link {
         position: fixed;
         bottom: 10px;
         right: 10px;
         text-align: right;
         font-size: 26px;
      }

      .faq-link a {
         color: #333;
         text-decoration: none;
      }

      .disclaimer {
         position: fixed;
         bottom: 10px;
         left: 10px;
         text-align: left;
         font-size: 26px;
      }

      .disclaimer p {
         color: #333;
         text-decoration: none;
      }

   </style>
</head> <!-- end of head tag -->

<body> <!-- start of body tag -->
   <!-- display logo -->
   <img src="../Touch__Go_Logo.jpg" alt="Touch and Go Logo" class="center">

   <!-- Sign In heading -->
   <h1>Login</h1>

   <!-- start of sign in forms -->
   <form class="login_reg" method="post" action="auth.php">

      <!-- email address form with placeholder -->
      <input name="email" type="text" size="20" placeholder="Email Address" class="center" required>

      <!-- password form with placeholder -->
      <input name="password" type="password" size="20" placeholder="Password" class="center" required>

      <br>

      <!-- submit button -->
      <input class="button" type="submit" value="Login">

      <!-- clear button -->
      <input class="button" type="reset" value="Clear">

   </form> <!-- end of sign in forms -->

   <?php
   if (isset($_SESSION['login_msg'])) {
      echo '<h2 style="margin-top: 15px;">' . $_SESSION['login_msg'] . '</h2>';
      unset($_SESSION['login_msg']);
   }
   ?>

   <h3 style="text-align: center;">Need an account? <a href="register.php">Register Here</a></h3>

   <div class="disclaimer">
      <p>Disclaimer about fingerprint storage</p>
   </div>

   <div class="faq-link">
      <a href="faq.php">FAQ</a>
   </div>

</body> <!-- end of body tag -->

</html> <!-- end of html tag -->