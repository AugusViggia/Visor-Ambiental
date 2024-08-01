const mix = require('laravel-mix')

require('laravel-mix-eslint')

mix.js('resources/js/app.js', 'public/js')
  .eslint()
  .vue()
  .sass('resources/sass/app.scss', 'public/css')
  .copy('resources/images', 'public/images')
  .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
  .webpackConfig(require('./webpack.config'))

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

if (mix.inProduction()) {
  mix.version()
}
