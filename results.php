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
	
	// time variables (in secs.)
	$timeCorrectAnswer = 0;
	$timeWrongAnswer = 0;
	$timeUnanswered = 0;
	$totalTime = 0;
	// connect to database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$i = 1; // question counter.
	$totalQuestions = 10;
	while ($i <= $totalQuestions) {

		// get time spent on the question 
		$timetaken = intval($_POST["time-taken$i"]);
		//echo "Time taken for question $i = $timetaken<br>";
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
				
				$timeCorrectAnswer += $timetaken;
				$totalCorrect++;
				$score++;
			} else {
				$totalWrong++;
				$timeWrongAnswer += $timetaken;
				$score -= 0.25;
			}


		} else {
			//add time for unanswered questions
			$timeUnanswered += $timetaken;
		}
		
		$i++; // go to next question

	}
	// attempted questions 
	$attempted = $totalCorrect + $totalWrong;
	//total time spent on test
	$totalTime = $timeCorrectAnswer + $timeWrongAnswer + $timeUnanswered;
	//echo "Total time: $totalTime";
	

?>

<?php 
//topic id and user info
//update user stats.
session_start();

$username = $_SESSION['username'];
$userId = $_SESSION['userId'];
$topic = $_POST['topic'];


//get current stats
$query = "SELECT userLevel, trophies, testsTaken, accuracy, totalTime, correctTime FROM user where userId = '$userId'";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);

//increase the number of tests
$totalTests = $row['testsTaken'];
$totalTests++;

$currentTrophies = $row['trophies'];
$accuracy = $row['accuracy'];
$totalTimeTaken =  $row['totalTime'];
$correctTime = $row['correctTime'];
$currentLevel = $row['userLevel'];

//update trophies.
// marks per question is 1, so total questions = total marks.
$percentMarks = round(($score / $totalQuestions) * 100);
$trophiesAwarded = 0;
if($percentMarks > 80) {
	$trophiesAwarded = 35;
}
else if ($percentMarks > 70) {
	$trophiesAwarded = 20;
}
else if ($percentMarks > 60) {
	$trophiesAwarded = 10;
}
else if ($percentMarks > 50) {
	$trophiesAwarded = 5;
}
else if ($percentMarks > 40) {
	$trophiesAwarded = 2;
}
else if ($percentMarks > 30) {
	$trophiesAwarded = -5;
}
else if ($percentMarks > 20) {
	$trophiesAwarded = -10;
}
else {
	$trophiesAwarded = -20;
}

$currentTrophies += $trophiesAwarded;

// update accuracy, totalTime & correctTime
//formula for accuracy
//1. (prev acc x prev number of teststaken + new test marks )/ totaltests;
$accuracy = round(($accuracy * ($totalTests - 1) + $percentMarks) / $totalTests, 2);
$totalTimeTaken += $totalTime;
$correctTime += $timeCorrectAnswer;

//update user level 
if($totalTests >= ($currentLevel * ($currentLevel + 1) * 5)/2) { //base level is 5
	$currentLevel++;
}

$query = "UPDATE user SET userLevel = '$currentLevel', trophies = '$currentTrophies', testsTaken = '$totalTests', totalTime = '$totalTimeTaken',
		  correctTime = '$correctTime', accuracy = '$accuracy' WHERE userId = '$userId'";
mysqli_query($dbc, $query);
?>
<!-- hidden data for results -->
<!-- for pie chart -->
<div value = "<?php echo $totalCorrect; ?>" class="hidden correct"></div>
<div value = "<?php echo $totalWrong; ?>" class="hidden wrong"></div>
<div value = "<?php echo $totalQuestions - ($totalCorrect + $totalWrong); ?>" class="hidden unanswered"></div>



<!-- for time  -->
<!-- total time in seconds -->
<div value = "<?php echo $timeCorrectAnswer?>" class="hidden timeCorrectAnswer"></div>
<div value = "<?php echo $timeWrongAnswer?>" class="hidden timeWrongAnswer"></div>
<div value = "<?php echo $timeUnanswered?>" class="hidden timeUnanswered"></div>
<div value = "<?php echo $totalTime?>" class="hidden totalTime"></div>

<!-- submit data on button-click-->
		
		<form method="post" action="resultsubmitted.php">
			<input type="text" class="hidden" name="topic" value="<?php echo $topic; ?>">
			<input type="text" class="hidden" name="attempted" value="<?php echo $attempted; ?>">
			<input type="text" class="hidden" name="totalCorrect" value="<?php echo $totalCorrect; ?>">
			<input type="text" class="hidden" name="totalWrong" value="<?php echo $totalWrong; ?>">
			<input type="text" class="hidden" name="score" value="<?php echo $score; ?>">
			<div><input class="back-button button" type="submit" name = "submit" value="Back to Home"></div>
		</form>

	<div class="title summary">
		<h2>Summary</h2>
		<div class="user">
			<h3> Your Score</h3>
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
					<td><?php echo $score; ?> / 10</td> <!-- total marks is 10 -->
				</tr>
			</table> 
		</div>
		<!-- topper's details -->
		<div class="topper">
			<h3>Topper's Score</h3>
			<?php	
				// get details of topper
				$querytop = "SELECT * from testdata WHERE topicId = '$topic' ORDER by score desc limit 1"; // get the topmost score
				$result = mysqli_query($dbc, $querytop);
				$row = mysqli_fetch_array($result);

				// current user may be the topper in this test. so first do a comparison to decide the real topper
				if($score >= $row['score']) {
					//current user is the new topper
					$topperAttempted = $totalCorrect + $totalWrong;
					$topperCorrectAnswer = $totalCorrect;
					$topperWrongAnswer = $totalWrong;
					$topperScore = $score;
					$topperId = $_SESSION['userId'];

					
				} else {

					$topperAttempted = $row['attempted'];
					$topperCorrectAnswer = $row['correct'];
					$topperWrongAnswer = $row['wrong'];
					$topperScore = $row['score'];
					$topperId = $row['userId'];

					
				}
				//name of the topper
					$queryTopperName = "SELECT firstname, surname FROM user where userId = '$topperId'";
					$result = mysqli_query($dbc, $queryTopperName);
					$row = mysqli_fetch_array($result);
					$topperFirstname = $row['firstname'];
					$topperSurname = $row['surname'];

				

				
			?>		
			<table>
				<tr>
					<td>Name </td> 
					<td><?php echo $topperFirstname . " " . $topperSurname; ?></td>
				</tr>
				<tr>
					<td>Answered</td>
					<td><?php echo $topperAttempted; ?></td>
				</tr>
				<tr>
					<td>Correct</td>
					<td><?php echo $topperCorrectAnswer; ?></td>
				</tr>
				<tr>
					<td>Wrong</td>
					<td><?php echo $topperWrongAnswer; ?></td>
				</tr>
				<tr class="score">
					<td>Score</td>
					<td><?php echo $topperScore; ?> / 10</td> <!-- total marks is 10 -->
				</tr>
			</table> 
			
		</div>

		<!-- if current user is the topper, then congratulate him -->
		<!-- use a modal, add social sharing on this later -->
		<?php
		if($topperScore == $score) { 
			//compare the scores because we have to compare current score with topper's score. 
			echo "<div id='congratsMessageModal' class='modal'>
				<div class='modal-content'>
					<span class='close'>x</span>
					<h3>Congratulations! You just topped the test! Keep it up, Champ!</h3>
				</div>
			</div>";
		}
		
		?>
	</div>
	<hr>
	<div class="button details-button">Check Details</div>
	<div class="details hidden">
		<h1 class="title">Detailed Analysis</h1>
		<div class="circle-graph">
			<h2>Your Performance</h2>
			<canvas id="circle-graph" height="40"></canvas>
		</div>
		
		<div class="time-analysis">
			<h2>How did you spend your time?</h2>
			<?php
				//minutes
				$minutes = floor($totalTime / 60); // 1min = 60s
				$seconds = $totalTime - ($minutes * 60);

			?>
			
			<table>
			<tr>
				<th>Time Spent</th> 
				<th>Percentage (%)</th>
			</tr>
			<tr>
				<td>Correct Answers</td>
				<td><?php echo round(($timeCorrectAnswer * 100) / $totalTime, 1);?></td>
			</tr>
			<tr>
				<td>Wrong Answers</td>
				<td><?php echo round(($timeWrongAnswer * 100) / $totalTime, 1); ?></td>
			</tr>
			<tr>
				<td>Unanswered</td>
				<td><?php echo round(($timeUnanswered * 100) / $totalTime, 1);?></td>
			</tr>
			<tr class="totalTime">
				<td>Total Time Taken</td>
				<td><?php echo "$minutes min  $seconds sec"?></td>
			</tr>
		</table> 
		
		</div>
		<hr>
		<div class="suggestions">
			<h1>How can you Improve?</h1>
			<div class="suggestion-box">
				<div class="suggestion-on-answers"></div>
				<div class="suggestion-on-time"></div>
			</div>
		</div>

		<!-- questions and solutions -->
		<h2> Questions And Solutions</h2>
		<table class="solutions">
			<tr>
				<th>Q.No</th>
				<th>Question</th>
				<th>Your Answer</th>
				<th>Correct Answer</th>
				<th>Time Taken</th>
				<th>Solution</th>
			</tr>
			<?php
				$i = 1;
				while($i <= $totalQuestions) {

					// get time spent on the question 
					$timetaken = intval($_POST["time-taken$i"]);
					if (isset($_POST["ans-question$i"])) {
						$data = explode('-', $_POST["ans-question$i"]);
					}
					
					
					//get user answer
					if(!empty($_POST["ans-question$i"])) {
						$userChoice = $data[1];
					}
					else {
						$userChoice = "Not Attempted";
					}

					// get correct ans from database
					// get questionId 
					
					$questionId = $_POST["question$i"];
					$query = "SELECT * from questionbank where questionId = '$questionId'";
					$result = mysqli_query($dbc, $query);
					$row = mysqli_fetch_array($result);
					$correctAns = $row['correctans'];
					$statement = $row['statement'];
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $statement; ?></td>
				<td><?php echo $userChoice; 
						if ($userChoice != "Not Attempted") {
							if($userChoice == $correctAns) {
								echo "<img src='images/success.svg'>";
							}
							else {
								echo "<img src='images/error.svg'>";
							}

						}
						
					?>
						  	
				</td>
				<td><?php echo $correctAns; ?></td>
				<td><?php echo round(($timetaken / 60)) . ":min:" . ($timetaken % 60) . "sec"; ?></td>
				<td>Solution Later</td>
			</tr>
			<?php
					$i++;

					
				}
				mysqli_close($dbc);
			?>
		</table>
	</div>	
		
		
	
</body>
</html>