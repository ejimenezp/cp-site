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
});

var conn = ftp.create( {
        host:     'ftp.cookingpoint.es',
        user:     'cookingpoint',
        password: 'Newuser01',
        parallel: 10,
        log:      gutil.log
    } );

var tienda_files = [
    'app/Http/Controllers/TicketsController.php',
    'app/Http/routes.php',
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
    'app/Http/Controllers/Legacy/LegacyController.php',
    'app/Http/Controllers/Legacy/LegacyMail.php',
    'app/Http/Controllers/Legacy/LegacyModel.php',
    'app/Http/Controllers/RedsysAPI.php',
    'app/Http/Controllers/TPVController.php',
    'app/Http/Middleware/VerifyCsrfToken.php',
    'app/Http/routes.php',
    'config/cookingpoint.php',
    'public/.htaccess',
    'public/index.php',
    'public/build/css/app**css',
    'public/build/rev-manifest.json',
    'public/images/**jpg',
    'public/images/**png',
    'public/js/app.js',
    'public/js/cp-scripts.js',
    'public/favicon.ico',
    'public/favicon-test.ico',
    'public/legacy/admin/*',
    'resources/views/errors/404.blade.php',
    'resources/views/errors/503.blade.php',
    'resources/views/legacy/emptyform.blade.php',
    'resources/views/legacy/filledform.blade.php',
    'resources/views/masterlayout.blade.php',
    'resources/views/pages/bookings.blade.php',
    'resources/views/pages/contact.blade.php',
    'resources/views/pages/events.blade.php',
    'resources/views/pages/faq.blade.php',
    'resources/views/pages/gallery.blade.php',
    'resources/views/pages/home.blade.php',
    'resources/views/pages/paella.blade.php',
    'resources/views/pages/school.blade.php',
    'resources/views/pages/tapas.blade.php',
    'resources/views/pages/wine.blade.php',
    'resources/views/sidebar.blade.php',
    'resources/views/tpv/pay.blade.php',
    'resources/views/tpv/callback.blade.php',
    'storage/app/client_secret_testing.json',
    'storage/app/legacy/admin_notice_CR.html',
    'storage/app/legacy/admin_notice_PA.html',
    'storage/app/legacy/booking_details.html',
    'storage/app/legacy/status_CR.html',
    'storage/app/legacy/status_CR.txt',
    'storage/app/legacy/status_PA.html',
    'storage/app/legacy/status_PA.txt',
    'storage/app/legacy/status_PE.html',
    'storage/app/legacy/status_PE.txt'


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


