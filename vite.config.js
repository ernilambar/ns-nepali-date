import { dirname } from 'path';
import { fileURLToPath } from 'url';
import { v4wp } from '@kucrut/vite-for-wp';

const __dirname = dirname( fileURLToPath( import.meta.url ) );

export default {
	plugins: [
		v4wp( {
			input: 'src/admin.js',
			outDir: 'build',
		} ),
	],
	server: {
		port: 5173,
		strictPort: true,
	},
};
