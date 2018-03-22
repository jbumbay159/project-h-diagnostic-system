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

mix.js('resources/assets/js/app.js', 'public/js')

   .sass('resources/assets/sass/app.scss', 'public/css')
   .styles([
   		'public/quirk/lib/jquery-ui/jquery-ui.css',
   		'public/quirk/lib/select2/select2.css',
   		'public/quirk/lib/dropzone/dropzone.css',
   		'public/quirk/lib/jquery-toggles/toggles-full.css',
   		'public/quirk/lib/fontawesome/css/font-awesome.css',
   		'public/quirk/lib/timepicker/jquery.timepicker.css',
   		'public/quirk/lib/bootstrapcolorpicker/css/bootstrap-colorpicker.css',
   		'public/quirk/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
   		'public/quirk/lib/select2/select2.css',
   		'public/quirk/lib/animate.css/animate.css',
   		], 'public/css/all.css');




