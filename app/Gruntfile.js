module.exports = function(grunt) {
	grunt.initConfig({
		cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'css/',
                    src: ['*.css', '!*.min.css'],
                    dest: 'css/',
                    ext: '.min.css'
                }]
            }
        },
        uglify: {
            my_target: {
                files: {
                    'js/main.min.js': ['js/main.js'],
                    'js/home.min.js': ['js/home.js']
                }
            }
        },
		sass: {
			dist: {
				files: {
					'css/main.css': 'scss/main.scss'
				}
			}
		},
		watch: {
			sass: {
				files: ['scss/*.scss'],
				tasks: ['sass', 'cssmin']
			},
			js: {
				files: ['js/main.js', 'js/home.js'],
				tasks: ['uglify']
			},
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify-es');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['watch']);
};
