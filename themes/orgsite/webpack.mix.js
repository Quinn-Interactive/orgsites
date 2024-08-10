const mix = require("laravel-mix");
require("laravel-mix-polyfill");

require("dotenv").config({
    path: "../../../../.env",
});

// set up mix options
mix.options({
    processCssUrls: false,
});

// set the public path
mix.setPublicPath("dist");

// scss/css
mix.sass("src/scss/styles.scss", "css")
    .sass("src/scss/icons.scss", "css")
    .sass("src/scss/pattern.scss", "css")
    .sass("src/scss/editor.scss", "css");

// js
mix.js("src/js/index.js", "js").polyfill({
    enabled: true,
    useBuiltIns: "usage",
    targets: false, // setting to false uses package.jons' browserlist info
});

mix.sourceMaps(false);

mix.webpackConfig({
    output: {
        publicPath: '/_resources/vendor/quinninteractive/orgsite/themes/orgsite/dist/',
        chunkFilename: 'js/chunks/[name].js?id=[chunkhash]',
    },
    stats: {
        children: false, //  set to true to see child warnings
    }
});

if (process.env.MIX_HOST_DOMAIN && process.env.MIX_PROXY_URL) {
    mix.browserSync({
        host: process.env.MIX_HOST_DOMAIN,
        proxy: process.env.MIX_PROXY_URL,
        open: "external",
        ghostMode: false,
        // logLevel: "debug",
        reloadDelay: 1500,
        files: [
            "src/scss/**/*.scss",
            "src/js/**/*.js",
            "templates/",
            "images/",
            "fonts/",
        ],
    });
}
