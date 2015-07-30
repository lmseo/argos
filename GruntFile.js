module.exports = function(grunt) {
	var mozjpeg = require('imagemin-mozjpeg');
	//require('load-grunt-tasks')(grunt);
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
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
					cwd: 'images/',                   // Src matches are relative to this path
					src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
					dest: 'dist/images/'                  // Destination path prefix
				}]
			}
		},
		postcss: {
			options: {
				map: true, // inline sourcemaps
				// or
				map: {
				  inline: false, // save all sourcemaps as separate files...
				  annotation: 'dist/css/maps/' // ...to the specified directory
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
			scripts: {
		    files: ['js/*.js'],
		    tasks: ['jshint', 'concat', 'uglify'],
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
				files: ['scss/*.scss'],
				//tasks: ['sass:dist', 'postcss'],
				tasks: ['sass:dist'],
				options: {
				  spawn: false,
				}
			},
			css: {
				files: ['scss/*.scss', 'scss/**/*.scss','scss/**/**/*.scss'],
				tasks: ['sass:dist', 'postcss'],
				tasks: ['sass:dist'],
				options: {
				  spawn: false,
				}
			},
		},
		concat: {
		  options: {
		    // define a string to put between each file in the concatenated output
		    separator: '\n'
		  },
		  dist: {
		    // the files to concatenate
		    src: ['js/**/*.js'],
		    // the location of the resulting JS file
		    dest: 'bin/js/<%= pkg.name %>.js'
		  }
		},
		uglify: {
		    options: {
		      banner: '! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> '
		    },
		    my_target: {
				files: {
				'js/<%= pkg.name %>.min.js': ['bin/js/<%= pkg.name %>.js']
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
					lineNumbers:true
				},
				files: {                         // Dictionary of files
					'dev-style.css': 'scss/style.scss'
				}
		    },
		    dist: {                            // Target
				options: {                       // Target options
					style: 'expanded',
					//compass:true,
					loadPath:['bower_components/foundation/scss','bower_components/fontawesome/scss','include/shortcodes/scss']
				},
					files: [{
						expand: true,
						cwd: 'scss/',
						src: ['*.scss'],
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

  //tasks 
	//grunt.registerTask('scss', ['sass:dev']);
	grunt.registerTask('scssd', ['sass:dist']);
	grunt.registerTask('default', ['concat', 'imagemin:dynamic', 'sass:dev','postcss' ]);
	//grunt.registerTask('justjs', ['concat', 'uglify']);
	grunt.registerTask('wt', ['watch']);
	grunt.registerTask('wtcd', ['watch:cssdev']);
	grunt.registerTask('wtc', ['watch:css']);
	//grunt.registerTask('post', ['sass:dist','postcss']);
};