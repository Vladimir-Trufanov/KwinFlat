// JAVASCRIPT/HTML5, EDGE/CHROME                               *** flash.js ***

// ****************************************************************************
// *                 Сервер с "multipart/x-mixed-replace; boundary" в Node JS *
// ****************************************************************************

// v1.0.1, 02.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 02.03.2025



// это оказывается node.js

const http = require('http')
const fs = require('fs')

const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'multipart/x-mixed-replace; boundary=--test' })

    let i = 1

    function sendData() {
        const content = fs.readFileSync(`./imgs/run${i}.png`)
        res.write(`--test\nContent-Type: image/png\nContent-length: ${content.length}\n\n`)
        res.write(content)
        i = i === 20 ? 1 : i + 1
        setTimeout(sendData, 50)
    }

    setTimeout(sendData, 50)
})

server.listen(8090)
console.log('Server running!')

// *************************************************************** flash.js ***

