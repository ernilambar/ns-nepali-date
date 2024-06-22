import "dotenv/config";
import { v4wp } from "@kucrut/vite-for-wp";
import { wp_scripts } from "@kucrut/vite-for-wp/plugins";
import VitePluginBrowserSync from "vite-plugin-browser-sync";
import postcssPresetEnv from "postcss-preset-env";

export default {
	build: {
		target: "es2015",
	},
	css: {
		postcss: {
			plugins: [postcssPresetEnv],
		},
	},
	plugins: [
		v4wp({
			input: ["src/search.ts"],
			outDir: "build",
		}),
		wp_scripts(),
		VitePluginBrowserSync({
			dev: {
				bs: {
					proxy: process.env.DEV_SERVER_URL,
					open: "yes" === process.env.BROWSERSYNC_OPEN ? true : false,
				},
			},
		}),
	],
};
