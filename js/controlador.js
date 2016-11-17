var server;
$(document).ready(function() {
    console.log('conectando...');
    Server = new FancyWebSocket('ws://192.168.1.8:9300');
    //Let the user know we're connected
    Server.bind('open', function() {
        console.log("Connected.");
        var mensaje = {
            'cliente': 'controlador'
        };
        Server.send('message', JSON.stringify(mensaje));
    });

    Server.bind('close', function(data) {
        console.log("Disconnected.");
    });

    //console.log any messages sent from server
    Server.bind('message', function(payload) {
        var res = jQuery.parseJSON(payload);
        console.log(res);
        $('#plataforma_div').html(payload);
    });

    Server.connect();
});

$(document).on('submit','.sender',function(e){
    e.preventDefault();
    var info = $('#valor').val();
    Server.send('message',info);
})
$(document).on('submit','.sender2',function(e){
    e.preventDefault();
    var info = $('#valor2').val();
    Server.send('message',info);
})
