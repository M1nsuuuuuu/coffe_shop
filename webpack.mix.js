const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/admin.js', 'public/js')
   .css('resources/css/app.css', 'public/css')
   .css('resources/css/admin.css', 'public/css');