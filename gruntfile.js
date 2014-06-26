module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		//Directories
		bowerDir: 'public/vendor',
		assetsDir: 'public/assets',
		appDir: 'public/app/js',

		clean: ['<%= assetsDir %>/tmp'],

		copy: {
			angular: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/angular',
					src: ['angular.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			angularCookies: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/angular-cookies',
					src: ['angular-cookies.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			bootstrap: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/bootstrap/less',
					src: ['bootstrap.less'],
					dest: '<%= assetsDir %>/tmp/bootstrap'
				}, {
					expand: true,
					cwd: '<%= bowerDir %>/bootstrap/dist/js',
					src: ['bootstrap.js'],
					dest: '<%= assetsDir %>/js'
				}, {
					expand: true,
					cwd: '<%= bowerDir %>/bootstrap/dist/fonts',
					src: ['*'],
					dest: '<%= assetsDir %>/fonts'
				}]
			},
			animatecss: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/animate.css',
					src: ['animate.css'],
					dest: '<%= assetsDir %>/css'
				}]
			},
			fontawesome: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/font-awesome/less',
					src: ['font-awesome.less'],
					dest: '<%= assetsDir %>/tmp/font-awesome'
				}, {
					expand: true,
					cwd: '<%= bowerDir %>/font-awesome/font',
					src: ['*'],
					dest: '<%= assetsDir %>/fonts'
				}]
			},
			iehtml5: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ie-html5/dist',
					src: ['*'],
					dest: '<%= assetsDir %>/js'
				}, ]
			},
			iejson: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ie-json/lib',
					src: ['json3.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			lodash: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/lodash/dist',
					src: ['lodash.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ng: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng',
					src: ['angular.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngcaptcha: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-captcha/release',
					src: ['angular-recaptcha.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngcookies: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-cookies',
					src: ['angular-cookies.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngi18n: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-i18n',
					src: ['angular-locale_en.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngresource: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-resource',
					src: ['angular-resource.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngrest: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-rest/dist',
					src: ['restangular.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngrouter: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-router',
					src: ['angular-route.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngsanitize: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-sanitize',
					src: ['angular-sanitize.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngstorage: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-storage/src',
					src: ['angularLocalStorage.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngtranslate: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-translate',
					src: ['angular-translate.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngupload: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-upload/dist',
					src: ['angular-file-upload.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			uibootstrap: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ui-bootstrap',
					src: ['ui-bootstrap-tpls.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			uirouter: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ui-router/release',
					src: ['angular-ui-router.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngtable: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ng-table',
					src: ['ng-table.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			nganimate: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/angular-animate',
					src: ['angular-animate.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngprogress: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/ngProgress/build',
					src: ['ngProgress.js'],
					dest: '<%= assetsDir %>/js'
				},{
					expand: true,
					cwd: '<%= bowerDir %>/ngProgress',
					src: ['ngProgress.css'],
					dest: '<%= assetsDir %>/css'
				}
				]
			},
			jquery: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/jquery/dist',
					src: ['jquery.js'],
					dest: '<%= assetsDir %>/js'
				}]
			},
			ngloadbar: {
				files: [{
					expand: true,
					cwd: '<%= bowerDir %>/angular-loading-bar/src',
					src: ['loading-bar.js'],
					dest: '<%= assetsDir %>/js'
				}, {
					expand: true,
					cwd: '<%= bowerDir %>/angular-loading-bar/src',
					src: ['loading-bar.css'],
					dest: '<%= assetsDir %>/css'
				}]
			}
		},

		less: {
			development: {
				options: {
					ieCompat: true,
					yuicompress: true,
					compress: true, //minifica o resultado
				},
				files: {
					//compilando frontend.less em frontend.css
					"<%= assetsDir %>/css/frontend.css": "<%= assetsDir %>/less/frontend.less",
					//compilando backend.less em backend.css
					"<%= assetsDir %>/css/backend.css": "<%= assetsDir %>/less/backend.less"
				}
			},
			fontawesome: {
				options: {
					ieCompat: true,
					yuicompress: true,
					paths: ['<%= assetsDir %>/less/font-awesome', '<%= assetsDir %>/tmp/font-awesome', '<%= bowerDir %>/font-awesome/less']
				},
				files: {
					'<%= assetsDir %>/font-awesome.css': '<%= assetsDir %>/less/font-awesome/main.less'
				}
			}
		},
		concat: {
			css: {
				src: ['<%= assetsDir %>/css/frontend.css', '<%= assetsDir %>/css/bootstrap.css', '<%= assetsDir %>/css/ngProgress.css', '<%= assetsDir %>/css/animate.css', '<%= assetsDir %>/css/font-awesome.css'],
				dest: '<%= assetsDir %>/tmp/concat-front.css'
			},
			js: {
				src: [
					'<%= assetsDir %>/js/angular.js',
					'<%= assetsDir %>/js/angular-cookies.js',
					'<%= assetsDir %>/js/lodash.js',
					'<%= assetsDir %>/js/angular-locale_en.js',
					'<%= assetsDir %>/js/angular-resource.js',
					'<%= assetsDir %>/js/restangular.js',
					'<%= assetsDir %>/js/angular-route.js',
					'<%= assetsDir %>/js/angular-sanitize.js',
					'<%= assetsDir %>/js/angularLocalStorage.js',
					'<%= assetsDir %>/js/angular-translate.js',
					'<%= assetsDir %>/js/angular-file-upload.js',
					'<%= assetsDir %>/js/ui-bootstrap-tpls.js',
					'<%= assetsDir %>/js/angular-ui-router.js',
					'<%= assetsDir %>/js/ng-table.js',
					'<%= assetsDir %>/js/jquery.js',
					'<%= assetsDir %>/js/bootstrap.js',
					'<%= assetsDir %>/js/loading-bar.js',
					'<%= assetsDir %>/js/angular-animate.js',
					'<%= assetsDir %>/js/ngProgress.js'
				],
				dest: '<%= assetsDir %>/tmp/concat.js'
			},
			appjs: {
				src: [
					'<%= appDir %>/app.js',
					'<%= appDir %>/controllers.js',
					'<%= appDir %>/directives.js',
					'<%= appDir %>/filters.js',
					'<%= appDir %>/services.js'
				],
				dest: '<%= assetsDir %>/tmp/app-concat.js'
			}
		},
		
		cssmin: {
			css: {
				options: {
					keepSpecialComments: 0
				},
				files: {
					'<%= assetsDir %>/frontend.min.css': ['<%= assetsDir %>/tmp/concat-front.css'],
				}
			}
		},

		uglify: {
			options: {
				preserveComments: false
			},
			my_target: {
				files: {
					'<%= assetsDir %>/script.min.js': ['<%= assetsDir %>/tmp/concat.js']
				}
			},
			my_target_app: {
				files: {
					'<%= assetsDir %>/app.min.js': ['<%= assetsDir %>/tmp/app-concat.js']
				}
			}
		},
		watch: {
			js: {
				files: ['<%= appDir %>/css/*.*'], //arquivos monitorados
				tasks: ['concat:css', 'uglify'], //tarefas executadas
				options: {
					livereload: true //atualiza o navegador
				}
			},
			js: {
				files: ['<%= appDir %>/*.*'], //arquivos monitorados
				tasks: ['concat:javascript', 'uglify'], //tarefas executadas
				options: {
					livereload: true //atualiza o navegador
				}
			},
			less: {
				files: ['<%= assetsDir %>/less/**/*.less'], //arquivos monitorados
				tasks: ['less'], //tarefas executadas
				options: {
					livereload: true //atualiza o navegador
				}
			},
			tests: {
				files: ['app/controllers/*.php', 'app/models/*.php'], //a tarefa vai ser executada só quando salvar arquivo nessa localização
				tasks: ['phpunit']
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default', ['copy', 'less', 'concat', 'cssmin', 'uglify', 'clean']);
	grunt.registerTask('watching', ['less', 'concat', 'cssmin', 'clean']);

};