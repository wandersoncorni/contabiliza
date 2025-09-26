const path = require('path');
const webpack = require('webpack');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const fs = require('fs');

module.exports = (env) => {
    const entry = {};
    const entryName = env.entry ?? 'app';
    const baseName = path.basename(entryName); // nome do js
    const dirName = path.dirname(entryName);   // diretório do js

    entry[baseName] = `./resources/js/${entryName}.js`;

    // Caminho do output
    const outputPath = path.resolve(__dirname, './../../public/js');

    return {
        mode: 'development',
        entry,
        output: {
            filename: `${baseName}.[contenthash].js`,
            path: outputPath,
            clean: false, // não limpa tudo, vamos controlar manualmente
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: 'babel-loader',
                },
                {
                    test: /\.css$/,
                    use: ['style-loader', 'css-loader'],
                },
            ],
        },
        plugins: [
            new WebpackManifestPlugin({
                fileName: 'manifest.json',
                publicPath: '/js/',
                generate: (seed, files) => {
                    const manifestPath = path.resolve(outputPath, 'manifest.json');
                    let oldManifest = {};

                    // Se já existe um manifest anterior, carrega ele
                    if (fs.existsSync(manifestPath)) {
                        try {
                            oldManifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
                        } catch (e) {
                            oldManifest = {};
                        }
                    }

                    // Atualiza/insere apenas os arquivos gerados nessa compilação
                    const newManifest = {};
                    files.forEach(file => {
                        newManifest[`${file.name}`] = file.path;
                    });

                    // Retorna a fusão: mantém os antigos + atualiza os novos
                    return {
                        ...oldManifest,
                        ...newManifest,
                    };
                }
            }),

            // Plugin custom para remover o .js antigo antes de salvar o novo
            {
                apply: (compiler) => {
                    compiler.hooks.emit.tap('CleanOldJsPlugin', (compilation) => {
                        const regex = new RegExp(`^${baseName}\\..*\\.js$`);
                        fs.readdirSync(outputPath).forEach(file => {
                            if (regex.test(file)) {
                                fs.unlinkSync(path.join(outputPath, file));
                            }
                        });
                    });
                }
            }
        ],
        externals: {
            jquery: 'jQuery', // não empacotar jQuery
        },
    };
};
