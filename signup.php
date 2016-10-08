<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clear IBPS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signup.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="https://use.fontawesome.com/1c648de8d7.js"></script>
</head>
<body>
	<?php
		require_once('connectVars.php');

		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die ("Error connecting to database: signup form");

		if(isset($_POST['submit'])) {

			$username =  mysqli_real_escape_string($dbc, trim($_POST['username']));
			$firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
			$surname = mysqli_real_escape_string($dbc, trim($_POST['surname']));
			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
			$gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
			$mobile = mysqli_real_escape_string($dbc, trim($_POST['mobile']));
			$password = mysqli_real_escape_string($dbc, trim($_POST['password']));

			if(!empty($username) && !empty($firstname) && !empty($surname) && !empty($mobile) && !empty($password)) {

				// check if user already exists. 
				$query = "SELECT * from user where username = '$username'";
				$data = mysqli_query($dbc, $query); 

				if (mysqli_num_rows($data) == 0) {

					$query = "INSERT into user (username, firstname, surname, email, gender, mobile, password) 
						  VALUES ('$username', '$firstname', '$surname', '$email', '$gender', '$mobile', SHA('$password'))";

					mysqli_query($dbc, $query) or die("Error inserting data into database");

					echo "<p>Account created successfully. You can now <a href=''>Log In</a>.</p>";
					exit();

				}	
				else {
					echo "<p>Username already exists.</p>";
					$username = "";
				}
			} 
			else {
				echo "<p>Please fill up all the data.</p>";
			}
		}

		mysqli_close($dbc);
	?>
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

	<!-- sign up form -->
	<section class="sign-up">
		<h2>Start <span class="imp">Improving your Performance</span> Today. Join Us</h2>
		<div class="form-wrapper">
			<h3>Sign Up</h3>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div>
					<label for="username">Username: </label>
					<input type="text" name="username">
				</div>
				<div>
					<label for="firstname">First Name: </label>
					<input type="text" name="firstname">
				</div>
				<div>
					<label for="surname">Surname: </label>
					<input type="text" name="surname">
				</div>
				<div>
					<label for="email">Email: </label>
					<input type="email" name="email">
				</div>
				<div>
					<label for="gender">Gender: </label>
					<label class="gender" for="male"><input type="radio" name="gender" value="Male">Male</label>
					<label class="gender" for="female"><input type="radio" name="gender" value="Female">Female</label>
				</div>
				<div>
					<label for="mobile">Mobile: </label>
					<input type="text" name="mobile">
				</div>
				
				<div>
					<label for="password">Password: </label>
					<input type="password" name="password">
				</div>
				
					<input class="submit" type="submit" name="submit" value="Sign Up">
				
			</form>
		</div>
	</section>

	<!-- footer -->
	<footer>
		<section class="four-column">
			<a class="logo" href="#"><img src="images/logo.png" alt="Clear IBPS Logo"></a>
			<p>&copy;Clear IBPS, All rights reserved.</p>
			<a href="http://freepik.com">Icons designed by freepik.com</a>
		</section>
		<section class="four-column">
			<a class="footer-links" href="about.html">About Us</a>
			<a class="footer-links" href="pricing.html">Pricing</a>
			<a class="footer-links" href="faq.html">FAQ</a>
			<a class="footer-links" href="terms.html">Terms of Service</a>
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
</body>
</html>