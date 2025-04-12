const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

// module.exports = {
//   entry: './resources/js/app.js', // Adjust based on your project structure
//   output: {
//     filename: 'js/app.js', // Output JavaScript file
//     path: path.resolve(__dirname, 'public'), // Output base directory
//     clean: false, // Cleans old files before build
//   },
//   module: {
//     rules: [
//       {
//         test: /\.css$/i,
//         use: [MiniCssExtractPlugin.loader, 'css-loader'],
//       },
//       {
//         test: /\.scss$/i,
//         use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
//       },
//     ],
//   },
//   plugins: [
//     new MiniCssExtractPlugin({
//       filename: 'css/styles.css', // Output CSS file in public/css
//     }),
//   ],
//   devtool: 'source-map', // Optional: Generates source maps for debugging
// };


module.exports = (env) => {
  const entry = env.entry ?? 'app';
  return {
      entry: `./resources/js/${entry}.js`, // Adjust based on your project structure
      output: {
        filename: `js/${entry}.js`, // Output JavaScript file
        path: path.resolve(__dirname, 'public'), // Output base directory
        clean: false, // Cleans old files before build
      },
      module: {
        rules: [
          {
            test: /\.css$/i,
            use: [MiniCssExtractPlugin.loader, 'css-loader'],
          },
          {
            test: /\.scss$/i,
            use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
          },
        ],
      },
      plugins: [
        new MiniCssExtractPlugin({
          filename: 'css/styles.css', // Output CSS file in public/css
        }),
      ],
      devtool: 'source-map', // Optional: Generates source maps for debugging
    }
}