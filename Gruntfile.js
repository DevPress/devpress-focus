'use strict';
module.exports = function(grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

		grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			files: ['scss/*.scss'],
			tasks: 'sass',
			options: {
				livereload: true,
			},
		},
		sass: {
			default: {
				options : {
					style : 'expanded'
					},
				files: {
					'style.css':'scss/style.scss',
				}
			}
		},
		postcss: {
			options: {
				map: true,
				processors: [
					require('autoprefixer-core')({browsers: 'last 2 versions'}),
				]
			},
			files: {
				'style.css': 'style.css'
			}
		},
		concat: {
			build: {
				src: [
					'js/skip-link-focus-fix.js',
					'js/jquery.fitvids.js',
					'js/theme.js'
					],
				dest: 'js/focus.min.js',
				}
		},
		uglify: {
			build: {
				src: 'js/focus.min.js',
				dest: 'js/focus.min.js'
				}
			},
		makepot: {
			target: {
				options: {
					domainPath: '/languages/',
					potFilename: 'focus.pot',
					potHeaders: {
					poedit: true, // Includes common Poedit headers.
					'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
				},
				type: 'wp-theme',
				updateTimestamp: false,
				updatePoFiles: true,              // Whether to update PO files in the same directory as the POT file.
				processPot: function( pot, options ) {
					pot.headers['report-msgid-bugs-to'] = 'https://devpress.com';
					pot.headers['last-translator'] = 'DevPress (https://devpress.com)';
					pot.headers['language-team'] = 'DevPress <support@devpress.com>';
					pot.headers['language'] = 'en_US';
					var translation, // Exclude meta data from pot.
					excluded_meta = [
						'Theme Name of the plugin/theme',
						'Theme URI of the plugin/theme',
						'Author of the plugin/theme',
						'Author URI of the plugin/theme'
						];
						for ( translation in pot.translations[''] ) {
							if ( 'undefined' !== typeof pot.translations[''][ translation ].comments.extracted ) {
								if ( excluded_meta.indexOf( pot.translations[''][ translation ].comments.extracted ) >= 0 ) {console.log( 'Excluded meta: ' + pot.translations[''][ translation ].comments.extracted );
								delete pot.translations[''][ translation ];
							}
						}
					}
					return pot;
					}
				}
			}
		},
		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
					src: 'style.css',
					dest: 'style-rtl.css'
				}
				]
			}
		},
		replace: {
			styleVersion: {
				src: [
					'scss/style.scss',
				],
				overwrite: true,
				replacements: [{
					from: /Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				}]
			},
			functionsVersion: {
				src: [
					'functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'FOCUS_VERSION'.*$/m,
					to: 'define( \'FOCUS_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			},
		}
	});

	grunt.registerTask( 'default', [
		'sass',
		'postcss'
	]);

	grunt.registerTask( 'release', [
		'replace',
		'sass',
		'postcss',
		'concat:build',
		'uglify:build',
		'makepot',
		'cssjanus'
	]);

};
