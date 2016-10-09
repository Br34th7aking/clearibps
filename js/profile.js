var quotes = [
	{
		"quoteId": "1",
		"quote": "Do not wait to strike till the iron is hot; but make it hot by striking."
	},
	{
		"quoteId": "2",
		"quote": "When the going gets tough, the tough get going"
	},
	{
		"quoteId": "3",
		"quote": "Whatever you can do, or dream you can do, begin it. Begin it now."
	},
	{
		"quoteId": "4",
		"quote": "Even if you’re on the right track, you’ll get run over if you just sit there."
	},
	{
		"quoteId": "5",
		"quote": " The most certain way to succeed is always to try just one more time."
	},
	{
		"quoteId": "6",
		"quote": "Believe in yourself and all that you are."
	},
	{
		"quoteId": "7",
		"quote": "Push Yourself because, no one else is going to do it for you."
	},
	{
		"quoteId": "8",
		"quote": "If It is important to you, you will find a way."
	},
	{
		"quoteId": "9",
		"quote": "The secret to getting ahead is getting started."
	},
	{
		"quoteId": "10",
		"quote": "Just Believe in Yourself.Even if you don't, pretend that you do."
	},
	{
		"quoteId": "11",
		"quote": "It always seems impossible until it is done."
	},
	
];

function motivate() {
	var randomQuote = Math.floor(Math.random() * 11 + 1);
	$(".quote").prev().html(quotes[randomQuote]["quote"]);
}

$(document).ready(function() {

	motivate();

	//change motivational quote on click.
	$(".quote").click(function() {
		motivate();
	});

	$(".target").click(function() {
		window.location.href="index.php";
	});
	$(".goal").click(function() {
		window.location.href="index.php";
	});
});