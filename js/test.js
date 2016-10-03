/* this script contains javascript code for test.php file */

var i = 1; //question counter
var totalQuestions = 10; // this is the number of questions in the test. 

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
	$(".prev-button").hide();

	countdown(20); // starts the timer for 20 mins
}

// clicking next button should move to next question.
function nextQuestion(current) {
	//show the previous button.
//	$(".prev-button").show();
	//hide the current question.
	$("#question" + current).hide();
	//display next question
	var next = current + 1;
// if the questionId is less than total questions
	if(next <= totalQuestions) {
		$("#question" + next).show();
		i++;
	} else {
		//just show the last question.
		$("#question" + current).show();
	}
	
	/*
	if (i == totalQuestions) {
		$(".next-button").hide();
	}
	*/
	//console.log(i);
}
/*
// move to previous question.
function prevQuestion(current) {
	i--;
	if(i == 1) {
		// there is no previous question
		$(".prev-button").hide();
	}
	//show the next button.
	$(".next-button").show();
	//hide the current question.
	$("#question" + current).hide();
	//display next question
	var prev = current - 1;
	$("#question" + prev).show();
	
	//console.log(i);
}

*/
$(document).ready(function() {

	init(); // initial display and start timer


	//change color of selected div when user selects an answer.
	$("input").change(function() {

		if ((this).checked) {
			$(this).parent().css("background", "#caebf2");
			// reset the background of previously selected input, if any.
			$('input[type="radio"]:not(:checked)').parent().css("background", "#fff");
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
		nextQuestion(i);
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
		$(".question").hide();
		//now display the chosen question.
		var current = $(this).attr('id');
		$("#question" + current).show();
		//change the value of global counter i
		i = current;

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

});