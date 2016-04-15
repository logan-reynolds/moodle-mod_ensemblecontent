$(document).ready(function(){
	var heading = $('h2.main.help').text().trim();
	var html = $('h2.main.help').html();
	var fixedHeading = heading;

	if (heading.match('Adding')) {
		fixedHeading = heading.replace('Adding a new Ensemble Content', 'Add Ensemble Content');
	}
	else {
		fixedHeading = heading.replace('Updating: Ensemble Content', 'Update Ensemble Content');
	}

	$('h2.main.help').html(html.replace(heading, fixedHeading));
});