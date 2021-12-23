const mix = require('laravel-mix');

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
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ])
    .copy('resources/images/realfavicongenerator.net/*', 'public/')
    .copy('resources/images/*.png', 'public/images/')
    .copy('resources/images/*.jpg', 'public/images/')
    .copy('resources/images/*.gif', 'public/images/')
;
