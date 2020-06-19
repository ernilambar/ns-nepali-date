(function( $ ) {
	'use strict';

	$(document).ready(function() {
		$('.format-list a').on('click',function(e){
			e.preventDefault();
			var $this = $(this);
			var $format = $this.data('format');

			$this.parent().parent().parent().find('input[type=text]').val($format);
		});

		$('.btn-toggle-reference').on('click',function(e){
			e.preventDefault();
			$('.format-reference-content').fadeToggle();
		});
	});


})( jQuery );
