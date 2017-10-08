/*
* Internal Pages Set up
*/
gulp.task('intdevjs',function(){
	return gulp.src([
		'js/2.8.3.modernizr.js',
		'bower_components/jquery/dist/jquery.js',
		'bower_components/jquery-migrate/jquery-migrate.min.js',
		'bower_components/jquery.easing/jquery.easing.min.js',
		'bower_components/prettyphoto/js/jquery.prettyPhoto.js',
		'bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
		'bower_components/TipTip/jquery.tipTip.minified.js',
		'js/postlike.js',
		'js/jquery.tools.js',
		//'js/jquery.cycle.lite.js',
		//'bower_components/waypoints/lib/jquery.waypoints.min.js', not compatible with jquery.custom.js
		'js/waypoints.js',
		'js/sidebar.js',
		'js/jquery.custom.js',
		/*js files for the contact form 7 plugin*/
		'../../plugins/contact-form-7/includes/js/jquery.form.js',
		'../../plugins/contact-form-7/includes/js/scripts.js',
		'js/contact-form-7/ajax-loader.js',
		//'bower_components/foundation/js/foundation.js',
		//'/js/foundation/app.js'
		'bower_components/angular/angular.min.js',
    	'bower_components/angular-sanitize/angular-sanitize.min.js',
    	'include/widgets/search/js/app.js',
    	'include/widgets/search/js/controllers.js',
    	'include/widgets/search/js/services.js',
	])
	.pipe(sourcemaps.init())
	.pipe(concat('main.js'))
	.pipe(sourcemaps.write('/'))
	.pipe(size())
	.pipe(gulp.dest('js/dev/internal/'));
});
gulp.task('intdistjs',function(){
	return gulp.src([
		'js/dev/internal/main.js',
	])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(rename('main.min.js'))
	.pipe(uglify())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/js/internal/'));
});
gulp.task('intsassruby', function () {
    return sass(
    	'scss/',{
	    	sourcemap: true,
	    	style: 'expanded',
	    	loadPath:['scss/','bower_components/foundation/scss','bower_components/fontawesome/scss']
    })
	.pipe(autoprefixer('last 2 versions'))
    .pipe(sourcemaps.init())
    .pipe(nano())
    .on('error', function (err) {
      console.error('Error', err.message);     
    })
	.pipe(sourcemaps.write('bin/maps/css/internal/'))
    .pipe(gulp.dest('./'));
});