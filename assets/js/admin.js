/**
 * Arrangement bands & parts
 * 
 * Set up select2 and ajax stuff for the arrangement's
 * bands and parts fields.
 * 
 * @since 1.0.0
 * @package musicdistro
 */
(function($) {
	$(document).ready(function() {

		var bands = $( 'select#md_bands' );

		// init bands' pillbox selector
		bands.select2();

	}); // document.ready
})(jQuery);

/**
 * Bands taxonomy edit screen
 * 
 * Set up select2 and stuff for "bands" taxonomy
 * 
 * @since 1.0.0
 * @package musicdistro
 */
(function($) {
	$(document).ready(function() {

		var instruments = $( 'select#md_instruments' );

		// init instruments' pillbox selector
		instruments.select2({
			multiple : true
		});

	}); // document.ready
})(jQuery);
