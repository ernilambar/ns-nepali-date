// Config.
var rootPath   = './';
var projectURL = 'http://staging.local/';

// Gulp.
var gulp = require( 'gulp' );

// Browser sync.
var browserSync = require('browser-sync').create();

// Watch.
gulp.task( 'watch', function() {
    browserSync.init({
        proxy: projectURL,
        open: true
    });

    // Watch CSS files.
    gulp.watch( rootPath + '**/**/*.css' ).on('change',browserSync.reload);

    // Watch PHP files.
    gulp.watch( rootPath + '**/**/*.php' ).on('change',browserSync.reload);
});

// Tasks.
gulp.task( 'default', gulp.series('watch'));
