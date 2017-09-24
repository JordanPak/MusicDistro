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
