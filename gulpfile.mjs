import gulp from 'gulp';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import csso from 'gulp-csso';

const { series, parallel, src, dest, task } = gulp;
const sass = gulpSass( dartSass );

function scss() {

	return src( 'public/assets/scss/magic-ai.scss' )
		.pipe( sass.sync() )
		.pipe( csso() )
		.pipe( dest( 'public/assets/css' ) );

}

export function watch() {
	gulp.watch(
        [ 'public/assets/scss/**/*.scss' ],
		series(
			parallel( scss )
		)
	);
}

export const build = series(
	parallel( scss )
);