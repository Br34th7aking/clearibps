<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clear IBPS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/profile.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/profile.js"></script>
</head>

<body>
	<?php
		session_start();
		if(isset($_SESSION['userId'])) {
			$currentUser = $_SESSION['username'];
			$currentUserId = $_SESSION['userId'];
			// establish connection with database and get the user stats.
			require_once("connectVars.php");
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			$query = "SELECT firstname, userLevel, trophies, accuracy, bestrank, testsTaken, totalTime, correctTime FROM user where userId = '$currentUserId'";
			$result = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($result);

			$name = $row['firstname'];
			$userLevel = $row['userLevel'];
			$userTrophies = $row['trophies'];
			$userAccuracy = $row['accuracy'];
		//	$userBest = $row['bestrank'];
			$userTotalTests = $row['testsTaken'];
			$userTotalTime = $row['totalTime'];
			$userCorrectTime = $row['correctTime'];

		//  format the time.
			$hours = round($userTotalTime / 3600);
			$minutes = round(($userTotalTime % 3600)/ 60);
			$seconds = round(($userTotalTime % 3600) % 60);
			

		// efficient time %
		// check for division by 0
			if($userTotalTime > 0) {
				$correctTimePercent = round(($userCorrectTime / $userTotalTime) * 100, 2);
			} 
			else {
				$correctTimePercent = 0;
			}
			
		//set target for the user.
			$targetName = "";
			$targetTrophies = "";
		    $query = "SELECT * from user Where trophies > '$userTrophies' limit 1";
		    $result = mysqli_query($dbc, $query);
		    if(mysqli_num_rows($result) == 0) {
		    	//no such user exists. 
		    }
		    else {
		    	$row = mysqli_fetch_array($result);
		    	$targetName = $row['firstname'];
		    	$targetTrophies = $row['trophies'];
		    	$difference = $targetTrophies - $userTrophies;
		    }

		   
		}
	?>
	<!--header-->
	<header>
		<nav>
			<a class="logo" href="#"><img src="images/logo.png" alt="Clear IBPS Logo"></a>
			<div class="nav-elements">
				<a href="index.php">Home</a>
				<a href="changepassword.php">Change Password</a>
				<a href="logout.php">Log Out</a>
				<a href="leaderboard.php" target="_blank">Leader Board</a>
			</div>
		</nav>
	</header>
	<section class="user-profile">
		<section class="three-column top">
			<h4>Hi, <?php echo $name; ?><span class="level">Level <?php echo $userLevel;?></h4>
			<hr>
			<p>Random Inspirational Quote: Get set and do it!</p>
			<div class="button quote">More</div>
		</section>
		<section class="three-column top">
			<h4>Next Target</h4>
			<hr>
			<p>
			<?php 
				if(!empty($targetName)) {
					echo "Get <span class='trophies-to-get'>$difference</span> more trophies to beat your next target <span class='next-target'>$targetName</span>.";
				}else {
					echo "You are the leader! Practice more tests, others are catching up!";
				}
				
			?></p>
			<div class="button target">Acquire Target</div>
		</section>
		<section class="three-column top">
			<h4>Goals</h4>
			<hr>
			<p>Attempt <?php echo ($userLevel * ($userLevel + 1) * 5)/2 - $userTotalTests;?>  more tests to achieve level <?php echo $userLevel+1; ?>
				
			</p>
			<div class="button goal">Let's Do it</div>
		</section>
		<section class="three-column bottom">
			<h4>Stats</h4>
			<hr>
			<table class="stats">
				<tr>
					<td><img src="images/trophy.svg"></td>
					<td><p class="value"><?php echo $userTrophies;?></p><p class="stat-name">TROPHIES</p></td>
				</tr>
				<tr>
					<td><img src="images/aim.svg"></td>
					<td><p class="value"><?php echo round($userAccuracy, 2). "%";?></p><p class="stat-name">ACCURATE</p></td>
				</tr>
				<!--
				<tr>
					<td><img src="images/podium.svg"></td>
					<td><p class="value"></p><p class="stat-name">CURRENT RANK</p></td>
				</tr>
				-->
				<tr>
					<td><img src="images/test.svg"></td>
					<td><p class="value"><?php echo $userTotalTests;?></p><p class="stat-name">Tests Taken</p></td>
				</tr>
				<tr>
					<td><img src="images/hourglass.svg"></td>
					<td><p class="value"><?php echo $hours . ":hr:" . $minutes . ":min:" . $seconds ."sec" ;?></p><p class="stat-name">Practice Time</td>
				</tr>
				<tr>
					<td><img src="images/clock.svg"></td>
					<td><p class="value"><?php echo $correctTimePercent . "%"; ?></p><p class="stat-name">Time Used Efficiently</td>
				</tr>
			</table>

		</section>
		<section class="three-column bottom competitors">
			<h4>Closest Competitors</h4>
			<hr>
			<?php
				$query = "SELECT firstname, trophies FROM user WHERE username <> '$currentUser' ORDER BY ABS(trophies - '$userTrophies')
						 LIMIT 5";
				$result = mysqli_query($dbc, $query);
				$i = 1;
				while($row=mysqli_fetch_array($result)) {
					$firstname = $row['firstname'];
					$trophies = $row['trophies'];
					echo "<div>$i</div>
						 <div>$firstname</div>
						 <div><img src='images/trophy.svg'> $trophies</div><hr>";
					$i++;
				}

			?>
		</section>
		<section class="three-column bottom global-top">
			<h4>Global Top 5</h4>
			<hr>
			
			<?php
				$query = "SELECT firstname, trophies FROM user ORDER BY trophies DESC LIMIT 5";
				$result = mysqli_query($dbc, $query);
				$i = 1;
				while($row=mysqli_fetch_array($result)) {
					$firstname = $row['firstname'];
					$trophies = $row['trophies'];
					echo "<div>$i</div>
						 <div>$firstname</div>
						 <div><img src='images/trophy.svg'> $trophies</div><hr>";
					$i++;
				}
				mysqli_close($dbc);
			?>
		
			
		</section>
	</section>

</body>