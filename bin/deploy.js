var fs = require('fs-extra');

var pkg = JSON.parse(fs.readFileSync('./package.json'));

var deploylist = '';

if ( pkg.deploylist ) {
	deploylist = pkg.deploylist;
}

if ( ! deploylist ) {
	throw Error('"deploylist" is not set is "package.json".');
}

var dest_folder = 'deploy/' + pkg.name + '/';

function depEmptyDirectory() {
	fs.remove(dest_folder, err => {
		if (err) {
			return console.error(err)
		}

		depCreateFolder();
	})
}

function depCreateFolder() {
	fs.mkdir(dest_folder, { recursive: true }, (err) => {
	    if (err) {
	    	throw err;
	    }

	    copyFilesList();
	});
}

function copyFilesList() {
	deploylist.forEach(function(el ){
		fs.copy( el, dest_folder + el);
	});
}

depEmptyDirectory();
