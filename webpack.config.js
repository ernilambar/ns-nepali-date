require( 'dotenv' ).config();

const path = require( 'path' );

const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );

module.exports = {
	...defaultConfig,
	entry: {
		admin: path.resolve( __dirname, 'src', 'admin.js' ),
	},
	plugins: [
		...defaultConfig.plugins,
		new BrowserSyncPlugin( {
			proxy: process.env.DEV_SERVER_URL,
			open: false,
			files: [
				{
					match: [ '**/*.php' ],
					fn( event ) {
						if ( event === 'change' ) {
							const bs =
								require( 'browser-sync' ).get(
									'bs-webpack-plugin'
								);
							bs.reload();
						}
					},
				},
			],
		} ),
	],
};
