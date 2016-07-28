var elixir = require('laravel-elixir');
process.env.DISABLE_NOTIFIER = true
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
    mix.less('app.less');
    // mix.less('font-awesome.less');
    mix.copy('public/assets/fonts/FontAwesome.otf', 'public/fonts');
    mix.scripts([
    	'vendor/intlTelInput.js',
    	'vendor/intlTelUtils.js',
    	'app.js'
    	],'public/js/scripts.min.js');
});
