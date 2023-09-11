const fs = require('node:fs')

const currentTime = Date.now()

const content = `<?php return "${currentTime}";`

const createHashFile = async (dir, content, file = 'hash.php') => {
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir)
  }

  await Bun.write(dir + '/' + file, content)
}

createHashFile('build', content)
