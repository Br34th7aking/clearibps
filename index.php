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
				<div class="topic col-md-3 topic-reasoning">Logical Reasoning</div>
				<div class="topic col-md-3 topic-reasoning">Syllogism</div>
				<div class="topic col-md-3 topic-reasoning">Blood Relations</div>
				<div class="topic col-md-3 topic-reasoning">Input - Output</div>
				<div class="topic col-md-3 topic-reasoning">Coding - Decoding</div>
				<div class="topic col-md-3 topic-reasoning">Alphanumeric Series</div>
				<div class="topic col-md-3 topic-reasoning">Ranking</div>
				<div class="topic col-md-3 topic-reasoning">Data Sufficiency</div>
				<div class="topic col-md-3 topic-reasoning">Coded Inequalities</div>
				<div class="topic col-md-3 topic-reasoning">Seating Arrangement</div>
				<div class="topic col-md-3 topic-reasoning">Puzzles</div>
				<div class="topic col-md-3 topic-reasoning">Tabulation</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Simplification</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Ratio and Proportion</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Percentage</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Number System</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Profit and Loss</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Simple Interest</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Compound Interest</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Surds and Indices</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Alligations</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Work and Time</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Time and Distance</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Mensuration</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Sequences and Series</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Permutations and Combinations</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Probability</div>
				<div class="topic col-md-3 topic-quantitative-aptitude">Data Interpretation</div>
				<div class="topic col-md-3 topic-general-awareness">Current Affairs</div>
				<div class="topic col-md-3 topic-general-awareness">Banking Awareness</div>
				<div class="topic col-md-3 topic-general-awareness">Marketing</div>
				<div class="topic col-md-3 topic-computer">Hardware and Software</div>
				<div class="topic col-md-3 topic-computer">Database</div>
				<div class="topic col-md-3 topic-computer">Network and Internet</div>
				<div class="topic col-md-3 topic-computer">Number System</div>
				<div class="topic col-md-3 topic-computer">Security</div>
				<div class="topic col-md-3 topic-computer">MS Windows and Office</div>

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