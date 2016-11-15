var ws = require("nodejs-websocket");
var mysql      = require('mysql');
const threads = require('threads');
const spawn   = threads.spawn;
const threadPlataforma  = spawn(function() {});
const threadControlador  = spawn(function() {});

var db = mysql.createConnection({
  host     : '192.168.1.8',
  user     : 'root',
  password : '0112358',
  database : 'nodos'
});
 db.connect();
// Scream server example: "hi" -> "HI!!!"
var plataforma;
var controlador;

var server = ws.createServer(function (conn) {
    console.log("Nueva conexion");
    conn.on("text", function (str) {
    	var msj = JSON.parse(str);
    	if(typeof msj['cliente']!== "undefined"){
        	if(msj['cliente']==="plataforma"){
        		conn.tipo="plataforma"
        		plataforma=conn
        		threadControlador
				  .run(function(input, done, progress) {
				  	setInterval(function() { progress(25); },100);//Cada 100 ms
				  })
				  .send()
				  .on('progress', function(progress) {
				  	notificar_a_plataforma(plataforma)
				  })
				  .on('done', function() {
				    console.log('Done.');
				    threadControlador.kill()
				  });
        	}
        	if(msj['cliente']==="controlador"){
        		conn.tipo="controlador"
        		controlador=conn
        		threadPlataforma
				  .run(function(input, done, progress) {
				  	setInterval(function() { progress(25); },100);//Cada 100 ms
				  })
				  .send()
				  .on('progress', function(progress) {
				  	notificar_a_controlador(controlador)
				  })
				  .on('done', function() {
				    console.log('Done.');
				    threadPlataforma.kill()
				  });
        	}
    	}else{
    		if(typeof conn.tipo!== "undefined"){
    			if(conn.tipo==="controlador"){
    				console.log('guardando mensaje de controlador')
    				guardar_dato_controlador(msj);
    			}
    			if(conn.tipo==="plataforma"){
    				console.log('guardando mensaje de plataforma')
    				guardar_dato_plataforma(msj);
    			}
    		}
    	}
    })

    conn.on("close", function (code, reason) {
        console.log("Conneccion cerrada")
        threadControlador.kill();
        threadPlataforma.kill();
    })
}).listen(9300,"192.168.1.8")

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str)
	})
}

function guardar_dato_controlador(datos){
	db.query('INSERT INTO controlador SET ?',datos, function(err, result) {
	  if (err) throw err;
		console.log( result);
	});
}

function guardar_dato_plataforma(datos){
	db.query('INSERT INTO plataforma SET ?',datos, function(err, result) {
	  if (err) throw err;
		console.log( result);
	});
}

function notificar_a_controlador(controlador) {
	console.log('notificando a controlador el ultimo dato de la plataforma');
	db.query('SELECT ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal FROM plataforma ORDER BY id DESC LIMIT 1', function(err, rows, fields) {
	  if (err) throw err;
		console.log( JSON.stringify(rows[0]));
	  	var resultado = JSON.stringify(rows[0])
		controlador.sendText(JSON.stringify(resultado))
	});
}

function notificar_a_plataforma(plataforma) {
	console.log('notificando a plataforma el ultimo dato del controlador');
	db.query('SELECT com,valorx,valory,valorz,errorx,errory,errorz,control FROM controlador ORDER BY id DESC LIMIT 1', function(err, rows, fields) {
	  if (err) throw err;
	  	var resultado = JSON.stringify(rows[0])
		plataforma.sendText(JSON.stringify(resultado))
	});
}
