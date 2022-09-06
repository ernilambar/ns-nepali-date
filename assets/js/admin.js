'use strict';

( function( $ ) {
	$.fn.blogPosts = function( options ) {
		var settings = $.extend( {
			api: '',
			action: 'blog_posts',
			loading_text: 'Loading',
			list_type: 'ul',
		}, options );

		if ( '' === settings.api ) {
			return this;
		}

		function generateList( data ) {
			var output = '';

			if ( 0 === data.length ) {
				return output;
			}

			data.forEach( function( item ) {
				output += '<li><a href="' + item.url + '" target="_blank">' + item.title + '</a></li>';
			} );

			return $( '<' + settings.list_type + '/>' ).append( output );
		}

		return this.each( function() {
			if ( $(this).length < 1 ) {
				return;
			}

			var $wrapper = $( this );

			$.ajax( {
				url: settings.api,
				type: 'GET',
				dataType: 'json',
				data: { action: settings.action },
				beforeSend: function() {
					$wrapper.html( settings.loading_text );
				},
				complete: function( jqXHR ) {
					var response = JSON.parse( jqXHR.responseText );

					$wrapper.html( '' );

					if ( true === response.success ) {
						var listMarkup = generateList( response.data );
						$wrapper.append( listMarkup );
					}
				},
			} );
		} );
	};

	$(document).ready(function() {
		$( '.ns-blog-list' ).blogPosts( {
			api: ajaxurl,
			action: 'nsnd_get_posts',
		} );

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
