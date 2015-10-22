module.exports = function(grunt) {
	var mozjpeg = require('imagemin-mozjpeg');
	//require('load-grunt-tasks')(grunt);
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		jshint: {
		    all: ['bin/js/<%= pkg.name %>.js']
		},
		svgmin: {
	        options: {
	            plugins: [
				    { removeViewBox: false },               // don't remove the viewbox atribute from the SVG
				    { removeUselessStrokeAndFill: false },  // don't remove Useless Strokes and Fills
				    { removeEmptyAttrs: false }             // don't remove Empty Attributes from the SVG
				]
	        },
	        dist: {
	           files: [{
					expand: true,                  // Enable dynamic expansion
					cwd: 'bin/images/',                   // Src matches are relative to this path
					src: ['**/*.svg'],   // Actual patterns to match
					dest: 'images/'                  // Destination path prefix
				}]
	        }
	    },
		imagemin: {                          // Task
			/*static: {                          // Target
				options: {                       // Target options
					optimizationLevel: 3,
					svgoPlugins: [{ removeViewBox: false }],
					use: [mozjpeg()]
				},
				files: {                         // Dictionary of files
					'dist/img.png': 'src/img.png', // 'destination': 'source'
					'dist/img.jpg': 'src/img.jpg',
					'dist/img.gif': 'src/img.gif'
				}
			},*/
			dynamic: {                         // Another target
				files: [{
					expand: true,                  // Enable dynamic expansion
					cwd: 'bin/images/',                   // Src matches are relative to this path
					src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
					dest: 'images/'                  // Destination path prefix
				}]
			}
		},
		postcss: {
			options: {
				map: true, // inline sourcemaps
				// or
				map: {
				  inline: false, // save all sourcemaps as separate files...
				  annotation: 'bin/css/maps/' // ...to the specified directory
				},
				processors: [
					require('pixrem')(), // add fallbacks for rem units
					require('autoprefixer-core')(
						{browsers: ['> 1%', 'last 2 versions', 'Firefox > 20','iOS 7','ie 8','ie 9','Opera > 20']
					}), // add vendor prefixes
					require('cssnano')() // minify the result
				]
			},
			dist: {
			  src: '*.css',
			}
		},
		watch:{
			jsint: {
		    files: ['js/*.js'],
		    tasks: ['concat:internal', 'uglify:internal'],
				options: {
				  spawn: false,
				}
			},
			jsind: {
		    files: ['js/*.js'],
		    tasks: ['concat:index', 'uglify:index'],
				options: {
				  spawn: false,
				}
			},
			images: {
				files: ['images/**/*.{png,jpg,gif}', 'images/*.{png,jpg,gif}'],
				tasks: ['imagemin:dynamic'],
				options: {
				  spawn: false,
				}
			},
			cssdev: {
				files: ['scss/*.scss', 'scss/**/*.scss','scss/**/**/*.scss'],
				//tasks: ['sass:dist', 'postcss'],
				tasks: ['sass:dist'],
				options: {
				  spawn: false,
				}
			},
			css: {
				files: ['scss/*.scss', 'scss/**/*.scss','scss/**/**/*.scss'],
				tasks: ['sass:dist', 'postcss'],
				options: {
				  spawn: false,
				}
			},
		},
		concat: {
		  options: {
		    // define a string to put between each file in the concatenated output
		    separator: '\n',
		    sourceMap:true
		  },
		  internal: {
		    // the files to concatenate
		    src: [
		    	'js/modernizr.custom.js',
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
		    	],
		    // the location of the resulting JS file
		    dest: 'js/dev/internal/main.js'
		  },
		  index: {
		    // the files to concatenate
		    src: [
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
		    	],
		    // the location of the resulting JS file
		    dest: 'js/dev/index/main.js'
		  }
		},
		uglify: {
			options: {
			    	banner: ' /*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */',
					sourceMap: true,
			},
		    internal: {
		    	options: {
					sourceMapName: 'bin/js/internal/main.min.js.map',
					sourceMapIncludeSources: true,
        			sourceMapIn: 'js/dev/internal/main.js.map',
			    },
				files: {
				'bin/js/internal/main.min.js': ['js/dev/internal/main.js']
				}
			},
			index: {
		    	options: {
					sourceMapName: 'bin/js/index/main.min.js.map',
					sourceMapIncludeSources: true,
        			sourceMapIn: 'js/dev/index/main.js.map',
			    },
				files: {
				'bin/js/index/main.min.js': ['js/dev/index/main.js']
				}
			}
		},
		sass: {                              // Task
		    dev: {                            // Target
				options: {                       // Target options
					style: 'expanded',
					//compass:true,
					trace:true,
					//debugInfo:true,
					lineNumbers:true,
					loadPath:['scss/','bower_components/foundation/scss','bower_components/fontawesome/scss']
				},
				files: [{
						expand: true,
						cwd: 'scss/',
						src: ['*.scss', '**/*.scss','**/**/*.scss'],
						dest: '',
						ext: '.css'
					}]
		    },
		    dist: {                            // Target
				options: {                       // Target options
					style: 'expanded',
					//compass:true,
					loadPath:['scss/','bower_components/foundation/scss','bower_components/fontawesome/scss']
				},
					files: [{
						expand: true,
						cwd: 'scss/',
						src: ['*.scss', '**/*.scss','**/**/*.scss'],
						dest: '',
						ext: '.css'
					}]
		    }
	  	}
	});
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-svgmin');

  //tasks 
	grunt.registerTask('default', ['concat', 'imagemin:dynamic', 'sass:dev','postcss' ]);
	grunt.registerTask('jsi', ['concat:index','uglify:index']);
	grunt.registerTask('jsn', ['concat:internal','uglify:internal']);
	grunt.registerTask('js', ['concat:internal','uglify:internal','concat:index','uglify:index']);
	grunt.registerTask('post', ['sass:dist','postcss']);
};