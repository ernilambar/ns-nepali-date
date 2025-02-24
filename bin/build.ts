import * as esbuild from "https://deno.land/x/esbuild@v0.19.3/mod.js";

import postcss from "postcss";
import presetEnv from "postcss-preset-env";

async function processCss(filePath: string): Promise<string> {
    const css = await Deno.readFile(filePath);
    const decoder = new TextDecoder("utf-8");
    const decodedCss = decoder.decode(css);
    const result = await postcss([
		presetEnv()
	]).process(decodedCss, { from: undefined });
    return result.css;
}

const copySync = (from: string, to: string) => {
    try {
        Deno.copyFileSync(from, to)
    } catch (error) {
        if (!(error instanceof Deno.errors.NotFound)) throw error;
        Deno.mkdirSync(to.substring(0, to.lastIndexOf('/')), { recursive: true });
        Deno.copyFileSync(from, to)
    }
}

await esbuild.build({
  entryPoints: ["./src/admin.js"],
  outfile: "./build/admin.js",
  bundle: true,
  minify: false,
  format: "esm",
  sourcemap: false,
  target: ["es2017"],
  plugins: [
	{
		name: 'postcss-plugin',
		setup(build) {
			build.onLoad({ filter: /\.css$/ }, async (args) => {
				const processedCss = await processCss(args.path);
				return { contents: processedCss, loader: 'css' };
			});
		},
	},
],
});

await esbuild.stop();
