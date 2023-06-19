import './sass/admin.scss';

import 'jquery';

( function ( $ ) {
	$( document ).ready( function () {
		$( '.ns-blog-list' ).blogPosts( {
			api: ajaxurl,
			action: 'nsnd_nsbl_get_posts',
		} );

		$( '.format-list a' ).on( 'click', function ( e ) {
			e.preventDefault();
			const $this = $( this );
			const $format = $this.data( 'format' );

			$this
				.parent()
				.parent()
				.parent()
				.find( 'input[type=text]' )
				.val( $format );
		} );

		$( '.btn-toggle-reference' ).on( 'click', function ( e ) {
			e.preventDefault();
			$( '.format-reference-content' ).fadeToggle();
		} );
	} );
} )( jQuery );
