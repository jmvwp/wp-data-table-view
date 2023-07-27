const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
module.exports = {
  entry:        {
    main: "./assets/js/main.tsx"
  },
  output:       {
    filename: "[name].min.js",
    path:     path.resolve(__dirname, "dist"),
  },
  module:       {
    rules: [
      {
        test:    /\.(ts|tsx)$/,
        exclude: /node_modules/,
        use:     "ts-loader",
      },
      {
        test: /\.sass$/,
        use:  [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "sass-loader",
        ],
      },
    ],
  },
  plugins:      [
    new MiniCssExtractPlugin({
      filename: "main.min.css", // Set the filename for the extracted CSS
    }),
    new CleanWebpackPlugin()
  ],
  resolve:      {
    extensions: [".ts", ".tsx", ".js", ".jsx"],
  },
  optimization: {
    minimize:  true,
    minimizer: [
      new CssMinimizerPlugin(),
      new TerserPlugin({
        extractComments: false,
      }),
    ],
  },
};
