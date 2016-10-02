var showHeader = function(category) {

	var catValue = "";
	switch(category) {
		case 'reasoning':
			catValue = 'Reasoning';
			break;
		case 'quantitative-aptitude':
			catValue = 'Quantitative Aptitude';
			break;
		case 'general-awareness':
			catValue = 'General Awareness';
			break;
		case 'computer':
			catValue = 'Computer';
			break;

		default: 
			catValue = "";
	}
	$(".category-header").html(catValue).show();
}

$(document).ready(function() {

	$(".topic").hide(); // hide all topics initially
	$(".back-button").hide(); // hide the back-button
	$(".category-header").hide(); // hide the 'selected category' header. 

	// when the user clicks on any category
	$(".category").click(function() {
		var cat = $(this).attr('id');
	//	console.log(cat);
		//hide all categories
		$(".category-list").hide();

	// show the category header
		showHeader(cat);

	// show the back button
		$(".back-button").show();

		// hide any topics visible
		$(".topic").hide();
		// show the topics of the selected category
		$(".topic-" + cat).show();

	});

	// when the user clicks the back button 
	$(".back-button").click(function() {
		//hide the category header, back-button and topics
		$(".category-header").hide();
		$(".back-button").hide();
		$(".topic").hide();

		// display the categories
		$(".category-list").show();
	});

/*
	// on clicking any topic user should be taken to test.php
	$(".topic").click(function() {

		window.location.href="http://localhost/Websites/clearibps/test.php";
		//console.log(window.location.href);
		// get the id of this attribute


	});
*/
});