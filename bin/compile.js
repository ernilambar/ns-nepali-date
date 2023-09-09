await Bun.build({
  entrypoints: ['./src/admin.ts'],
  outdir: './build',
	minify: true,
});
