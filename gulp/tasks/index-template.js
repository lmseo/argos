/**Index Page Build*/
gulp.task('inddevjs',function(){
	return gulp.src([
    	'bower_components/jquery/dist/jquery.js',
    	'js/modernizr.custom.js',
    	'bower_components/jquery.easing/jquery.easing.min.js',
    	//'bower_components/prettyphoto/js/jquery.prettyPhoto.js',
    	'bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
    	'bower_components/TipTip/jquery.tipTip.minified.js',
    	//'js/postlike.js',
    	'bower_components/waypoints/lib/jquery.waypoints.js', 
    	//'js/waypoints.js',
    	'js/sidebar.js',
    	'js/jquery.flexslider.js',
    	'js/jquery.custom.js',
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
	.pipe(gulp.dest('js/dev/index/'));
});
gulp.task('inddistjs',function(){
	return gulp.src([
    	'js/dev/index/main.js',
    ])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(rename('main.min.js'))
	.pipe(uglify())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/js/index/'));
});
gulp.task('sassruby', function () {
    return sass(
    	'scss/',{
	    	sourcemap: true,
	    	style: 'expanded',
	    	loadPath:['scss/','bower_components/foundation/scss','bower_components/fontawesome/scss']
    })
	.pipe(autoprefixer('last 2 versions'))
    .pipe(sourcemaps.init())
    .pipe(size())
    .pipe(nano())
    .on('error', function (err) {
      console.error('Error', err.message);     
    })
    .pipe(size())
	.pipe(sourcemaps.write('bin/maps/css/index/'))
	.pipe(size())
    .pipe(gulp.dest('./'))
    .pipe(size())
    .pipe(browserSync.reload({stream: true}));
});
gulp.task('uncssindex', function () {
    return gulp.src('style.css')
        .pipe(uncss({
            html: ['http://arch']
        }))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('bin/css/index/uncss/'));
});
gulp.task('uncssindexmiss',function(){
	return gulp.src([
		'bin/css/index/uncss/style.css',
		'bin/css/index/uncss/missing/*.css'
		/*'bin/css/index/uncss/missing/sidebar.css',
		'bin/css/index/uncss/missing/animations_effects.css'*/
	])
	.pipe(sourcemaps.init())
	.pipe(concat('style.css'))
	.pipe(nano())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/css/index/uncss/complete/'));
});
gulp.task('criticalindex', function () {
    critical.generate({
        base: './',
        src: 'http://arch/',
        dest: 'bin/css/index/critical/styles.min.css.php',
        css: 'bin/css/index/uncss/style.css',
        width: 320,
        height: 480,
        minify: true
    });
});