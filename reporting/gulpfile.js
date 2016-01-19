process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

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
    mix.sass('app.scss')
        .scripts([
            '../../../node_modules/jquery/dist/jquery.js',
            '../../../node_modules/foundation-sites/js/foundation.core.js',
            '../../../node_modules/foundation-sites/js/foundation.accordion.js',
            '../../../node_modules/foundation-sites/js/foundation.util.keyboard.js',
            '../../../node_modules/foundation-sites/js/foundation.util.motion.js',
            '../../../node_modules/foundation-sites/js/foundation.util.mediaQuery.js',
            'helpers'
        ])
});
