import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname( fileURLToPath( import.meta.url ) );

export default {
	base: './',
	root: __dirname,
	build: {
		outDir: 'build',
		emptyOutDir: true,
		manifest: true,
		rollupOptions: {
			input: resolve( __dirname, 'src/admin.js' ),
		},
	},
	server: {
		port: 5173,
		strictPort: true,
	},
};
