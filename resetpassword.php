<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reset | Clear IBPS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/resetpass.css">
</head>
<?php
	$error = ""; // clear error message
	require_once("connectVars.php");
	if(isset($_POST['submit'])) {
		// user asked for password reset. 
		$email = $_POST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = 'Please enter a valid email address.';
		}
		// check if user exists.
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database");
		$query = "SELECT username, email from user where email = '$email'";
		$check = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($check);
		$username = $row['username'];
		if(mysqli_num_rows($check) == 0)  {
			$error = "Sorry! There is no account with that email. Please call us @ 9811579253 for further support.";
		}

		if (!$error) {
			// user exists. time to send him password change link
			$tempPassword = "userpassreset". rand(1,10000) . "@clearibps";
			$query = " UPDATE user SET password = '$tempPassword' where email = '$email'";
			$reset = mysqli_query($dbc, $query) or die("Password is not reset");
			

			//send email
			$to = $email;
			$subject = "Clear IBPS - Your Account Recovery Details";
			$body = "Hi, '$username', You have requested a password change for you acccount with clearibps.\n Use the following details to login.
			Please reset your password after login.\n Username: '$username'\n Temporary Password: '$tempPassword'";
			$additionalheaders = "From: noreply@clearibps.com";

			mail($to, $subject, $body, $additionalheaders);
			$passSent = true;

			// show the password sent message.
			echo "<p>Please check your email for the new password. Change your password after logging in";

		} else {
			echo $error;
		}
		mysqli_close($dbc);
	}

?>
<body>
	<header>
		<nav>
			<a class="logo" href="#"><img src="images/logo.png" alt="Clear IBPS Logo"></a>
			<div class="nav-elements">
				<a href="about.html">About Us</a>
				<a href="pricing.html">Pricing</a>
				<a class="sign-in" href="login.php" target="_blank">Sign In</a>
			</div>
		</nav>
	</header>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div>
			<label for="email">Enter Your Email ID</label>
			<input id="email" type="text" name="email">
		</div>
		<input type="submit" name="submit" value="Get New Password">
	</form>

</body>