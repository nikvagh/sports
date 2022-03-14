const express = require('express');
const app = express();
const server = require('http').createServer(app);
const axios = require('axios');
const FormData = require('form-data');
const fs = require('fs')
const io = require('socket.io')(server, {
    cors: { origin: "*"}
});
const env = require('dotenv').config({path: '.env'});
const base_url = env.parsed.BASE_URL;


// =====================
io.on('connection', (socket) => {
    console.log('connection');

    // =========================

    socket.on('new_notification', function(data) {
        console.log(data);
        io.sockets.emit('show_notification', data);
    });

});

server.listen(3000, () => {
    console.log('Server is running');
});
// ===================
