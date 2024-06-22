import "dotenv/config";
import { v4wp } from "@kucrut/vite-for-wp";
import VitePluginBrowserSync from "vite-plugin-browser-sync";
import postcssPresetEnv from "postcss-preset-env";
import postcssNested from "postcss-nested";

export default {
	build: {
		target: "es2015",
	},
	css: {
		postcss: {
			plugins: [postcssPresetEnv, postcssNested],
		},
	},
	plugins: [
		v4wp({
			input: ["src/admin.js"],
			outDir: "build",
		}),
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
