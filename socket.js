var http = require('http').Server();
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

io.on('connection', function(socket){
    console.log('a user connected');
});

redis.psubscribe('*');
redis.on('pmessage', function (pattern, channel, message) {
    console.log(channel, message);
    var message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(3000, function(){
    console.log('listening on *:3000');
});



