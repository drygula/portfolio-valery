const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');
const browserSync = require('browser-sync').create();

/* ---------- PATHS ---------- */
const paths = {
	scss: 'src/scss/style.scss',
	scssWatch: 'src/scss/**/*.scss',
	js: 'src/js/**/*.js',
	html: './*.html',
	dist: '',
};

/* ---------- STYLES ---------- */
function styles() {
	return src(paths.scss)
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(autoprefixer())
		.pipe(concat('style.css'))
		.pipe(cleanCSS())
		.pipe(rename({ suffix: '.min' }))
		.pipe(sourcemaps.write('.'))
		.pipe(dest(paths.dist + 'css'))
		.pipe(browserSync.stream());
}

/* ---------- SCRIPTS ---------- */
function scripts() {
	return src(paths.js)
		.pipe(sourcemaps.init())
		.pipe(concat('main.min.js'))
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(dest(paths.dist + 'js'))
		.pipe(browserSync.stream());
}

/* ---------- SERVER ---------- */
function serve() {
	browserSync.init({
		server: { baseDir: './' },
	});

	watch(paths.scssWatch, styles);
	watch(paths.js, scripts);
	watch(paths.html).on('change', browserSync.reload);
}

/* ---------- EXPORTS ---------- */
exports.styles = styles;
exports.scripts = scripts;
exports.default = series(parallel(styles, scripts), serve);
exports.build = series(parallel(styles, scripts));
