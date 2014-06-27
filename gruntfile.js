module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    //Directories
    bowerDir: 'public/vendor',
    assetsDir: 'public/assets',
    appDir: 'public/app/js',

    clean: ['<%= assetsDir %>/tmp'],

    // copy: {
    //   angular: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/angular',
    //       src: ['angular.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   angularCookies: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/angular-cookies',
    //       src: ['angular-cookies.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   bootstrap: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/bootstrap/less',
    //       src: ['bootstrap.less'],
    //       dest: '<%= assetsDir %>/tmp/bootstrap'
    //     }, {
    //       expand: true,
    //       cwd: '<%= bowerDir %>/bootstrap/dist/js',
    //       src: ['bootstrap.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }, {
    //       expand: true,
    //       cwd: '<%= bowerDir %>/bootstrap/dist/fonts',
    //       src: ['*'],
    //       dest: '<%= assetsDir %>/fonts'
    //     }]
    //   },
    //   animatecss: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/animate.css',
    //       src: ['animate.css'],
    //       dest: '<%= assetsDir %>/css'
    //     }]
    //   },
    //   fontawesome: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/font-awesome/less',
    //       src: ['font-awesome.less'],
    //       dest: '<%= assetsDir %>/tmp/font-awesome'
    //     }, {
    //       expand: true,
    //       cwd: '<%= bowerDir %>/font-awesome/font',
    //       src: ['*'],
    //       dest: '<%= assetsDir %>/fonts'
    //     }]
    //   },
    //   iehtml5: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ie-html5/dist',
    //       src: ['*'],
    //       dest: '<%= assetsDir %>/js'
    //     }, ]
    //   },
    //   iejson: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ie-json/lib',
    //       src: ['json3.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   lodash: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/lodash/dist',
    //       src: ['lodash.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ng: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng',
    //       src: ['angular.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngcaptcha: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-captcha/release',
    //       src: ['angular-recaptcha.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngcookies: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-cookies',
    //       src: ['angular-cookies.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngi18n: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-i18n',
    //       src: ['angular-locale_en.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngresource: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-resource',
    //       src: ['angular-resource.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngrest: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-rest/dist',
    //       src: ['restangular.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngrouter: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-router',
    //       src: ['angular-route.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngsanitize: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-sanitize',
    //       src: ['angular-sanitize.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngstorage: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-storage/src',
    //       src: ['angularLocalStorage.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngtranslate: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-translate',
    //       src: ['angular-translate.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngupload: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-upload/dist',
    //       src: ['angular-file-upload.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   uibootstrap: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ui-bootstrap',
    //       src: ['ui-bootstrap-tpls.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   uirouter: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ui-router/release',
    //       src: ['angular-ui-router.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngtable: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ng-table',
    //       src: ['ng-table.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   nganimate: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/angular-animate',
    //       src: ['angular-animate.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngprogress: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ngProgress/build',
    //       src: ['ngProgress.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }, {
    //       expand: true,
    //       cwd: '<%= bowerDir %>/ngProgress',
    //       src: ['ngProgress.css'],
    //       dest: '<%= assetsDir %>/css'
    //     }]
    //   },
    //   jquery: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/jquery/dist',
    //       src: ['jquery.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }]
    //   },
    //   ngloadbar: {
    //     files: [{
    //       expand: true,
    //       cwd: '<%= bowerDir %>/angular-loading-bar/src',
    //       src: ['loading-bar.js'],
    //       dest: '<%= assetsDir %>/js'
    //     }, {
    //       expand: true,
    //       cwd: '<%= bowerDir %>/angular-loading-bar/src',
    //       src: ['loading-bar.css'],
    //       dest: '<%= assetsDir %>/css'
    //     }]
    //   }
    // },

    less: {
      development: {
        options: {
          compress: true, //minifying the result
        },
        files: {
          //compiling frontend.less into frontend.css
          "<%= assetsDir %>/css/frontend.css": "<%= assetsDir %>/less/frontend.less",
          //compiling backend.css into backend.css
          "<%= assetsDir %>/css/backend.css": "<%= assetsDir %>/less/backend.less"
        }
      }
    },

    concat: {
      options: {
        separator: ';',
      },
      js_frontend: {
        src: [
          '<%= bowerDir %>/angular/angular.min.js',
          '<%= bowerDir %>/angular-cookies/angular-cookies.min.js',
          '<%= bowerDir %>/angular-animate/angular-animate.min.js',
          '<%= bowerDir %>/ng-i18n/angular-locale_pt-br.js',
          '<%= bowerDir %>/ng-resource/angular-resource.min.js',
          '<%= bowerDir %>/ng-rest/dist/ng-rest.js',
          '<%= bowerDir %>/ng-router/angular-route.min.js',
          '<%= bowerDir %>/ng-sanitize/angular-sanitize.min.js',
          '<%= bowerDir %>/ng-storage/src/angularLocalStorage.js',
          '<%= bowerDir %>/ng-translate/angular-translate.min.js',
          '<%= bowerDir %>/ng-upload/dist/angular-file-upload.js',
          '<%= bowerDir %>/ng-table/ng-table.js',
          '<%= bowerDir %>/ui-router/release/angular-ui-router.js',
          '<%= bowerDir %>/ui-bootstrap-tpls/ui-bootstrap-tpls.js',
          '<%= bowerDir %>/lodash/dist/lodash.min.js',
          '<%= bowerDir %>/jquery/dis/jquery.min.js',
          '<%= bowerDir %>/bootstrap/dist/js/bootstrap.min.js',
          '<%= bowerDir %>/ngProgress/ngProgress.js',

          '<%= assetsDir %>/js/frontend.js'
        ],
        dest: '<%= assetsDir %>/tmp/frontend-concat.js',
      },
      js_backend: {
        src: [
          '<%= bowerDir %>/angular/angular.min.js',
          '<%= bowerDir %>/angular-cookies/angular-cookies.min.js',
          '<%= bowerDir %>/angular-animate/angular-animate.min.js',
          '<%= bowerDir %>/ng-i18n/angular-locale_pt-br.js',
          '<%= bowerDir %>/ng-resource/angular-resource.min.js',
          '<%= bowerDir %>/ng-rest/dist/ng-rest.js',
          '<%= bowerDir %>/ng-router/angular-route.min.js',
          '<%= bowerDir %>/ng-sanitize/angular-sanitize.min.js',
          '<%= bowerDir %>/ng-storage/src/angularLocalStorage.js',
          '<%= bowerDir %>/ng-translate/angular-translate.min.js',
          '<%= bowerDir %>/ng-upload/dist/angular-file-upload.js',
          '<%= bowerDir %>/ng-table/ng-table.js',
          '<%= bowerDir %>/ui-router/release/angular-ui-router.js',
          '<%= bowerDir %>/ui-bootstrap-tpls/ui-bootstrap-tpls.js',
          '<%= bowerDir %>/lodash/dist/lodash.min.js',
          '<%= bowerDir %>/jquery/dis/jquery.min.js',
          '<%= bowerDir %>/bootstrap/dist/js/bootstrap.min.js',
          '<%= bowerDir %>/ngProgress/ngProgress.js',

          '<%= assetsDir %>/js/backend.js'
        ],
        dest: '<%= assetsDir %>/tmp/backend-concat.js',
      },
    },

    cssmin: {
      css_frontend: {
        options: {
          keepSpecialComments: 0
        },
        files: {
          '<%= assetsDir %>/css/frontend.min.css': ['<%= assetsDir %>/css/frontend.css'],
        }
      },
      css_backend: {
        options: {
          keepSpecialComments: 0
        },
        files: {
          '<%= assetsDir %>/css/backend.min.css': ['<%= assetsDir %>/css/backend.css'],
        }
      }
    },

    uglify: {
      options: {
        preserveComments: false
      },
      frontend: {
        files: {
          '<%= assetsDir %>/js/frontend.min.js': ['<%= assetsDir %>/tmp/frontend-concat.js']
        }
      },
      backend: {
        files: {
          '<%= assetsDir %>/js/backend.min.js': ['<%= assetsDir %>/tmp/backend-concat.js']
        }
      },
    },
    watch: {
      css: {
        files: ['<%= appDir %>/css/*.*'], //arquivos monitorados
        tasks: ['concat:css', 'uglify'], //tarefas executadas
        options: {
          livereload: true //atualiza o navegador
        }
      },
      js: {
        files: ['<%= appDir %>/js/*.*'], //arquivos monitorados
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

  grunt.registerTask('default', ['less', 'concat', 'cssmin', 'uglify', 'clean']);
  // grunt.registerTask('default', ['copy', 'less', 'concat', 'cssmin', 'uglify', 'clean']);
  grunt.registerTask('watching', ['less', 'concat', 'cssmin', 'clean']);

};