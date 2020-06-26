var fs = require('fs-extra');

var dest_folder = 'deploy/ns-nepali-date/';

var files_list = [
	'ns-nepali-date.php',
	'README.md',
	'assets',
	'inc',
	'languages',
	'vendor',
];

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
	files_list.forEach(function(el ){
		fs.copy( el, dest_folder + el);
	});
}

depEmptyDirectory();
