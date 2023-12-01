const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require( 'path' );
const IgnoreEmitPlugin = require( 'ignore-emit-webpack-plugin' );

module.exports = {
	...defaultConfig,
	entry: {
		index: path.resolve( process.cwd(), 'src/js', 'index.js' ),
		style: path.resolve( process.cwd(), 'src/scss', 'style.scss' )
	},
	optimization: {
		...defaultConfig.optimization,
		splitChunks: {
			cacheGroups: {
				editor: {
					name: 'editor',
					test: /editor\.(sc|sa|c)ss$/,
					chunks: 'all',
					enforce: true,
				},
				style: {
					name: 'style',
					test: /style\.(sc|sa|c)ss$/,
					chunks: 'all',
					enforce: true,
				},
				default: false,
			},
		},
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,

			{
				test: /\.svg$/,
				use: ['@svgr/webpack'],
			},
		]
	},
	plugins: [
		...defaultConfig.plugins,
		new IgnoreEmitPlugin( [ 'style.js' ] ),
	],
	performance: { hints: false },
};
