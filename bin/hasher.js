const fs = require('fs')

const currentTime = Date.now()

const content = `<?php return "${currentTime}";`

const createHashFile = async (file, content) => {
	// if (!fs.existsSync(file)) {
	// 	createFile(file, content)
	// } else {
	// 	updateFile(file, content)
	// }
	await Bun.write(file, content);
}

const createFile = (filename, content) => {
	fs.open(filename, 'r', function (err, fd) {
		if (err) {
			fs.writeFile(filename, content, function (err) {
				if (err) {
					console.log(err);
				}
			});
		}
	});
}

const updateFile = (filename, content) => {
	fs.writeFile(filename, content, function (err) {
		if (err) {
			console.log(err);
		}
	});
}

createHashFile('./build/hash.php', content)
