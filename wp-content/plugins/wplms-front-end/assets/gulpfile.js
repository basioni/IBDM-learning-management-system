var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    rimraf = require('gulp-rimraf'),
    gutil = require('gulp-util');


gulp.task('remove-styles', function() {
  return gulp.src('css/*.min.css', { read: false })
    .pipe(rimraf({ force: true }));
});

gulp.task('front-styles',['remove-styles'], function() {
  return sass('css/scss/front_end.scss', { style: 'nested' })
    .pipe(autoprefixer('last 2 version'))    
    .pipe(gulp.dest('css'))
    .pipe(notify({ message: 'WPLMS Front End Styles task complete' }));
});

gulp.task('styles',['front-styles'], function() {
  return gulp.src(['css/*.css'])    
    .pipe(concat('wplms_front_end.css'))
    .pipe(minifycss())    
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('css'))
    .pipe(notify({ message: 'Concatenation task complete' }));
});

gulp.task('remove-scripts', function() {
  return gulp.src('js/*.min.js', { read: false })
    .pipe(rimraf({ force: true }));
});

gulp.task('scripts',['remove-scripts'], function() {
  return gulp.src(['js/*.js'])
    .pipe(uglify().on('error', gutil.log))
    .pipe(concat('wplms_front_end.js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify().on('error', gutil.log))
    .pipe(gulp.dest('js'))
    .pipe(notify({ message: 'WPLMS Front End Scripts task complete' }));
});


gulp.task('front', ['styles','scripts']);