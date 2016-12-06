'use strict';

import gulp from 'gulp';
import babel from 'gulp-babel';
import uglify from 'gulp-uglify';
import rename from 'gulp-rename';
import runSequence from 'run-sequence';
import path from 'path';
import del from 'del';

const paths = {
	js: {
		src: ['./assets/build/pikaday.js'],
		dest: './assets/js'
	}
}

/**
 * Script build task for all scripts.
 * example: $ gulp scripts
 */
gulp.task('scripts', () => {

	return gulp.src(paths.js.src)
		.pipe(babel({
			presets: ['es2015']
		}))
		.pipe(gulp.dest(paths.js.dest))
		.pipe(rename({'suffix': '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(paths.js.dest));
});

/**
 * Clean task for scripts.
 * example: $ gulp clean
 */
gulp.task( 'clean', () => {
	return del([path.join(paths.js.dest, '*.js')]);
});

/**
 * Run the clean and build tasks in sequence. 
 * example: $ gulp
 */
gulp.task( 'default', () => {
	runSequence( 'clean', 'scripts' );
} );