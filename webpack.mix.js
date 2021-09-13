const mix = require('laravel-mix');
const dotenv = require('dotenv-webpack');

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

mix.js('resources/js/spotifynt.js', 'public/js').sourceMaps();

mix.postCss("resources/css/main.css", "public/css");

mix.webpackConfig({
  plugins: [
    new dotenv(),
  ],
});

if (mix.inProduction()) {
  mix.extract();
}

