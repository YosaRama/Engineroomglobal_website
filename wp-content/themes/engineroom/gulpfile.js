// Use node v10.16.0
// run: gulp && gulp watch

const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const cleancss = require('gulp-clean-css');
// const sourcemaps = require('gulp-sourcemaps');

gulp.task('default', function() {
    return gulp.src('./assets/scss/**/*.scss')
        // .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        }))
        .pipe(cleancss({
            format: 'beautify'
        }))
        .pipe(concat('theme.css'))
        // .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('watch', function(){
    gulp.watch('./assets/scss/**/*.scss', gulp.series('default')); 
});

