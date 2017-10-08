gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "http://arch"
    });
});