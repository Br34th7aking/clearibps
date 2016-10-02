<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clear IBPS | TEST</title>
	<link rel="stylesheet" href="css/test.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/test.js"></script>
</head>
<body>
	<?php
		require_once('connectVars.php');
		require_once('topicIdandName.php');
		$currentTopic = $_POST['topic'];

		//connect to the database and select questions.
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die ("Error connecting to database @ test.php");

		$query = "SELECT * from questionbank where topicId = '$currentTopic' order by RAND() limit 10";

		$questions = mysqli_query($dbc, $query) or die ("Error pulling questions form question bank");

		$totalQuestions = mysqli_num_rows($questions);

		if ($totalQuestions == 0) {
			// there are no questions for this topic. 
			// so display coming soon.
			echo "<h3>Coming soon...</h3>";

		}

		else {
			$i = 1; // question counter
		?>

		<!-- display the timer -->
		<div class='timer'>
			<span class="minutes-digit-1"></span>
			<span class="minutes-digit-2"></span>		
			<span class="time-separator">:</span>
			<span class="seconds-digit-1"></span>
			<span class="seconds-digit-2"></span>
		</div>
		<form method="post" action="results.php">
		<div class="question-wrapper">
		<?php
			while ($row = mysqli_fetch_array($questions)) {

				//set up the variables.
				$questionId = $row['questionId'];
				$statement = $row['statement'];
				$option1 = $row['option1'];
				$option2 = $row['option2'];
				$option3 = $row['option3'];
				$option4 = $row['option4'];
				$imagepath = $row['imagepath'];

				
		
				echo "<div class='question' id='question$i'>
					  <h2> Question $i</h2>
					  <hr>	
					  <div class='statement'>$statement</div>";
					  
				// if there is an image in the question, display it
				if(!empty($imagepath)) {
					echo "<div class='question-image'>$imagepath</div>";
				}
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-a'><div class='circle-letter'>A</div> $option1</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-b'><div class='circle-letter'>B</div> $option2</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-c'><div class='circle-letter'>C </div>$option3</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-d'><div class='circle-letter'>D </div>$option4</label>";
				echo "</div>";
		
		
		
			$i++; //increase the question number
			}
		?>
			
			<input type='submit' id='submit-test' class='hidden'>
			</div>
		</form>
		<!-- sidebar -->
		<div class="sidebar"> 
			<h3>Question Overview</h3>
			<?php
				$quesNum = 1;
				while ($quesNum <= $totalQuestions) {
					echo "<div class='question-num-sidebar' id='$quesNum'>$quesNum</div>";
					$quesNum++;
				}
			?>
		</div>
			<!-- next and previous buttons -->
			<div class='footer-buttons'>
				<div class=" quiz-button next-button">Next</div>
				<div class=" quiz-button prev-button">Previous</div>
			

				<div class='submit-button'><label for='submit-test'>Submit</label></div>
			</div>
		<?php
		}
		
	?>
</body>
</html>