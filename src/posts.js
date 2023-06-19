import { createRoot } from '@wordpress/element';
import PostsApp from './PostsApp';

const container = document.getElementById( 'nsnd-posts-app' );

if ( container ) {
	const root = createRoot( container );

	root.render( <PostsApp /> );
}
