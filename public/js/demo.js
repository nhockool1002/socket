var token = document.head.querySelector('meta[name="csrf-token"]');
Vue.http.headers.common['X-CSRF-TOKEN'] = token.content;

var socket = io(app.socket_url);

var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue!',
        body: '',
        comments: [],
    },
    methods: {
        getComments: function() {
            this.$http.get(window.location.href + '/messages').then(response => {
                console.log(response.body);
                this.comments = response.body;
            }, response => {
                // error callback
            });
        },
        nhut: function () {
            this.$http.post(window.location.href + '/messages', {body: this.body}).then(response => {
                console.log(response.body);
            }, response => {
                // error callback
            });
        }
    },
    created: function () {
        this.getComments();

        socket.on('post.' + app.post_id + ':userComment', function(msg){
            this.comments.push(msg);
        }.bind(this));
    }
});
