<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | Clear IBPS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/login.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="https://use.fontawesome.com/1c648de8d7.js"></script>
</head>
<body>
	<?php
		require_once("connectVars.php");
		session_start();

		// error message 
		$error_message = ""; // variable for error message. 
		if(!isset($_SESSION['userId'])) {
			//user is not logged in.
			if(isset($_POST['submit'])) {
				//user has pressed submit button. verify credentials.

				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database");

				$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
				$password = mysqli_real_escape_string($dbc, trim($_POST['password']));

				if(!empty($username) && !empty($password)) {
					//user has entered information.
					$query = "SELECT * from user where username = '$username' and password = SHA('$password')";
					$data = mysqli_query($dbc, $query) or die ("Error querying the database for username and password");

					if (mysqli_num_rows($data) == 1) {
						//user exists. set the session variables. 
						$row = mysqli_fetch_array($data);

						$_SESSION['userId'] = $row['userId'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['usertype'] = $row['usertype'];

						if($_SESSION['usertype'] == 'admin') {
							//send admin to admindash.php
							$home_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/admindash.php";
							header("Location:" . $home_url);
						} 
						else {
							//redirect normal user to home page.
							$home_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php";
							header("Location:" . $home_url);
						}
						
					}
					else {
						$error_message = "Invalid Username or Password. Please enter correct details.";
					}

				} 
				else {
					// user did not enter full details. 
					$error_message = "Please fill in your details to log in.";
				}
				

				mysqli_close($dbc);
			}
		
	?>

	<?php
		// if session is not set, show error message
		if(empty($_SESSION['userId'])) {
			echo "<p>" . $error_message . "</p>";
		}
	?>
	<!-- the content below is visible to a user who is not logged in -->
	<header>
		<nav>
			<a class="logo" href="#"><img src="images/logo.png" alt="Clear IBPS Logo"></a>
			<div class="nav-elements">
				<a href="signup.php">Register</a>
				<a href="" target="_blank">FAQ</a>
				<a href="" target="_blank">Contact</a>
			</div>
		</nav>
	</header>
	<!--main section-->
	<section class="login-main">
		<div class="login-form-wrapper">
			<h3>Log In</h3>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
				<div class="username">
					<label for="username">Username: </label>
					<input type="text" id="username" name="username"  value="<?php if(!empty($username)) { echo $username;} ?>"><br>
				</div>
				<div>
					<label for="password">Password:</label>
					<input type="password" id="password" name="password"><br>
				</div>
				
				<div><input class="submit" type="submit" value="Sign In" name="submit"></div>
				
			
			</form>
			<hr>
			<div class="form-links">New User? <a href="signup.php"> Sign Up</a></div>
			<div class="form-links"><a href="">I forgot my password</a></div>
		</div>
	</section>
	<!--footer-->
	<footer>
		<section class="four-column">
			<a class="logo" href="#"><img src="images/logo.png" alt="Clear IBPS Logo"></a>
			<p>&copy;Clear IBPS, All rights reserved.</p>
			<a href="http://freepik.com">Icons designed by freepik.com</a>
		</section>
		<section class="four-column">
			<a class="footer-links" href="">About Us</a>
			<a class="footer-links" href="">Pricing</a>
			<a class="footer-links" href="">FAQ</a>
			<a class="footer-links" href="">Terms of Service</a>
		</section>
		<section class="four-column">
			<p>Call Us @ +91-9811579253<br>+91-7091320840</p>
		</section>
		<section class="four-column">
			<p>Follow Us</p>
			<a class="social" href=""><i class="fa fa-2x fa-facebook" aria-hidden="true"></i></a>
			<a class="social" href=""><i class="fa fa-2x fa-twitter" aria-hidden="true"></i></a>
			<a class="social" href=""><i class="fa fa-2x fa-google-plus-official" aria-hidden="true"></i></a>
			<a class="social" href=""><i class="fa fa-2x fa-linkedin" aria-hidden="true"></i></a>
		</section>
	</footer>
	<?php
		} 
		else {
			echo "<p> You are successfully logged in as ". $_SESSION['username'] . "</p>";
		}
	?>
</body>
</html>