<?php
session_start();
include "db_connection.php";

// Function to create the root admin account
function createRootAdmin($con)
{
	$rootEmail = 'root@kutztown.com';
	$rootPassword = password_hash('adminPassTest', PASSWORD_BCRYPT);
	$rootUserId = 0;

	$stmtCreateRootAdminUser = $con->prepare("INSERT INTO user (userId, userEmail, userPassword, userType) VALUES (?, ?, ?, 'admin')");
	$stmtCreateRootAdminUser->bind_param("iss", $rootUserId, $rootEmail, $rootPassword);
	
	$stmtCreateRootAdminUser->execute();
	$stmtCreateRootAdminUser->close();

	$stmtCreateRootAdmin = $con->prepare("INSERT INTO admin (userId, firstName, lastName) VALUES (?, 'Root', 'Admin')");
	$stmtCreateRootAdmin->bind_param("i", $rootUserId);
	$stmtCreateRootAdmin->execute();
	$stmtCreateRootAdmin->close();
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['email'], $_POST['password'])) {
	// Could not get the data that should have been sent.
	$_SESSION['login_msg'] = ('Please fill both the email and password fields!');
	header('Location: index.php');
	exit();
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT userId, userPassword, userType FROM user WHERE userEmail = ?')) {
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password, $userType);
		$stmt->fetch();
		// Account exists, now we verify the password.
		if (password_verify($_POST['password'], $password)) {
			// Verification success! User has logged-in!

			// Check and create the root admin account if needed
			if ($userType === 'admin' && $_POST['email'] === 'root@kutztown.com') {
				createRootAdmin($con);
			}

			// Create sessions
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['id'] = $id;
			$_SESSION['userType'] = $userType;

			// Redirect based on user type
			switch ($userType) {
				case 'student':
					header('Location: home.php');
					break;
				case 'professor':
					header('Location: professorHome.php');
					break;
				case 'admin':
					header('Location: adminHome.php');
					break;
			}

		} else {
			// Incorrect password
			$_SESSION['login_msg'] = 'Incorrect password!';
			header('Location: index.php');
			exit();
		}
	} else {
		// Incorrect email
		$_SESSION['login_msg'] = 'Incorrect email!';
		header('Location: index.php');
		exit();
	}

	$stmt->close();
}
?>