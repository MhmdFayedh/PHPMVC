const { appendFile } = require('fs')
const path = require('path')

module.exports = {
    mode: 'development',
    entry: path.resolve(__dirname, 'src/js/main.js'),
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: 'app.js',
    },
}