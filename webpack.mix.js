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

mix.js('resources/js/app.js', 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css').options({
        processCssUrls: mix.inProduction()
    })
    .sass('resources/sass/app-dark.scss', 'public/css').options({
        processCssUrls: mix.inProduction()
    })
    .js('resources/js/new-run.js', 'public/js/new-run.js')
    .js('resources/js/fits.js', 'public/js/fits.js')
    .styles([
        'resources/sass/dependencies-dark/simplemde-theme-dark.min.css'
    ], 'public/css/new-fit-deps-dark.css')
    .styles([
        'resources/sass/dependencies-light/simplemde.min.css'
    ], 'public/css/new-fit-deps-light.css')
    .scripts([
        'resources/js/dependencies-all/simplemde.min.js',
        'resources/js/new-fit/wizard.js'
    ], 'public/js/new-fit.js')
  ;
