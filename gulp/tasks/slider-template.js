/*
*Slider Template
*/
gulp.task('slidertempdevjs',function(){
	return gulp.src([
		'bower_components/jquery/dist/jquery.js',
		'bower_components/jquery-migrate/jquery-migrate.min.js',
		'js/modernizr.custom.js',
		'bower_components/jquery.easing/jquery.easing.min.js',
		'bower_components/prettyphoto/js/jquery.prettyPhoto.js',
		'bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
		'bower_components/TipTip/jquery.tipTip.minified.js',
		'js/jquery.tools.js',
		'js/waypoints.js',
		'js/sidebar.js',
		'js/jquery.custom.js',
		'js/jquery.flexslider.js',
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
	.pipe(gulp.dest('js/dev/internal/slider/template/'));
});
gulp.task('slidertempdistjs',function(){
	return gulp.src([
		'js/dev/internal/slider/template/main.js',
	])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(rename('main.min.js'))
	.pipe(size())
	.pipe(uglify())
	.pipe(size())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/js/internal/slider/template/'));
});
gulp.task('slidertempsassruby', function () {
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
	.pipe(sourcemaps.write('bin/maps/css/internal/slider/template/'))
    .pipe(gulp.dest('./'));
});
gulp.task('slidertempuncss', function () {
    return gulp.src('bin/css/internal/slider/template/style.css')
        .pipe(uncss({
            html: ['http://arch/services/residential/windows/casement-windows/',
            	'http://arch/services/residential/windows/sliding-windows/',
            	'http://arch/services/residential/windows/awning-windows/',
            	'http://arch/services/residential/windows/hung-windows/',
            	'http://arch/services/residential/windows/bay-windows/',
            	'http://arch/services/residential/windows/bow-windows/',
            	]
        }))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('bin/css/internal/slider/template/uncss/'));
});
gulp.task('slidertempuncssmiss',function(){
	return gulp.src([
		'bin/css/internal/slider/template/uncss/style.css',
		'bin/css/internal/slider/template/uncss/missing/*.css',
	])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(concat('style.css'))
	.pipe(nano())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/css/internal/slider/template/uncss/complete/'));
});
gulp.task('slidertempcritical', function () {
    critical.generate({
        base: './',
        src: 'index.html',
        dest: 'bin/css/internal/slider/template/critical/styles.min.css.php',
        css: 'bin/css/internal/slider/template/uncss/style.css',
		dimensions: [{
			width: 320,
			height: 480
			},{
			width: 768,
			height: 1024
			},{
			width: 1280,
			height: 960
		}],
        minify: true
    });
});