const Encore = require('@symfony/webpack-encore');
const { VueLoaderPlugin } = require('vue-loader');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')
    .enableVueLoader()
    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .configureDevServerOptions((options) => {
        options.liveReload = true;  // Active le rechargement en direct du navigateur lors de la modification des fichiers.
        options.static = {
            watch: false,  // Désactive le suivi automatique des modifications des fichiers servis statiquement.
        };
        options.watchFiles = {
            paths: ["src/**/*.php", "templates/**/*", 'assets/images'],  // Définit les chemins spécifiques que Webpack devrait surveiller pour les modifications.
        };
    })


    // Copie les fichiers d'images de 'assets/images' vers 'public/build/images'
    .copyFiles({
        from: './assets/images',

        // facultatif: si tu utilises la version, ajoute un hash aux fichiers copiés
        // en production, les noms des fichiers pourraient ressembler à `images/your-image.abcdef.jpg`
        // note: n'oublie pas que tu dois utiliser la fonction asset() dans Twig pour charger les images de `public/build/`
        to: 'images/[path][name].[hash:8].[ext]',

        // uniquement copier les fichiers correspondant à ce motif
        pattern: /\.(png|jpg|jpeg|gif|webp)$/
    })

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

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;
const config = Encore.getWebpackConfig();
config.plugins.push(new VueLoaderPlugin());

module.exports = config;
