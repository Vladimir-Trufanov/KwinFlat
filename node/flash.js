// JAVASCRIPT/HTML5, EDGE/CHROME                                    *** flash.js ***

// ****************************************************************************
// *  ----KwinFlat30                                -------KwinFlat-близкий всем! *
// ****************************************************************************

// v4.0.1, 19.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 14.08.2016



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

/*
echo '
<script>
const http = require("http");
const fs = require("fs");

const server = http.createServer((req, res) => 
{
    res.writeHead(200, { "Content-Type": "multipart/x-mixed-replace; boundary=--test" });

    let i = 1;

    function sendData() 
    {
        const content = fs.readFileSync("./imgs/run${i}.png");
        res.write("--test\nContent-Type: image/png\nContent-length: ${content.length}\n\n");
        res.write(content);
        i = i === 20 ? 1 : i + 1;
        setTimeout(sendData, 50);
    }

    setTimeout(sendData, 50);
})

server.listen(8090);
console.log("Server running!");
</script>';
*/

// *************************************************************** flash.js ***

