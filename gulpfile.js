// Env.
require( 'dotenv' ).config();

// Config.
const rootPath = './';

// Gulp.
const gulp = require( 'gulp' );

// Environments.
const environments = require( 'gulp-environments' );
const development = environments.development;

// SASS.
const sass = require( 'gulp-sass' )( require( 'sass' ) );

// Babel.
const babel = require( 'gulp-babel' );

// Sourcemaps.
const sourcemaps = require( 'gulp-sourcemaps' );

// Autoprefixer.
const autoprefixer = require( 'gulp-autoprefixer' );

// Browser sync.
const browserSync = require( 'browser-sync' ).create();

gulp.task( 'styles', function() {
	return gulp.src( [ rootPath + 'src/sass/*.scss' ] )
		.pipe( development( sourcemaps.init() ) )
		.pipe( sass.sync().on( 'error', sass.logError ) )
		.pipe( autoprefixer() )
		.pipe( development( sourcemaps.write( '.' ) ) )
		.pipe( gulp.dest( 'assets/css' ) );
} );

gulp.task( 'scripts', function() {
	return gulp.src( [ rootPath + 'src/js/*.js' ] )
		.pipe( babel( {
			presets: [ '@babel/env' ],
		} ) )
		.pipe( gulp.dest( 'assets/js' ) );
} );

gulp.task( 'watch', function() {
	browserSync.init( {
		proxy: process.env.DEV_SERVER_URL,
		open: true,
	} );

	// Watch SCSS files.
	gulp.watch( rootPath + 'src/sass/**/*.scss', gulp.series( 'styles' ) ).on( 'change', browserSync.reload );

	// Watch PHP files.
	gulp.watch( rootPath + '**/**/*.php' ).on( 'change', browserSync.reload );

	// Watch JS files.
	gulp.watch( rootPath + 'src/js/*.js', gulp.series( 'scripts' ) ).on( 'change', browserSync.reload );
} );

// Tasks.
gulp.task( 'default', gulp.series( 'watch' ) );
gulp.task( 'build', gulp.series( 'styles', 'scripts' ) );
