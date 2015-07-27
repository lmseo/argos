//Galereya JavaScript options
$(function() {
	$('#portfolio-gallery-container').galereya({
	//spacing between cells of the masonry grid
		spacing: 10,

		//waving visual effect
		wave: false,

		//waving visual effect timeout duration
		waveTimeout: 3000,

		// special CSS modifier for the gallery
		modifier: 'cat-port',

		//speed of the slide show
		slideShowSpeed: 3000,

		//speed of appearance of cells
		cellFadeInSpeed: 200,

		//the name of the general category
		noCategoryName: 'all',

		//set to true, if you don't want to show the slider on the cell click.
		disableSliderOnClick: false
	});
});