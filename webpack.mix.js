let mix = require('laravel-mix');

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

mix.options({
    terser: {
        terserOptions: {
            keep_fnames: true
        }
    }
});

mix.js([
    'resources/js/export.js',
], 'resources/dist/js/cookie-notice.min.js');

// mix.postCss('resources/css/ddm-cookie-notice.css', 'resources/dist/css', [
//     require('tailwindcss'),
// ]);
