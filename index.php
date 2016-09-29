<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clear IBPS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.1.0.min.js"></script>
</head>
<body>
	 <div class='container'>
	 	<div class='header'>
			<h1 class='col-md-12'>Clear IBPS</h1>

		</div>
	<!--	<div class='jumbotron'>-->
		 	<?php

		 		session_start();

		 		require_once('connectVars.php');

		 		//connect to database
		 		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database: index.php");

		 		//query to select category
		 		$query = "SELECT * from category";
		 		$cat = mysqli_query($dbc, $query);
		 		while($row = mysqli_fetch_array($cat)) {
		 			
		 			$catname = $row['catname'];
		 			$catId = $row['catId'];
		 			echo "
						<div class='col-md-4 category'>
							<h3>$catname</h3>
							<div class='row'>";

					$query_topic = "SELECT topicname from topic where topic.catId = '$catId'";
					$topicList = mysqli_query($dbc, $query_topic);
					while($row_topics = mysqli_fetch_array($topicList)) {
						$topic = $row_topics['topicname'];
						echo " 
								<div class='col-md-12'>$topic</div>
							";

					}
							
					echo "
						</div>
					</div>";
		 		}
					
			?>
	 <!--</div> -->
	</div>
</body>
</html>