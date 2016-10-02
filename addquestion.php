<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add new question</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/addques.css">
</head>
<body class="text-center">
	<h1>Add question</h1>
	<?php
		session_start();
		//only display the following content to admin
		if($_SESSION['usertype'] == 'admin') {

	?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<label for="topic">Topic</label>
				<select name="topic" id="topic">
					<option value="1">Logical Reasoning</option>
					<option value="2">Syllogism</option>
					<option value="3">Blood Relations</option>
					<option value="4">Input - Output</option>
					<option value="5">Coding - Decoding</option>
					<option value="6">Alphanumeric Series</option>
					<option value="7">Ranking</option>
					<option value="8">Data Sufficiency</option>
					<option value="9">Coded Inequalities</option>
					<option value="10">Seating Arrangement</option>
					<option value="11">Puzzle</option>
					<option value="12">Tabulation</option>
					<option value="13">Simplification</option>
					<option value="14">Ratio and Proportion</option>
					<option value="15">Percentage</option>
					<option value="16">Number System</option>
					<option value="17">Profit and Loss</option>
					<option value="18">Simple Interest</option>
					<option value="19">Compound Interest</option>
					<option value="20">Surds and Indices</option>
					<option value="21">Alligations</option>
					<option value="22">Work and Time</option>
					<option value="23">Time and Distance</option>
					<option value="24">Mensuration</option>
					<option value="25">Sequences and Series</option>
					<option value="26">Permutations and Combinations</option>
					<option value="27">Probability</option>
					<option value="28">Data Interpretation</option>
					<option value="29">Current Affairs</option>
					<option value="30">Banking Awareness</option>
					<option value="31">Marketing</option>
					<option value="32">Hardware and Software</option>
					<option value="33">Database</option>
					<option value="34">Network and Internet</option>
					<option value="35">Security</option>
					<option value="36">Binary Number System</option>
					<option value="37">MS Windows and Office</option>

				</select>
			</div>

			<div>
				<label for="Statement">Question Statement</label>
				<input id="" type="text" name="statement">
			</div>
			<div>
				<label for="Option1">Option 1</label>
				<input id="Option1" type="text" name="option1">
			</div>
			<div>
				<label for="Option2">Option 2</label>
				<input id="Option2" type="text" name="option2">
			</div>
			<div>
				<label for="Option3">Option 3</label>
				<input id="Option3" type="text" name="option3">
			</div>
			<div>
				<label for="Option4">Option 4</label>
				<input id="Option4" type="text" name="option4">
			</div>
			<div>
				<label for="correctans">Correct Answer</label>
				<select name="correctans" id="correctans">
					<option value="a">A</option>
					<option value="b">B</option>
					<option value="c">C</option>
					<option value="d">D</option>
				</select>
			</div>
			<div>
				<label for="imagepath">Image URL</label>
				<input id="imagepath" type="text" name="imagepath">
			</div>
			<div>
				<label for="solution">Solution</label>
				<input id="solution" type="textarea" name="solution">
			</div>

			<div>
				
				<input id="submit" type="submit" name="submit" value="Add">
			</div>
		</form>
	<?php
		}
	?>
	<?php
		// connect to the database
		require_once("connectVars.php");

		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database @ addquestion.php");

		if (isset($_POST['statement'])) {
				//set the variables.
			$statement = $_POST['statement'];
			$option1 = $_POST['option1'];
			$option2 = $_POST['option2'];
			$option3 = $_POST['option3'];
			$option4 = $_POST['option4'];
			$correctans = $_POST['correctans'];
			$imageUrl = $_POST['imagepath'];
			$solution = $_POST['solution'];
			$topicId = $_POST['topic'];

	//		echo $topicId;
			

			// add the question
			$query_question = "INSERT into questionbank (statement, option1, option2, option3, option4, correctans, topicId, imagepath, solution)
							   VALUES ('$statement', '$option1', '$option2', '$option3', '$option4', '$correctans', '$topicId', '$imageUrl',   
							    '$solution')";

			$addQues = mysqli_query($dbc, $query_question) or trigger_error(mysqli_error()." in ".$query_question);


		}
		
		mysqli_close($dbc);
	?>
</body>
</html>