const   gulp = require('gulp'),
        postcss = require('gulp-postcss'),
        cssnext = require('postcss-cssnext'),
        gutil = require('gulp-util'),
        sourcemaps = require('gulp-sourcemaps'),

        source = 'development/',
        dest = 'production/public/';


gulp.task('css', function() {
    gulp.src(source + 'postcss/style.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([
            require('postcss-partial-import')({prefix: '_', extension: '.css'}),
            cssnext()
        ]))
        .on('error', gutil.log)
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(dest + 'css/'));
});

gulp.task('watch', function() {
    gulp.watch(source + '**/*.css', ['css']);
});


gulp.task('default', ['css','watch']);

