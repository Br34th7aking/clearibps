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

			if ($_SESSION['usertype'] == 'admin') {

				$home_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/admindash.php";
				header("Location:" . $home_url);

			}
			else {


			$currentUser = $_SESSION['username'];
			$currentUserId = $_SESSION['userId'];
		?>
			<!--header	-->
			
			<div class='header'>
				<h1 class='logo'>Clear IBPS</h1>
				<div class='welcome-user' id='welcome-user'>Welcome, <?php echo $currentUser; ?></div>

			<!-- navigation -->
				<div class="navigation">
					<div class="nav-item"><a href="index.php">Practice Tests</a></div>
					<div class="nav-item"><a href="">Test Series</a></div>
					<div class="nav-item"><a href="">Performance Reports</a></div>
					<div class="nav-item"><a href="logout.php">Log Out</a></div>
				</div>
			</div>
		

			<!-- categories -->
			<div class="category-list">
				<div class="category col-md-3" id="reasoning">Reasoning</div>
				<div class="category col-md-3" id="quantitative-aptitude">Quantitative Aptitude</div>
				<div class="category col-md-3" id="general-awareness">General Awareness</div>
				<div class="category col-md-3" id="computer">Computer</div>
			</div>

			<!-- show the selected category header -->
			<div >
				<h2 class="category-header"></h2>
				<div class="back-button">Go Back</div>
			</div>
			<!-- topic list -->
			<div class="topic-list">
				<form method="post" action="test.php"> 
				<!-- enclose topics in a form to send their value to test.php -->
					<button type="submit" name="topic" value="1" class="topic col-md-3 topic-reasoning">Logical Reasoning</button>
					<button type="submit" name="topic" value="2" class="topic col-md-3 topic-reasoning">Syllogism</button>
					<button type="submit" name="topic" value="3" class="topic col-md-3 topic-reasoning">Blood Relations</button>
					<button type="submit" name="topic" value="4" class="topic col-md-3 topic-reasoning">Input - Output</button>
					<button type="submit" name="topic" value="5" class="topic col-md-3 topic-reasoning">Coding - Decoding</button>
					<button type="submit" name="topic" value="6" class="topic col-md-3 topic-reasoning">Alphanumeric Series</button>
					<button type="submit" name="topic" value="7" class="topic col-md-3 topic-reasoning">Ranking</button>
					<button type="submit" name="topic" value="8" class="topic col-md-3 topic-reasoning">Data Sufficiency</button>
					<button type="submit" name="topic" value="9" class="topic col-md-3 topic-reasoning">Coded Inequalities</button>
					<button type="submit" name="topic" value="10" class="topic col-md-3 topic-reasoning">Seating Arrangement</button>
					<button type="submit" name="topic" value="11" class="topic col-md-3 topic-reasoning">Puzzles</button>
					<button type="submit" name="topic" value="12" class="topic col-md-3 topic-reasoning">Tabulation</button>
					<button type="submit" name="topic" value="13" class="topic col-md-3 topic-quantitative-aptitude">Simplification</button>
					<button type="submit" name="topic" value="14" class="topic col-md-3 topic-quantitative-aptitude">Ratio and Proportion</button>
					<button type="submit" name="topic" value="15" class="topic col-md-3 topic-quantitative-aptitude">Percentage</button>
					<button type="submit" name="topic" value="16" class="topic col-md-3 topic-quantitative-aptitude">Number System</button>
					<button type="submit" name="topic" value="17" class="topic col-md-3 topic-quantitative-aptitude">Profit and Loss</button>
					<button type="submit" name="topic" value="18" class="topic col-md-3 topic-quantitative-aptitude">Simple Interest</button>
					<button type="submit" name="topic" value="19" class="topic col-md-3 topic-quantitative-aptitude">Compound Interest</button>
					<button type="submit" name="topic" value="20" class="topic col-md-3 topic-quantitative-aptitude">Surds and Indices</button>
					<button type="submit" name="topic" value="21" class="topic col-md-3 topic-quantitative-aptitude">Alligations</button>
					<button type="submit" name="topic" value="22" class="topic col-md-3 topic-quantitative-aptitude">Work and Time</button>
					<button type="submit" name="topic" value="23" class="topic col-md-3 topic-quantitative-aptitude">Time and Distance</button>
					<button type="submit" name="topic" value="24" class="topic col-md-3 topic-quantitative-aptitude">Mensuration</button>
					<button type="submit" name="topic" value="25" class="topic col-md-3 topic-quantitative-aptitude">Sequences and Series</button>
					<button type="submit" name="topic" value="26" class="topic col-md-3 topic-quantitative-aptitude">Permutations and Combinations</button>
					<button type="submit" name="topic" value="27" class="topic col-md-3 topic-quantitative-aptitude">Probability</button>
					<button type="submit" name="topic" value="28" class="topic col-md-3 topic-quantitative-aptitude">Data Interpretation</button>
					<button type="submit" name="topic" value="29" class="topic col-md-3 topic-general-awareness">Current Affairs</button>
					<button type="submit" name="topic" value="30" class="topic col-md-3 topic-general-awareness">Banking Awareness</button>
					<button type="submit" name="topic" value="31" class="topic col-md-3 topic-general-awareness">Marketing</button>
					<button type="submit" name="topic" value="32" class="topic col-md-3 topic-computer">Hardware and Software</button>
					<button type="submit" name="topic" value="33" class="topic col-md-3 topic-computer">Database</button>
					<button type="submit" name="topic" value="34" class="topic col-md-3 topic-computer">Network and Internet</button>
					<button type="submit" name="topic" value="35" class="topic col-md-3 topic-computer">Number System</button>
					<button type="submit" name="topic" value="36" class="topic col-md-3 topic-computer">Security</button>
					<button type="submit" name="topic" value="37" class="topic col-md-3 topic-computer">MS Windows and Office</button>
				</form>


			</div>

			<?php
			}
			}

			else {
				// user not logged in.
				echo "<a href='login.php'> Log in</a>";
			}
		?>
	 
	 
	</div>
</body>
</html>