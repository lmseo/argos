/*
* portfolio Archive Pages Set up
*/
gulp.task('portarchdevjs',function(){
	return gulp.src([
		'bower_components/jquery/dist/jquery.js',
		'bower_components/jquery-migrate/jquery-migrate.min.js',
		'js/modernizr.custom.js',
		//'js/portfolio/modernizr_custom.js', not this because it is all contained in js/modernizr.custom.js
		'bower_components/jquery.easing/jquery.easing.min.js',
		'bower_components/prettyphoto/js/jquery.prettyPhoto.js',
		'bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
		'bower_components/TipTip/jquery.tipTip.minified.js',
		'js/portfolio/thumbnailGridEffects.js',
		'js/portfolio/classie.js',
		'js/postlike.js',
		'js/jquery.tools.js',
		//'js/jquery.cycle.lite.js',
		//'bower_components/waypoints/lib/jquery.waypoints.min.js', not compatible with jquery.custom.js
		'js/waypoints.js',
		'js/sidebar.js',
		'js/jquery.custom.js',
		/*js files for the contact form 7 plugin*/
		//'../../plugins/contact-form-7/includes/js/jquery.form.js',
		//'../../plugins/contact-form-7/includes/js/scripts.js',
		//'js/contact-form-7/ajax-loader.js',
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
	.pipe(gulp.dest('js/dev/internal/portfolio/archive/'));
});
gulp.task('portarchdistjs',function(){
	return gulp.src([
		'js/dev/internal/portfolio/archive/main.js',
	])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(rename('main.min.js'))
	.pipe(uglify())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/js/internal/portfolio/archive/'));
});
gulp.task('portarchsassruby', function () {
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
	.pipe(sourcemaps.write('bin/maps/css/internal/portfolio/archive/'))
    .pipe(gulp.dest('./'));
});
gulp.task('portarchuncss', function () {
    return gulp.src('bin/css/internal/portfolio/archive/style.css')
        .pipe(uncss({
            html: ['http://arch/portfolio/']
        }))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('bin/css/internal/portfolio/archive/uncss/'));
});
gulp.task('portarchuncssmiss',function(){
	return gulp.src([
		'bin/css/internal/portfolio/archive/uncss/style.css',
		'bin/css/internal/portfolio/archive/uncss/missing/*.css',
		//'bin/css/index/uncss/missing/animations_effects.css'
		//'bin/css/index/uncss/missing/*.css'
	])
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(concat('style.css'))
	.pipe(nano())
	.pipe(sourcemaps.write('/'))
	.pipe(gulp.dest('bin/css/internal/portfolio/archive/uncss/complete/'));
});
gulp.task('portarchcritical', function () {
    critical.generate({
        base: './',
        src: 'http://arch/portfolio/',
        dest: 'bin/css/internal/portfolio/archive/critical/styles.min.css.php',
        css: 'bin/css/internal/portfolio/archive/uncss/style.css',
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
gulp.task('portpenthouse', function () {
   penthouse({
       url: ['http://arch/portfolio/'],
       css: 'bin/css/internal/portfolio/archive/style.css',
        width: 1903,
        height: 955,
   }, function(err, criticalCss) {
	    if (err) { // handle error 
	    }
	    fs.writeFileSync('bin/css/internal/portfolio/archive/critical/styles.min.css.php', criticalCss);
	});
});