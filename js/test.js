/* this script contains javascript code for test.php file */

var i = 1; //question counter
var totalQuestions = 10; // this is the number of questions in the test. 
var elapsed = 0; // to track time spent per question.
var totalTimeTaken = 0; // to track how much time user took before finishing.

//set a timer for t minutes.
function countdown(t) {
	
	var secondsDigit1 = 0;
	var secondsDigit2 = 0;
	var minutesDigit1 = Math.floor(t / 10);
	var minutesDigit2 = (t % 10);

	// initial display
	$(".minutes-digit-1").html(minutesDigit1);
	$(".minutes-digit-2").html(minutesDigit2);
	$(".seconds-digit-1").html(secondsDigit1);
	$(".seconds-digit-2").html(secondsDigit2);

	var timer = setInterval(count, 1000);

		function count() {
		
		//update the timer digits every second
		$(".minutes-digit-1").html(minutesDigit1);
		$(".minutes-digit-2").html(minutesDigit2);
		$(".seconds-digit-1").html(secondsDigit1);
		$(".seconds-digit-2").html(secondsDigit2--);

		if (secondsDigit2 < 0) {
			secondsDigit2 = 9;
			secondsDigit1--;
		}
		if (secondsDigit1 < 0) {
			secondsDigit1 = 5; // 59 seconds
			minutesDigit2--;
		}
		if (minutesDigit2 <0) {
			minutesDigit2 = 9;
			minutesDigit1--;
		}

		//increase timespent in sec.
		elapsed++;
		totalTimeTaken++;

		if((minutesDigit1 == 0) && (minutesDigit2 == 0) && (secondsDigit1 == 0) && (secondsDigit2 == 0)) {
			//time's up
			clearInterval(timer);
			$("form").submit(); // submit the test.
		}

	}
}

// set initial display
function init() {
	
	// display only the first question of the test.
	$("#question" + i).show();
	// also hide the previous button.
	//	$(".prev-button").hide();
	$(".sidebar").show();
	$(".timer").show();
	$(".quiz-button").show();
	$(".submit-button").show();
	$(".instructions").hide();

	//show first question box as unattempted
	$("#" + i).css("background", "#ff5555");
	$("#" + i).css("color", "#fff");

	// initialize the time spent variable for current question.
	start = new Date();

	countdown(20); // starts the timer for 20 mins

}

// clicking next button should move to next question.
function nextQuestion(current) {
	//show the previous button.
	//	$(".prev-button").show();
	//hide the current question.
	$("#question" + current).hide();
	//display next question
	//	console.log("current " + current);
	var next = parseInt(current) + 1;
	//	console.log("next " + next);
	// if the questionId is less than total questions
	if(next <= totalQuestions) {
		$("#question" + next).show();
		i++;
	} else {
		//just show the last question.
		$("#question" + current).show();
	}
	
	
}

function storeTime(current) {
	
	
	var prevTimeTaken = parseInt($("#time-taken" + current).attr('value'));
//	console.log("prev time: " + prevTimeTaken);
	var newTimeTaken = (prevTimeTaken + elapsed);  
	
	$("#time-taken" + current).attr('value', newTimeTaken);
	//console.log($("#time-taken" + current).attr('value'));
	//reset counter for next question
	elapsed = 0;
	console.log("Time spent on question " + current +" :" +  $("#time-taken" + current).attr('value'));


}


$(document).ready(function() {
	//befor the test begins, keep everything hidden except the instructions.
	$(".sidebar").hide();
	$(".timer").hide();
	$(".quiz-button").hide();
	$(".submit-button").hide();
	//initial display and timer
	var testActive = false;
	$(".begin-button").click(function() {
		if(!testActive) {
			init();
			testActive = true;
		} else {
			$(".sidebar").show();
			$(".quiz-button").show();
			$("#question" + i).show();
			$(".submit-button").show();
			$(".instructions").hide();
		}
	});
	

	//change color of selected div when user selects an answer.
	$("input").change(function() {

		if ((this).checked) {
			$(this).parent().css("background", "#caebf2");
			// reset the background of previously selected input, if any.
			$('input[type="radio"]:not(:checked)').parent().css("background", "");

		} 
	});

	// set the height of the question-number-sidebar equal to its width
	var width = $(".question-number-sidebar").width();
	$(".question-number-sidebar").css("height", width);

	

	$(".next-button").click(function() {
		// if the current question is unanswered, then  set the color of question number in sidebar
		/*
		if (("#question" + i).find("input:radio:checked").length > 0) {
			console.log("ok");
		}*/
		//console.log("#question" + i);
		// store time spent on current question
		storeTime(i);


		nextQuestion(i);
		if($("#question" + i).find("input:radio:checked").length == 0) {
			// question has not been answered.
			// check if it is not marked for review, for this, check the color of corresponding box in sidebar. it should be white
			//console.log($("#"+i).css("background-color"));
			if($("#" + i).css("background-color") == "rgb(255, 255, 255)") {
			//	console.log("ok");
				//question has not been marked for review.
				//change the background of question box in sidebar
				$("#" + i).css("background", "#ff5555");
				$("#" + i).css("color", "#fff");
			}
			
		}
		
	});
/*
	$(".prev-button").click(function() {
		prevQuestion(i);
	});
*/
	// sidebar functionality
	//when user clicks a question number, display that question. 
	$(".question-num-sidebar").click(function() {
		//first hide the current question
		//console.log("ok");
		// store time elapsed
		storeTime(i);
		$(".question").hide();
		//now display the chosen question.
		var current = $(this).attr('id');
		$("#question" + current).show();
		//change the color to question number box to 'not attempted' color, if the question is not checked.
		if ($("#question" + current).find("input:radio:checked").length == 0) {
			//answer is not marked.
			$("#" + current).css("background-color", "#ff5555");
			$("#" + current).css("color", "#fff");
		}
		
		//change the value of global counter i
		i = current;
	//	console.log(i);

	});
	//when a question is answered, change the color of ques number in sidebar
	$(".option").click(function() {
		//get the id of question from name attribute of child
		var quesId = $(this).children().attr('name').slice(12, $(this).children().attr('name').length);
		$("#" + quesId).css("background", "#bada55");
		$("#" + quesId).css("color", "#fff");

	});
	// if question is marked for review change color of question number in sidebar
	$(".review-button").click(function() {
		// id of current question is in global variable i
		$("#" + i).css("background", "#800080");
		$("#" + i).css("color", "#fff");
	});
	

	//uncheck answer
	$(".uncheck").click(function() {
		// set the color of current question box to red
		$("#" + i).css("background", "#ff5555");
		$("#" + i).css("color", "#fff");

		//uncheck the answer and reset it's div's color. 
		$("#question" + i ).find("input:radio").prop('checked', false);
		$("#question" + i).children().css("background", "#fff");
	});
	$(".instructions-button").click(function() {
		$(".sidebar").hide();
		$(".question").hide();
		$(".quiz-button").hide();
		$(".submit-button").hide();
		//change the begin-button to back button
		
		$(".begin-button").html("Back to Test");
		$(".instructions").show();
	});

	$("form").submit(function() {
		$("#totalTimeTaken").attr('value', totalTimeTaken);
	});
	// 
});