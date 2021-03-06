const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/admin/app.js', 'public/assets/app/js/admin.js').vue()
   .sass('resources/sass/admin.scss', 'public/assets/app/css/admin.css');

mix.js('resources/js/website/app.js', 'public/assets/website/js/website.js').vue()
   .sass('resources/sass/website/main.scss', 'public/assets/website/css/website.css');