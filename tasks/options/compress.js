module.exports = {
	main: {
		options: {
			mode: 'zip',
			archive: './release/biz_.<%= pkg.version %>.zip'
		},
		expand: true,
		cwd: 'release/<%= pkg.version %>/',
		src: ['**/*'],
		dest: 'biz_/'
	}
};