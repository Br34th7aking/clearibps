<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clear IBPS | TEST</title>
	<link rel="stylesheet" href="css/test.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/test.js"></script>
</head>
<body>
	<div class="instructions">
		<div class="instructions-list">
		<h2>Instructions</h2>
		<p>Please read the instructions carefully</p>
		<h4>General Instructions</h4>
		<ol>	
			<li>The total duration of the test is <strong>20 minutes</strong>.</li>
			<li>You can keep track of the time remaining, with the timer displayed in the test. Once the timer runs out, the test will be automatically submitted. However, if you want to submit the test early, just click the submit button.</li>
			<li>Do <strong>NOT</strong> refresh the page while taking the test, or your progress will be reset.</li>
			<li>Questions Marked for Review only indicate that you want to visit the question later. <span class="important">If you have selected an answer, and then marked the question for review, the last selected answer will be considered in evaluation.</span></li>
			<li>There are a total of <strong>30 questions</strong> in the test. Each question carries <strong>one(1) mark</strong>.</li>
			<li>For every wrong answer, <strong>one-fourth(0.25) marks will be deducted</strong> from your score.</li>
			<li><strong>No marks will be deducted</strong> for an unanswered question.</li>

		</ol>
		<h4>Navigating to a question</h4>
		<ol>
			<li>You can move to any question by clicking the question number in the question palette provided.</li>
			<li>You can click Next to move on to the next question.</li>
			<li>You can click Mark for review to move on to the next question and mark the current question to review later</li>
		</ol>
		</div>
		<div class="begin-button"><strong>Click Me to Start the Test</strong></div>
		
	</div>
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
			<span>Time Left: </span>
			<span class="minutes-digit-1"></span>
			<span class="minutes-digit-2"></span>		
			<span class="time-separator">:</span>
			<span class="seconds-digit-1"></span>
			<span class="seconds-digit-2"></span>
		</div>
		<form method="post" action="results.php">
		<div class="question-wrapper">
		<?php
			echo "<input type='text' class='hidden' id='totalTimeTaken' name='totalTimeTaken' value='0'>"; // for total time
			while ($row = mysqli_fetch_array($questions)) {

				//set up the variables.
				$questionId = $row['questionId'];
				$statement = $row['statement'];
				$option1 = $row['option1'];
				$option2 = $row['option2'];
				$option3 = $row['option3'];
				$option4 = $row['option4'];
				$option5 = $row['option5'];
				$imagepath = $row['imagepath'];

				
		
				echo "<div class='question' id='question$i'>
				<input type='text' class='hidden' id='time-taken$i' name='time-taken$i' value='0'>
					  <h2> Question $i</h2>
					  <hr>	
					  <div class='statement'>$statement</div>";
					  
				// if there is an image in the question, display it
				if(!empty($imagepath)) {
					echo "<div class='question-image'>$imagepath</div>";
				}
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-a'><div class='circle-letter'>A </div> $option1</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-b'><div class='circle-letter'>B </div> $option2</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-c'><div class='circle-letter'>C </div>$option3</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-d'><div class='circle-letter'>D </div>$option4</label>";
				echo "<label class='option'><input type='radio' class='hidden' name='ans-question$i' value='$questionId-e'><div class='circle-letter'>E </div>$option5</label>";
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
			<div class="color-key">
				<div class="color-item"><div class="color-box" id="attempted"></div>Attempted</div>
				<div class="color-item"><div class="color-box" id="not-attempted"></div>Not Attempted</div>
				<div class="color-item"><div class="color-box" id="review"></div>Review</div>
				<div class="color-item"><div class="color-box" id="not-viewed"></div>Not Viewed Yet</div>
			</div>
			<!-- instructions button -->
			<div class="instructions-button">Instructions</div>
		</div>
			<!-- next and previous buttons -->
			<div class='footer-buttons'>
				<div class=" quiz-button next-button">Next</div>
				<div class=" quiz-button uncheck">Clear Response</div>
				<!--<div class=" quiz-button prev-button">Previous</div>-->
				<div class=" quiz-button review-button">Mark for Review</div>				
			

				<div class='submit-button'><label for='submit-test'>Submit</label></div>
			</div>
		<?php
		}
		
	?>
</body>
</html>