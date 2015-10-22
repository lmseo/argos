var gulp		= require('gulp');
var watch = require('gulp-watch');
var size 		= require('gulp-size');
var cache 		= require('gulp-cache');
var concat		= require('gulp-concat');
var rename		= require('gulp-rename');
var uglify		= require('gulp-uglify');
var runSequence	= require('run-sequence');
var nano 		= require('gulp-cssnano');
var sourcemaps 	= require('gulp-sourcemaps');
var postcss 	= require('gulp-postcss');
//var sass 		= require('gulp-sass');
var sass 		= require('gulp-ruby-sass');
var autoprefixer = require('gulp-autoprefixer');
var imagemin   	= require('gulp-imagemin');
var svgmin 		= require('gulp-svgmin');
var critical 	= require('critical');
var penthouse = require('penthouse'),
    path = require('path');
var uncss = require('gulp-uncss');
var fs = require('fs');
var browserSync = require('browser-sync').create();

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
gulp.task('clear', function (done) {
	return cache.clearAll(done);
});

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "http://arch"
    });
});

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
        src: 'index.html',
        dest: 'bin/css/index/critical/styles.min.css.php',
        css: 'bin/css/index/uncss/style.css',
        width: 320,
        height: 480,
        minify: true
    });
});

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
	    	loadPath:['scss/','bower_components/foundation/scss','bower_components/fontawesome/scss']
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
        src: 'bath.html',
        dest: 'bin/css/internal/portfolio/critical/styles.min.css.php',
        css: 'bin/css/internal/portfolio/uncss/complete/',
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
/*
*Quick calls
*/
gulp.task('default', function(callback){
	runSequence('intdevjs', 'intdistjs','inddevjs', 'inddistjs','portdevjs', 'portdistjs', callback);
});

//Watch
gulp.task('watch', function () {
  gulp.watch('scss/**/*.scss', ['sassruby']);
});

//index
gulp.task('indexstyle', function(callback){
	runSequence('sassruby', 'uncssindex','uncssindexmiss','criticalindex', callback);
});
gulp.task('indexjs', function(callback){
	runSequence('inddevjs', 'inddistjs', callback);
});
//internal
gulp.task('intstyle', function(callback){
	runSequence('intsassruby', callback);
});
gulp.task('intjs', function(callback){
	runSequence('intdevjs', 'intdistjs', callback);
});

//portfolio archive
gulp.task('portarchstyle', function(callback){
	runSequence('portarchsassruby', 'portarchuncss','portarchuncssmiss','portarchcritical', callback);
});
gulp.task('portjs', function(callback){
	runSequence('portarchdevjs', 'portarchdistjs', callback);
});
//portfolio single
gulp.task('portstyle', function(callback){
	runSequence('portsassruby', 'portuncss','portuncssmiss','portcritical', callback);
});
gulp.task('portjs', function(callback){
	runSequence('portdevjs', 'portdistjs', callback);
});
//Slider Template
gulp.task('slidertempstyle', function(callback){
	runSequence('slidertempsassruby', 'slidertempuncss','slidertempuncssmiss','slidertempcritical', callback);
});
gulp.task('slidertempjs', function(callback){
	runSequence('slidertempdevjs', 'slidertempdistjs', callback);
});