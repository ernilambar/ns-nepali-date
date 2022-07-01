// Env.
require('dotenv').config();

// Config.
var rootPath = './';

// Gulp.
var gulp = require('gulp');

// File system.
var fs = require('fs');

// Package.
var pkg = JSON.parse(fs.readFileSync('./package.json'));

// Delete.
var del = require('del');

// Zip.
var zip = require('gulp-zip');

// Deploy files list.
var deploy_files_list = [
	'assets/**',
	'inc/**',
	'languages/**',
	'vendor/**',
	'readme.txt',
	pkg.main_file
];

// Clean deploy folder.
gulp.task('clean:deploy', function() {
		return del('deploy')
});

// Copy to deploy folder.
gulp.task('copy:deploy', function() {
	return gulp.src(deploy_files_list, { base: '.' })
			.pipe(gulp.dest('deploy/' + pkg.name))
			.pipe(zip(pkg.name + '.zip'))
			.pipe(gulp.dest('deploy'))
});

// Tasks.
gulp.task( 'deploy', gulp.series('clean:deploy', 'copy:deploy'));
