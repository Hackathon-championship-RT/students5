const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');
const EncodingPlugin = require('webpack-encoding-plugin');

module.exports = {
    resolve: {
        alias: {
            '@main-page': path.resolve(__dirname, 'js/apps/mainPage'),
        },
        extensions: ['.js', '.vue'],
    },
    cache: {
        type: 'filesystem',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'esbuild-loader',
                options: {
                    loader: 'js',
                },
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.css$/,
                use: [
                    {
                        loader: 'vue-style-loader',
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                        },
                    },
                ],
            },
            {
                test: (filename) => /(?:^|\/|\\)[-\w]+\.s[ac]ss/.test(filename),
                use: [
                    "style-loader",
                    "css-loader",
                    "sass-loader",
                ]
            },
            {
                test: (filename) => /\.vue\.s[ac]ss/.test(filename),
                use: [
                    'vue-style-loader',
                    'css-loader',
                    'sass-loader',
                ],
            },
        ],
    },
    plugins: [
        new VueLoaderPlugin(),
        new EncodingPlugin({
            encoding: 'windows-1251',
        }),
    ],
    entry: {
        mainPage: './js/apps/mainPage/index.js',
    },
    output: {
        path: path.resolve(__dirname, './js/dist/'),
        filename: '[name].bundle.js',
        publicPath: '/js/dist/',
        chunkFilename: '[name].[chunkhash].js',
        clean: true,
    },
};
