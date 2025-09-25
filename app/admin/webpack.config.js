const path = require('path');

// module.exports = {
//     entry: {
//         app: './resources/js/app.js'
//     },
//     output: {
//         filename: 'access-control.js',
//         path: path.resolve(__dirname, './../../public/js')
//     },
//     module: {
//         rules: [
//             {
//                 test: /\.js$/,
//                 exclude: /node_modules/,
//                 use: {
//                     loader: 'babel-loader'
//                 }
//             },
//             {
//                 test: /\.css$/,
//                 use: ['style-loader', 'css-loader']
//             }
//         ]
//     }
// };

module.exports = (env) => {
  const entry = env.entry ?? 'app';
  return {
      entry: `./resources/js/${entry}.js`, // Adjust based on your project structure
      output: {
        filename: `${entry}.js`, // Output JavaScript file
        path: path.resolve(__dirname, './../../public/js'),
        clean: false, // Cleans old files before build
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
            }
}
}
