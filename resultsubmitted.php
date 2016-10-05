<!-- just provides an intermediate page to save data before redirecting to homepage-->

<?php 
	//topic id and user info
	require_once("connectVars.php");
	session_start();
	$userId = $_SESSION['userId'];
	$topic = $_POST['topic'];
	$attempted = $_POST['attempted'];
	$totalCorrect = $_POST['totalCorrect'];
	$totalWrong = $_POST['totalWrong'];
	$score = $_POST['score'];


	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database!");

	$query = "INSERT into testdata (userId, topicId, attempted, correct, wrong, score, testDate) 
			  VALUES('$userId', '$topic', '$attempted', '$totalCorrect', '$totalWrong', '$score', NOW())" or die("Error entering user data");

	if(isset($_POST['submit'])) {
		mysqli_query($dbc, $query);

		$home_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php";
		header("Location:" . $home_url);
	} 

	mysqli_close($dbc);
?>