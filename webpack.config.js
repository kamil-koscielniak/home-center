var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin')

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('template/scripts/extras.1.1.0.min',
        './node_modules/shards-dashboard/scripts/extras.1.1.0.min.js')
    .addEntry('template/scripts/shards-dashboards.1.1.0.min',
        './node_modules/shards-dashboard/scripts/shards-dashboards.1.1.0.min.js')

    .addStyleEntry('template/styles/shards-dashboards.1.1.0.min',
        './node_modules/shards-dashboard/styles/shards-dashboards.1.1.0.min.css')
    .addStyleEntry('template/styles/extras.1.1.0.min',
        './node_modules/shards-dashboard/styles/extras.1.1.0.min.css')

    .addPlugin(new CopyWebpackPlugin([
        {from: './assets/images', to: 'images'}
    ]))

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
