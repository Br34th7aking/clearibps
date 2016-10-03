<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.1.0.min.js"></script>
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
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<fieldset>
				<legend>Log In</legend>
				<div>
					<label for="username">Username: </label>
					<input type="text" id="username" name="username"  value="<?php if(!empty($username)) { echo $username;} ?>"><br>
				</div>
				<div>
					<label for="password">Password:</label>
					<input type="password" id="password" name="password"><br>
				</div>
				
				<input type="submit" value="Submit" name="submit">
				
			</fieldset>
	</form>
		<div>New User? <a href="signup.php"> Sign Up</a></div>
	<?php
		} 
		else {
			echo "<p> You are successfully logged in as ". $_SESSION['username'] . "</p>";
		}
	?>
</body>
</html>