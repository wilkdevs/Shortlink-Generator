const mix = require("laravel-mix");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

require("laravel-mix-obfuscator");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sourceMaps()
   .browserSync({
       proxy: '127.0.0.1:8000',
       files: [
            'public/app/js/**/*.js',
            'app/**/*.php',
            'resources/views/**/*.blade.php',
            'routes/**/*.php',
            'public/js/**/*.js',
            'public/css/**/*.css',
       ],
   });
