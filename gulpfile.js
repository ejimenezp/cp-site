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
    .browserify('legacy/cp-scripts.js')
    .task('fonts')

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

var pages_files = [
    'app/Http/routes.php',
    'public/build/css/app**css',
    'public/build/rev-manifest.json',
    'public/images/**jpg',
    'public/images/**png',
    'public/js/app.js',
    'public/favicon.ico',
    'public/favicon-test.ico',
    'resources/views/masterlayout.blade.php',
    'resources/views/pages/classes.blade.php',
    'resources/views/pages/events.blade.php',
    'resources/views/pages/home.blade.php',
    'resources/views/pages/paella.blade.php',
    'resources/views/sidebar.blade.php'
];

gulp.task( 'deploy-pages', function () {

    var destFolder = '/laravel/test_bs2';

    // using base = '.' will transfer everything to /public_html correctly
    // turn off buffering in gulp.src for best performance

    return gulp.src( pages_files, { base: '.', buffer: false } )
        .pipe( conn.newer( destFolder ) ) // only upload newer files
        .pipe( conn.dest( destFolder ) );
} );


gulp.task( 'deploy-tienda', function () {

    var destFolder = '/laravel/test_bs2';

    // using base = '.' will transfer everything to /public_html correctly
    // turn off buffering in gulp.src for best performance

    return gulp.src( tienda_files, { base: '.', buffer: false } )
        .pipe( conn.newer( destFolder ) ) // only upload newer files
        .pipe( conn.dest( destFolder ) );
} );

gulp.task('fonts', function() {
   gulp.src('node_modules/bootstrap-sass/assets/fonts/bootstrap/*.{ttf,woff,eot,svg,woff2}')
   .pipe(gulp.dest('public/build/fonts/bootstrap'))
});
