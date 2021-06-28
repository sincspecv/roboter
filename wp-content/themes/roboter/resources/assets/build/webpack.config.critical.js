'use strict'; // eslint-disable-line

const webpack = require('webpack');
const merge = require('webpack-merge');
const fs = require('fs');
const desire = require('./util/desire');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const HtmlCriticalWebpackPlugin = require("html-critical-webpack-plugin");

const config = require('./config');
const criticalConfig = JSON.parse(fs.readFileSync(`${__dirname}/../../../critical/config.json`));
const assetsFilenames = (config.enabled.cacheBusting) ? config.cacheBusting : '[name]';

const ignore = ["@font-face", /url\(/];

const criticalPaths = () => {
  let paths = [];
  [].forEach.call(criticalConfig.pages, path => {
    paths.push( new HtmlCriticalWebpackPlugin({
      base: config.paths.critical,
      src: `${config.devUrl}${path.url}`,
      dest: `styles/critical-${path.post_type}-${path.page_type}.css`,
      ignore: ignore,
      inline: false,
      minify: true,
      extract: false,
      dimensions: [
        {
          width: 760,
          height: 640,
        },
        {
          width: 1920,
          height: 1080,
        },
      ],
      penthouse: {
        blockJSRequests: false,
      }
    }))
  })

  return paths
}

module.exports = {
  context: config.paths.assets,
  entry: config.entry,
  devtool: (config.enabled.sourceMaps ? '#source-map' : undefined),
  output: {
    path: config.paths.critical,
    publicPath: config.publicPath,
    filename: `scripts/${assetsFilenames}.js`,
  },
  stats: {
    hash: false,
    version: false,
    timings: false,
    children: false,
    errors: false,
    errorDetails: false,
    warnings: false,
    chunks: false,
    modules: false,
    reasons: false,
    source: false,
    publicPath: false,
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.js$/,
        include: config.paths.assets,
        use: 'eslint',
      },
      {
        enforce: 'pre',
        test: /\.(js|s?[ca]ss)$/,
        include: config.paths.assets,
        loader: 'import-glob',
      },
      {
        test: /\.js$/,
        exclude: [/node_modules(?![/|\\](bootstrap|foundation-sites))/],
        use: [
          { loader: 'cache' },
          { loader: 'buble', options: { objectAssign: 'Object.assign' } },
        ],
      },
      {
        test: /\.css$/,
        include: config.paths.assets,
        use: ExtractTextPlugin.extract({
          fallback: 'style',
          use: [
            { loader: 'cache' },
            { loader: 'css', options: { sourceMap: config.enabled.sourceMaps } },
            {
              loader: 'postcss', options: {
                config: { path: __dirname, ctx: config },
                sourceMap: config.enabled.sourceMaps,
              },
            },
          ],
        }),
      },
      {
        test: /\.scss$/,
        include: config.paths.assets,
        use: ExtractTextPlugin.extract({
          fallback: 'style',
          use: [
            { loader: 'cache' },
            { loader: 'css', options: { sourceMap: config.enabled.sourceMaps } },
            {
              loader: 'postcss', options: {
                config: { path: __dirname, ctx: config },
                sourceMap: config.enabled.sourceMaps,
              },
            },
            { loader: 'resolve-url', options: { sourceMap: config.enabled.sourceMaps } },
            {
              loader: 'sass', options: {
                sourceMap: config.enabled.sourceMaps,
                sourceComments: true,
              },
            },
          ],
        }),
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: config.paths.assets,
        loader: 'url',
        options: {
          limit: 4096,
          name: `[path]${assetsFilenames}.[ext]`,
        },
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: /node_modules/,
        loader: 'url',
        options: {
          limit: 4096,
          outputPath: 'vendor/',
          name: `${config.cacheBusting}.[ext]`,
        },
      },
    ],
  },
  resolve: {
    modules: [
      config.paths.assets,
      'node_modules',
    ],
    enforceExtension: false,
  },
  resolveLoader: {
    moduleExtensions: ['-loader'],
  },
  plugins: [].concat(criticalPaths()),
}
