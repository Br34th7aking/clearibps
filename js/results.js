

$(document).ready(function() {

	//pie chart
	var correct = parseInt($(".correct").attr('value'));
	var wrong = parseInt($(".wrong").attr('value'));
	var unanswered = parseInt($(".unanswered").attr('value'));
	var total = correct + wrong + unanswered;
	//console.log(correct);
	// draw the circle graph
	var ctx = $("#circle-graph")[0].getContext('2d');
	var piechart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ['Correct', "Wrong", "Unanswered"], 
			datasets: [{
				backgroundColor: [
					"#bada55", "#ff5555", "#caebf2"
				],
				data: [correct, wrong, unanswered]
			}]
		}
	});
/*
	//time chart - not yet implemented
	var timeCorrectAnswer = $(".timeCorrectAnswer").attr('value');
	var timeWrongAnswer = $(".timeWrongAnswer").attr('value');
	var timeUnanswered = $(".timeUnanswered").attr('value');
	var totalTime = $(".totalTime").attr('value');
*/
	
	/*suggestions logic */
	// on answers
	var correctRatio = correct / total;
	if (correctRatio > 0.8) {
		$(".suggestion-on-answers").html("You are hitting most questions correctly. That's great! Keep it up and Check your mistakes");
	} 
	else if (correctRatio > 0.5 && correctRatio <= 0.8) {
		$(".suggestion-on-answers").html("You are above the average crowd. That's great! Try to hit more questions correctly to improve your chances");
	}
	else if (correctRatio > 0.3 && correctRatio <= 0.5) {
		$(".suggestion-on-answers").html("You need to revise this section again. Your current level is average.");
	} else {
		$(".suggestion-on-answers").html("Please study sincerely. Your current level is weak, and you have to improve a lot.");
	}
/* suggestions on time 
	if(totalTime < 1450)  {
		// total time for test is 1800 sec
		$(".suggestion-on-time").html("You are not giving enough time to the test paper. Do not rush like that!");

	}
	else if (timeCorrectAnswer / totalTime > 0.7) {
		$(".suggestion-on-time").html("You are spending most of your time on correct answers. That is good time management. Keep it up!");
	}
	else if (timeWrongAnswer / totalTime > 0.4) {
		$(".suggestion-on-time").html("A good portion of your time is going to wrong answers. Spend some more time and get them right.");
	} else if (timeUnanswered/totalTime > 0.3) {
		$(".suggestion-on-time").html("You are wasting a lot of time on unanswered questions. Spend more time on questions you can answer.");
	} else {
		$(".suggestion-on-time").html("You are spending a lot of time on questions you don't answer or answer wrong. Do not rush and answer wisely");
	}

*/
	$(".back-button").click(function() {
		window.location = "index.php";
	});
});