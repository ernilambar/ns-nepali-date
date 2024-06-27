const nsndToggler = () => {
	const btnToggleReference = document.querySelector(
		'.btn-toggle-reference'
	);
	const formatReferenceContent = document.querySelector(
		'.format-reference-content'
	);

	if ( btnToggleReference && formatReferenceContent ) {
		btnToggleReference.addEventListener( 'click', function ( e ) {
			e.preventDefault();

			formatReferenceContent.classList.toggle( 'active' );
		} );
	}
};

const nsndCopier = () => {
	const links = document.querySelectorAll( '.format-list a' );

	if ( ! links ) {
		return;
	}

	for ( const link of links ) {
		link.addEventListener( 'click', function ( e ) {
			e.preventDefault();

			const el = e.currentTarget;

			if ( el ) {
				const format = el.getAttribute( 'data-format' );

				const parent = el.closest( 'td' );

				if ( parent ) {
					const input = parent.querySelector( 'input' );

					if ( input ) {
						input.value = format;
					}
				}
			}
		} );
	}
};

export { nsndToggler, nsndCopier };
