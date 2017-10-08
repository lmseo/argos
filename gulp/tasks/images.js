/** Image Optimization*/
gulp.task('images', function(){
    return gulp.src(['images/**/*.{png,jpg,gif}'])
        .pipe(imagemin())
        .pipe(gulp.dest('bin/images/'));
});
gulp.task('imagesalt', function () {
	return gulp.src('images/**/*.{png,jpg,gif}')
	.pipe(cache(imagemin({
		optimizationLevel: 3,
		progressive: true,
		interlaced: true
	})))
	.pipe(gulp.dest('bin/images/'))
	.pipe(size());
});
gulp.task('svgimages', function () {
    return gulp.src(['images/**/*.svg'])
        .pipe(svgmin({
            plugins: [{
                removeViewBox: false
	        }, {
	                removeUselessStrokeAndFill: false
	        }, {
	            	removeEmptyAttrs: false 
	        }]
        }))
        .pipe(gulp.dest('bin/images/'));
});