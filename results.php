<!DOCTYPE html>
<html>
<head>
	<title>Results</title>
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
			} else {
				$totalWrong++;

			}
		}
		
		$i++; // go to next question
	}

	//echo "Total Correct " . $totalCorrect;
	//echo "Total Wrong " . $totalWrong;
	//echo "Unattempted:" . ($totalQuestions - ($totalCorrect + $totalWrong));
	mysqli_close($dbc);
?>
</body>
</html>