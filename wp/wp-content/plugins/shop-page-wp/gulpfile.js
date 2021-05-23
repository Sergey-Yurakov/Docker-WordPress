/**
 *  Initialize Gulp
 */
const gulp = require('gulp');

/**
 *  Load Gulp Dependencies
 */
const sass = require('gulp-sass');
const minifycss = require('gulp-minify-css');
const rename = require('gulp-rename');
const util = require('gulp-util');
const wpPot = require('gulp-wp-pot');

/**
 * SCSS Task
 */
gulp.task('scss-base', function (done) {
    gulp.src(['assets/scss/shop-page-wp-base-styles.scss'])
        .pipe(sass({style: 'compressed', errLogToConsole: true}))
        .pipe(rename('shop-page-wp-base-styles.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('assets/css'));
    util.log(util.colors.red('> > > base styles compiled < < <'));
    done();
});

gulp.task('scss-grid', function (done) {
    gulp.src(['assets/scss/shop-page-wp-grid.scss'])
        .pipe(sass({style: 'compressed', errLogToConsole: true}))
        .pipe(rename('shop-page-wp-grid.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('assets/css'));
    util.log(util.colors.red('> > > grid styles compiled < < <'));
    done();
});

gulp.task('scss-admin', function (done) {
    gulp.src(['assets/scss/shop-page-wp-admin-styles.scss'])
        .pipe(sass({style: 'compressed', errLogToConsole: true}))
        .pipe(rename('shop-page-wp-admin-styles.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('assets/css'));
    util.log(util.colors.red('> > > admin styles compiled < < <'));
    done();
});

/**
 * Watch Task
 */
gulp.task('watch', function () {

    /**
     *  Watch PHP files for changes
     */
    var php = '**/*.php';
    gulp.watch(php).on('change', function (file) {
        util.log(util.colors.blue('[ ' + file.path + ' ]'));
    });

    /**
     *  Watch SCSS files for changes
     */
    gulp.watch('assets/scss/**/shop-page-wp-base-styles.scss', gulp.series('scss-base'));
    gulp.watch('assets/scss/**/shop-page-wp-grid.scss', gulp.series('scss-grid'));
    gulp.watch('assets/scss/**/shop-page-wp-admin-styles.scss', gulp.series('scss-admin'));
});

/**
 * Default Task
 */
gulp.task('default', gulp.series('scss-base', 'scss-grid', 'scss-admin', 'watch'));


/**
 * Generate Pot Files
 */
gulp.task('pot', function () {
    return gulp.src('**/*.php')
        .pipe(wpPot( {
            domain: 'shop-page-wp',
            package: 'Shop_Page_WP'
        } ))
        .pipe(gulp.dest('languages/shop-page-wp.pot'));
});
