var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir.config.css.autoprefix.options.browsers =  ['last 15 versions'] ;

var gulp = require('gulp');
var concat = require('gulp-concat');

var paths = {
    "public" : "./theme",
    "src" : "./resources"
}

elixir.config.assetsPath = paths.src;
elixir.config.publicPath = paths.public;

// Generate file with wordpress meta
gulp.task('join', function(){
    var path = paths.public +  '/css/';
    var meta = paths.src + "/css/meta.css";


    return gulp.src([
        meta, path + "style.css"])
        .pipe(concat("style.css"))
        .pipe(gulp.dest(paths.public));
});


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir(function(mix) {
    mix.sass('style.sass');
    mix.webpack('app.js', paths.public + '/js/app.js');

    mix.browserSync({
        proxy: '192.168.1.191'
    });     

    gulp.start('join');
});