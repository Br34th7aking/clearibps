<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clear IBPS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	
	<div class='container' >
		<?php

			session_start();
			if(isset($_SESSION['userId'])) {
				//user is logged in.

			$currentUser = $_SESSION['username'];
			$currentUserId = $_SESSION['userId'];
		?>
			<!--header	-->
			
			<div class='header'>
				<h1 class='logo'>Clear IBPS</h1>
				<div class='welcome-user' id='welcome-user'>Welcome, <?php echo $currentUser; ?></div>

			<!-- navigation -->
				<div class="navigation">
					<div class="nav-item"><a href="addquestion.php">Add Question</a></div>
					<div class="nav-item"><a href="">Test Series</a></div>
					<div class="nav-item"><a href="logout.php">Log Out</a></div>
				</div>
			</div>
		
			
			

			<?php
			}

			else {
				// user not logged in.
				echo "<a href='login.php'> Log in</a>";
			}
		?>
	 
	 
	</div>
</body>
</html>