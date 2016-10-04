<!DOCTYPE html>
<html>
<head>
	<title>Results</title>
	<link rel="stylesheet" href="css/results.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
	<script src="js/results.js"></script>
</head>
<body>
<?php


	require_once("connectVars.php");

	// result variables
	$totalCorrect = 0;
	$totalWrong = 0;
	$score = 0;
	// connect to database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$i = 1; // question counter.
	$totalQuestions = 10;
	while ($i <= $totalQuestions) {
		//get user response and questionId
		if(!empty($_POST["ans-question$i"]))  {
			$data = explode('-', $_POST["ans-question$i"]);
			$questionId = $data[0];
			//get user answer
			$userChoice = $data[1];

			// get correct ans from database
			// get questionId 
			$query = "SELECT correctans from questionbank where questionId = '$questionId'";
			$result = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($result);

			// check the answers. 
			if ($userChoice == $row['correctans']) {
				
				$totalCorrect++;
				$score++;
			} else {
				$totalWrong++;
				$score -= 0.25;
			}
		}
		
		$i++; // go to next question
	}
	mysqli_close($dbc);
?>
<!-- hidden data for results -->
<!-- for pie chart -->
<div value = "<?php echo $totalCorrect; ?>" class="hidden correct"></div>
<div value = "<?php echo $totalWrong; ?>" class="hidden wrong">$totalWrong</div>
<div value = "<?php echo $totalQuestions - ($totalCorrect + $totalWrong); ?>" class="hidden unanswered">$score</div>
<div value = "" class="hidden"></div>
<div value = "" class="hidden"></div>

	<div class="title summary">
		<h2>Summary</h2>
		<table>
			<tr>
				<td>Number of Questions</td> 
				<td><?php echo $totalQuestions; ?></td>
			</tr>
			<tr>
				<td>Answered</td>
				<td><?php echo ($totalCorrect + $totalWrong); ?></td>
			</tr>
			<tr>
				<td>Correct</td>
				<td><?php echo $totalCorrect; ?></td>
			</tr>
			<tr>
				<td>Wrong</td>
				<td><?php echo $totalWrong; ?></td>
			</tr>
			<tr class="score">
				<td>Score</td>
				<td><?php echo $score; ?></td>
			</tr>
		</table> 
	</div>
	<hr>
	<div class="details">
		<h1 class="title">Detailed Analysis</h1>
		<div class="circle-graph">
			<h2>Your Performance</h2>
			<canvas id="circle-graph" height="50"></canvas>
		</div>
		<div class="time-analysis">
			<h2>Time Analysis</h2>
		</div>
	</div>
</body>
</html>