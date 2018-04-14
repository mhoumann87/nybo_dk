const   gulp = require('gulp'),
        postcss = require('gulp-postcss'),
        cssnext = require('postcss-cssnext'),
        gutil = require('gulp-util'),
        sourcemaps = require('gulp-sourcemaps'),
        concat = require('gulp-concat'),
        browserify = require('gulp-browserify'),
        uglify = require('gulp-uglify'),
        babel = require('gulp-babel'),

        source = 'development/',
        dest = 'production/public/',
        jsSources = [
            source + 'javascript/onLoad.js',
            source + 'javascript/menubar.js',
            source + 'javascript/contact.js',
            source + 'javascript/lightbox.js'
        ];

gulp.task('js', function() {
   gulp.src(jsSources)
       .pipe(concat('javascript.js'))
       .pipe(browserify())
       .pipe(babel({
           presets: ['es2015']
       }))
       //.pipe(uglify())
       .on('error', gutil.log)
       .pipe(gulp.dest(dest + 'javascript/'))
});

gulp.task('css', function() {
    gulp.src(source + 'postcss/style.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([
            require('postcss-partial-import')({prefix: '_', extension: '.css'}),
            require('postcss-nesting'),
            cssnext()
        ]))
        .on('error', gutil.log)
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(dest + 'css/'));
});

gulp.task('watch', function() {
    gulp.watch(source + '**/*.css', ['css']);
});


gulp.task('default', ['css', 'js', 'watch']);

