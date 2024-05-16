<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebSocket Test</title>
</head>
<body>
  <input type="text" id="message" placeholder="Type your message">
  <button onclick="sendMessage()">Send</button>

  <ul id="messages"></ul>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.3/socket.io.js"></script>
  <script>
    var socket = io('http://localhost:8080');

    socket.on('connect', function() {
      console.log('Connected to WebSocket server');
    });

    socket.on('disconnect', function() {
      console.log('Disconnected from WebSocket server');
    });

    socket.on('chat message', function(msg) {
      var li = document.createElement('li');
      li.textContent = msg;
      document.getElementById('messages').appendChild(li);
    });

    // Xử lý sự kiện nhận thông báo
    socket.on('notification', function(data) {
      console.log('notification received: ', data);
      var li = document.createElement('li');
      li.textContent = 'Notification: ' + data;
      document.getElementById('messages').appendChild(li);
    });

    function sendMessage() {
      var message = document.getElementById('message').value;
      socket.emit('chat message', message);
      document.getElementById('message').value = '';
    }
  </script>
</body>
</html>
