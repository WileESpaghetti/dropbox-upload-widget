module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON("package.json"),
    pluginHeader: [
      '',
      'Plugin Name: Dropbox Upload Widget',
      'Plugin URI:  <%= pkg.homepage %>',
      'Description: <%= pkg.description %>',
      'Version:     <%= pkg.version %>',
      'Author:      <%= pkg.author.name %>',
      'Author URI:  <%= pkg.author.url %>',
      'License:     <%= pkg.license.type %>',
      'License URI: <%= pkg.license.url %>',
      'Domain Path: /languages',
      'Text Domain: <%= pkg.name %>',
      ''
    ].join('\n'),

    copy: {
      build: {
        src:  ['<%= pkg.name  %>.php', 'inc/**'],
        dest: 'build/'
      }
    },

    usebanner: {
      plugin: {
        options: {
          position: 'replace',
          banner: '<%= pluginHeader %>',
          replace: ' {{PluginHeader}} ',
          linebreak: false
        },
        files: {
          src: [ 'build/<%= pkg.name %>.php']
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-banner');

  grunt.registerTask('build', ['copy:build', 'usebanner:plugin']);
  grunt.registerTask('default', ['build']);
};
