var elixir = require('laravel-elixir');
var gulp = require('gulp');
var gutil = require('gulp-util');
var ftp = require( 'vinyl-ftp' );
var git = require('gulp-git');

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
    mix.sass('app.scss').version('css/app.css')
    .browserify('app.js')
    .browserify('admin.js')
    .browserify('admin-activity.js')
    .browserify('admin-calendarevent.js')
    .browserify('tienda.js')

});

var conn = ftp.create( {
        host:     'ftp.cookingpoint.es',
        user:     'cookingpoint',
        password: 'Newuser01',
        parallel: 10,
        log:      gutil.log
    } );

var tienda_files = [
    'app/Http/routes.php',
    'app/Http/Controllers/TicketsController.php',
    'app/TiendaArticulo.php',
    'app/TiendaVentas.php',
    'database/migrations/**create_table_tienda_ventas.php',
    'database/migrations/**create_table_tienda_articulos.php',
    'public/build/css/app**css',
    'public/build/rev-manifest.json',
    'public/js/tienda.js',
    'resources/views/tienda/frontend.blade.php',
    'resources/views/tienda/index.blade.php',
    'resources/views/tienda/masterlayout.blade.php'
];


gulp.task( 'git-tienda', function () {
    return gulp.src( tienda_files )
        .pipe(git.add());
});


gulp.task( 'deploy-tienda', function () {


    var destFolder = '/test_bs';

    // using base = '.' will transfer everything to /public_html correctly
    // turn off buffering in gulp.src for best performance

    return gulp.src( tienda_files, { base: '.', buffer: false } )
        .pipe( conn.newer( destFolder ) ) // only upload newer files
        .pipe( conn.dest( destFolder ) );
} );
