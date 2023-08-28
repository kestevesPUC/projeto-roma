// webpack.mix.plugins
const webpack = require("webpack");
const mix = require('laravel-mix');
const WebpackShellPluginNext = require('webpack-shell-plugin-next');
const path = require("path");
// mix.plugins('resources/app.plugins', 'dist').setPublicPath('dist');

mix.js('resources/js/app.js', 'public/js/app.js');

// mix.alias({ ziggy : path.resolve (' vendor/ tightenco /ziggy/dist.vue')});

mix.webpackConfig({
    plugins: [
        new WebpackShellPluginNext({
            onBuildStart:{
                scripts: ['php artisan lang:js public/messages.js --quiet', 'php artisan ziggy:generate public/js/common/Routes.js --quiet'],
                blocking: true,
                parallel: false
            }, onBuildEnd: [] })
    ],
});


plugins: [
    new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery"
    })
]

/**
 * DATATABLES
 */
mix.scripts([
    'resources/assets/plugins/datatables/datatables.bundle.js',
    'resources/assets/plugins/common/DataTable-Paginate.js',
    'resources/assets/plugins/common/DataTable.js',
    'resources/assets/plugins/datatables/dataTables.fixedHeader.min.js',
], 'public/assets/plugins/EssentialTables.js').version();


/**
 * PONTO
 */
mix.scripts('resources/js/ponto/index.js', 'public/js/ponto/index.js').version();

/**
 * User
 */
mix.scripts('resources/js/user/index.js', 'public/js/user/index.js').version();
mix.scripts('resources/js/user/register.js', 'public/js/user/register.js').version();

/**
 * Profile
 */
mix.scripts('resources/js/profile/index.js', 'public/js/profile/index.js').version();

/**
 * Util
 */
mix.scripts('resources/js/util/index.js', 'public/js/util/index.js').version();

/**
 * JQUERY
 */
mix.scripts('resources/assets/plugins/jquery/code.jquery.com_jquery-3.7.0.min.js', 'public/assets/plugins/jquery/code.jquery.com_jquery-3.7.0.min.js').version();


/**
 * ESSENTIALS
 */
mix.scripts([
    'resources/assets/template/plugins.bundle.js',
    // 'resources/assets/template/scripts.bundle.js',
    // 'resources/assets/js/template/validade.bundle.js',
    'resources/assets/template/validate.min.js',
    // 'resources/assets/plugins/jquery-maskmoney/maskMoney.min.js',
    'node_modules/cropperjs/dist/cropper.js',
    // 'resources/assets/plugins/jstree/jstree.min.js',
    'resources/assets/template/additional-methods.min.js',
],'public/assets/essential.js').version();
