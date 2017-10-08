/*
*Portfolio Single posts
*/
gulp.task('portdevjs',function(){
	return gulp.src([
		'bower_components/jquery/dist/jquery.js',
		'bower_components/jquery-migrate/jquery-migrate.min.js',
		'js/modernizr.custom.js',
		'bower_components/jquery.easing/jquery.easing.min.js',
		'bower_components/prettyphoto/js/jquery.prettyPhoto.js',
		'bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
		'bower_components/TipTip/jquery.tipTip.minified.js',
		'js/portfolio/thumbnailGridEffects.js',
		'js/portfolio/classie.js',
		'js/postlike.js',
		'js/jquery.tools.js',
		'js/waypoints.js',
		'js/sidebar.js',
		'js/jquery.custom.js',
		'bower_components/galereya/src/js/jquery.galereya.js',
		'js/custom.galereya.js',
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
	.pipe(gulp.dest('js/dev/internal/portfolio/'));
});
gulp.task('portdistjs',function(){
	return gulp.src([
		'js/dev/internal/portfolio/main.js',
	])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(rename('main.min.js'))
	.pipe(size())
	.pipe(uglify())
	.pipe(size())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/js/internal/portfolio/'));
});
gulp.task('portsassruby', function () {
    return sass(
    	'scss/',{
	    	sourcemap: true,
	    	style: 'expanded',
	    	loadPath:['scss/','bower_components/foundation/scss','bower_components/fontawesome/scss','bower_components/galereya/dist/scss']
    })
	.pipe(autoprefixer('last 2 versions'))
    //.pipe(sourcemaps.init())
    .pipe(nano())
    .on('error', function (err) {
      console.error('Error', err.message);     
    })
	//.pipe(sourcemaps.write('bin/maps/css/internal/portfolio/'))
    .pipe(gulp.dest('./'));
});
gulp.task('portuncss', function () {
    return gulp.src('bin/css/internal/portfolio/style.css')
        .pipe(uncss({
            html: ['http://arch/portfolio/bathrooms/']
        }))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('bin/css/internal/portfolio/uncss/'));
});
gulp.task('portuncssmiss',function(){
	return gulp.src([
		'bin/css/internal/portfolio/uncss/style.css',
		'bin/css/internal/portfolio/uncss/missing/*.css',
	])
	//.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(concat('style.css'))
	.pipe(nano())
	//.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/css/internal/portfolio/uncss/complete/'));
});
gulp.task('portcritical', function () {
    critical.generate({
        base: './',
        src: 'http://arch/portfolio/bathrooms/',
        dest: 'bin/css/internal/portfolio/critical/styles.min.css.php',
        css: 'bin/css/internal/portfolio/uncss/complete/style.css',
        width: 320,
        height: 480,
        minify: true
    });
});