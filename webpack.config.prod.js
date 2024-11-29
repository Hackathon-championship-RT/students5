const { merge } = require('webpack-merge');
const { EsbuildPlugin } = require('esbuild-loader');
const baseConfig = require('./webpack.config.base');

module.exports = merge(baseConfig, {
    mode: 'production',
    optimization: {
        minimizer: [
            new EsbuildPlugin({
                css: true,
            }),
        ],
    },
});
