module.exports = function(grunt) {
	'use strict';

	grunt.initConfig({
		pkg: grunt.file.readJSON( 'package.json' ),

		replace : {
			readme: {
				options: {
					patterns: [
						{
							match: /Stable tag:\s?(.+)/gm,
							replacement: 'Stable tag: <%= pkg.version %>'
						}
					]
				},
				files: [
					{
						expand: true, flatten: true, src: ['readme.txt'], dest: './'
					}
				]
			},
			main: {
				options: {
					patterns: [
						{
							match: /Version:\s?(.+)/gm,
							replacement: 'Version: <%= pkg.version %>'
						}
					]
				},
				files: [
					{
						expand: true, flatten: true, src: ['<%= pkg.main_file %>'], dest: './'
					}
				]
			},
			class: {
				options: {
					patterns: [
						{
							match: /define\( \'NS_NEPALI_DATE_VERSION\'\, \'(.+)\'/gm,
							replacement: "define( 'NS_NEPALI_DATE_VERSION', '<%= pkg.version %>'"
						}
					]
				},
				files: [
					{
						expand: true, flatten: true, src: ['<%= pkg.main_file %>'], dest: './'
					}
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-replace');

	grunt.registerTask('version', ['replace:readme', 'replace:main', 'replace:class']);
};
