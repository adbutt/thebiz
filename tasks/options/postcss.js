module.exports = {
	dist: {
		options: {
			processors: [
				require('autoprefixer')({browsers: 'last 2 versions'})
			]
		},
		files: { 
			'assets/css/thebiz.css': [ 'assets/css/thebiz.css' ]
		}
	}
};