module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                separator: ';'
            },
            admin: {
                src: [
                    '../../public/js/admin/packages/core.js',
                    '../../public/js/admin/packages/*.js'
                ],
                dest: '../../public/js/admin/admin.js'
            },
            client: {
                src: [
                    '../../public/js/client/packages/core.js',
                    '../../public/js/client/packages/*.js'
                ],
                dest: '../../public/js/client/client.js'
            },
        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
            },
            admin: {
                files: {
                    '../../public/js/admin/admin.min.js': ['<%= concat.admin.dest %>']
                }
            },
            client: {
                files: {
                    '../../public/js/client/client.min.js': ['<%= concat.client.dest %>']
                }
            }
        },
        less: {
            admin: {
                options: {
                    paths: ["../../public/css/admin/", '../../public/css/client/packages/core.css']
                },
                files: {
                    "../../public/css/admin/admin.css": "../../public/css/admin/admin.less"
                }
            },
            client: {
                options: {
                    paths: ["../../public/css/client/"]
                },
                files: {
                    "../../public/css/client/client.css": "../../public/css/client/client.less"
                }
            }
        },
        cssmin: {
            admin: {
                options:{
                    keepSpecialComments:0
                },
                files: {
                    "../../public/css/admin/admin.min.css": ["../../public/css/admin/admin.css"]
                }
            },
            client: {
                options:{
                    keepSpecialComments:0
                },
                files: {
                    "../../public/css/client/client.min.css": ["../../public/css/client/client.css"]
                }
            }
        },
        jshint: {
            files: [
                'gruntfile.js',
                '../../public/js/admin/packages/*.js',
                '../../public/js/client/packages/*.js'
            ],
            options: {
                // options here to override JSHint defaults
                globals: {
                    jQuery: true,
                    console: true,
                    module: true,
                    document: true
                }
            }
        },
        watch: {
            /*test: {
             files: ['<%= jshint.files %>'],
             tasks: ['jshint', 'qunit']
             },*/
            jsAdmin: {
                files: ['<%= concat.admin.src %>'],
                tasks: ['jsAdmin']
            },
            cssAdmin: {
                files: ['../../public/css/admin/packages/*'],
                tasks: ['cssAdmin']
            },
            jsClient: {
                files: ['<%= concat.client.src %>'],
                tasks: ['jsClient']
            },
            cssClient: {
                files: ['../../public/css/client/packages/*'],
                tasks: ['cssClient']
            }
        },
        closureCompiler:  {

            options: {
                compilerFile: '../compiler.jar',
                checkModified: true,
                compilerOpts: {
                    compilation_level: 'SIMPLE_OPTIMIZATIONS',
                    externs: ['externs/*.js'],
                    //define: ["'goog.DEBUG=false'"],
                    warning_level: 'verbose',
                    jscomp_off: ['checkTypes', 'fileoverviewTags'],
                    summary_detail_level: 3,
                    output_wrapper: '"(function(){%output%}).call(this);"'
                },
                execOpts: {
                    maxBuffer: 999999 * 1024
                }
            },
            adminKacana: {
                src: '../../public/js/admin/admin.js',
                dest: '../../public/js/admin/admin.compile.js'
            },
            clientKacana: {
                src: '../../public/js/client/client.js',
                dest: '../../public/js/client/client.compile.js'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-closure-tools');

    grunt.registerTask('test', ['jshint']);

    grunt.registerTask('default', ['concat', 'uglify', 'less', 'cssmin']);

    grunt.registerTask('jsAdmin', ['concat:admin', 'uglify:admin']);
    grunt.registerTask('closure', ['closureCompiler:admin']);
    grunt.registerTask('cssAdmin', ['less:admin','cssmin:admin']);

    grunt.registerTask('jsClient', ['concat:client', 'uglify:client']);
    grunt.registerTask('closure', ['closureCompiler:client']);
    grunt.registerTask('cssClient', ['less:client','cssmin:client']);

};