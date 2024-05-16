const http = require('http');
const server = http.createServer();
const io = require('socket.io')(server, {
  cors: {
    origin: "http://localhost",
    methods: ["GET", "POST"]
  }
});

io.on('connection', (socket) => {
  console.log('A user connected');

  socket.on('disconnect', () => {
    console.log('User disconnected');
  });

  socket.on('chat message', (msg) => {
    console.log('message: ' + msg);
    io.emit('chat message', msg); // Phát lại tin nhắn cho tất cả các client
  });

  socket.on('send notification', (data) => {
    console.log('notification: ' + data);
    io.emit('notification', data); // Gửi thông báo cho tất cả các client
  });
});

server.listen(8080, () => {
  console.log('Server is running on port 8080');
});

// Gửi thông báo từ server đến tất cả các client mỗi 10 giây
setInterval(() => {
  io.emit('notification', 'This is a notification from server');
  console.log('notification: ');
}, 3000); // Gửi mỗi 10 giây (10000 miligiây)
