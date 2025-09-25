const path = require('path');
const webpack = require('webpack');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

module.exports = (env) => {
    const entry = {};
    const entryName = env.entry ?? 'app';
    entry[entryName] = `./resources/js/${entryName}.js`;
    return {
        entry,
        output: {
            filename: `${entryName}.[contenthash].js`,
            path: path.resolve(__dirname, './../../public/js'),
            clean: false,
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader'
                    }
                },
                {
                    test: /\.css$/,
                    use: ['style-loader', 'css-loader']
                }
            ]
        },
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
            }),
            new WebpackManifestPlugin({
                fileName: 'manifest.json',
                publicPath: '/js/',
            }),
        ],
        externals: {
            jquery: 'jQuery' // diz ao Webpack para não empacotar o jQuery
        }
    }
}
