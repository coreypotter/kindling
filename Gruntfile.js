module.exports = function ( grunt ) {

	// require it at the top and pass in the grunt instance
	require( 'time-grunt' )( grunt );

	// Load all Grunt tasks
	require( 'jit-grunt' )( grunt, {
		makepot: 'grunt-wp-i18n'
	} );

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		// Concat and Minify our js.
		uglify: {
			dev: {
				files: {
					'assets/js/devs/chocolat.min.js': 'assets/js/devs/chocolat.js',
					'assets/js/devs/cookie.min.js': 'assets/js/devs/cookie.js',
					'assets/js/devs/customselect.min.js': 'assets/js/devs/customselect.js',
					'assets/js/devs/equalHeights.min.js': 'assets/js/devs/equalHeights.js',
					'assets/js/devs/fitvids.min.js': 'assets/js/devs/fitvids.js',
					'assets/js/devs/images-loaded.min.js': 'assets/js/devs/images-loaded.js',
					'assets/js/devs/isotope.min.js': 'assets/js/devs/isotope.js',
					'assets/js/devs/scrollTo.min.js': 'assets/js/devs/scrollTo.js',
					'assets/js/devs/sidr.min.js': 'assets/js/devs/sidr.js',
					'assets/js/devs/slick.min.js': 'assets/js/devs/slick.js',
					'assets/js/devs/smoothscroll.min.js': 'assets/js/devs/smoothscroll.js',
					'assets/js/devs/superfish.min.js': 'assets/js/devs/superfish.js',
					'assets/js/plugins.min.js': [ 'assets/js/devs/**/*.min.js' ],
				}
			},
			prod: {
				files: {
					'assets/js/main.min.js': [ 'assets/js/plugins.min.js', 'assets/js/main.js' ]
				}
			}
		},

		// Minify CSS
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1,
				keepSpecialComments: 0
			},
			prod: {
				files: {
					'assets/css/oceanwp-woocommerce.min.css': 'assets/css/oceanwp-woocommerce.css',
					'inc/welcome/css/welcome.min.css': 'inc/welcome/css/welcome.css'
				}
			}
		},

		// Compile our sass.
		sass: {
			dist: {
				options: {
					outputStyle: 'compressed',
					sourceMap: false,
				},
				files: {
					'style.css': 'sass/style.scss',
				}
			}
		},

		// Autoprefixer.
		autoprefixer: {
			options: {
				browsers: [
					'last 8 versions', 'ie 8', 'ie 9'
				]
			},
			main: {
				files: {
					'style.css': 'style.css',
				}
			}
		},

		// Newer files checker
		newer: {
			options: {
				override: function ( detail, include ) {
					if ( detail.task === 'php' || detail.task === 'sass' ) {
						include( true );
					} else {
						include( false );
					}
				}
			}
		},

		// Watch for changes.
		watch: {
			options: {
				livereload: true,
				spawn: false
			},
			scss: {
				files: [ 'sass/**/*.scss' ],
				tasks: [
					'newer:sass:dist',
					'newer:autoprefixer:main',
				]
			},
			js: {
				files: [ 'assets/js/**/*.js' ],
			}
		},

		// Images minify
		imagemin: {
			screenshot: {
				files: {
					'screenshot.png': 'screenshot.png'
				}
			},
			dynamic: {
				files: [ {
					expand: true,
					cwd: 'assets/img/',
					src: [ '**/*.{png,jpg,gif}' ],
					dest: 'assets/img/'
				} ]
			}
		},

		// Copy the theme into the build directory
		copy: {
			build: {
				expand: true,
				src: [
					'**',
					'!node_modules/**',
					'!bower_components/**',
					'!build/**',
					'!.git/**',
					'!Gruntfile.js',
					'!package.json',
					'!prepros.cfg',
					'!CONTRIBUTING.md',
					'!README.md',
					'!.csscomb.json',
					'!.tern-project',
					'!.gitignore',
					'!.jshintrc',
					'!.DS_Store',
					'!*.map',
					'!**/*.map',
					'!**/Gruntfile.js',
					'!**/package.json',
					'!**/*~'
				],
				dest: 'build/<%= pkg.name %>/'
			}
		},

		// Compress build directory into <name>.zip
		compress: {
			build: {
				options: {
					mode: 'zip',
					archive: './build/<%= pkg.name %>.zip'
				},
				expand: true,
				cwd: 'build/<%= pkg.name %>/',
				src: [ '**/*' ],
				dest: '<%= pkg.name %>/'
			}
		},

		// Clean up build directory
		clean: {
			build: [
				'build/<%= pkg.name %>',
				'build/<%= pkg.name %>.zip'
			]
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages/', // Where to save the POT file.
					exclude: [ // Exlude folder.
						'build/.*',
						'assets/.*',
						'readme/.*',
						'sass/.*',
						'bower_components/.*',
						'node_modules/.*'
					],
					potFilename: '<%= pkg.name %>.pot', // Name of the POT file.
					type: 'wp-theme', // Type of project (wp-plugin or wp-theme).
					updateTimestamp: true, // Whether the POT-Creation-Date should be updated without other changes.
					processPot: function ( pot, options ) {
						pot.headers[ 'plural-forms' ] = 'nplurals=2; plural=n != 1;';
						pot.headers[ 'last-translator' ] = 'CPotter\n';
						pot.headers[ 'language-team' ] = 'Kindling\n';
						pot.headers[ 'x-poedit-basepath' ] = '..\n';
						pot.headers[ 'x-poedit-language' ] = 'English\n';
						pot.headers[ 'x-poedit-country' ] = 'UNITED STATES\n';
						pot.headers[ 'x-poedit-sourcecharset' ] = 'utf-8\n';
						pot.headers[ 'x-poedit-searchpath-0' ] = '.\n';
						pot.headers[ 'x-poedit-keywordslist' ] = '_esc_attr__;esc_attr_x;esc_attr_e;esc_html__;esc_html_e;esc_html_x;__;_e;__ngettext:1,2;_n:1,2;__ngettext_noop:1,2;_n_noop:1,2;_c;_nc:4c,1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;\n';
						pot.headers[ 'x-textdomain-support' ] = 'yes\n';
						return pot;
					}
				}
			}
		}

	} );

	// Dev task
	grunt.registerTask( 'default', [
		'uglify:dev',
		'cssmin:prod',
		'sass:dist'
	] );

	// Production task
	grunt.registerTask( 'build', [
		'newer:uglify:prod',
		'newer:imagemin',
		'sass:dist',
		'autoprefixer:main',
		'copy'
	] );

	// Package task
	grunt.registerTask( 'package', [
		'compress',
	] );

};
