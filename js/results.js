

$(document).ready(function() {

	var correct = $(".correct").attr('value');
	var wrong = $(".wrong").attr('value');
	var unanswered = $(".unanswered").attr('value');
	console.log(correct);
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
});