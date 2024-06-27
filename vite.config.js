import 'dotenv/config';
import { v4wp } from '@kucrut/vite-for-wp';
import VitePluginBrowserSync from 'vite-plugin-browser-sync';

export default {
	build: {
		target: 'es2015',
	},
	plugins: [
		v4wp( {
			input: [ 'src/admin.js' ],
			outDir: 'build',
		} ),
		VitePluginBrowserSync( {
			dev: {
				bs: {
					proxy: process.env.DEV_SERVER_URL,
					open: 'yes' === process.env.BROWSERSYNC_OPEN ? true : false,
				},
			},
		} ),
	],
};
