var ws = require("nodejs-websocket");
var mysql      = require('mysql');
const threads = require('threads');
const spawn   = threads.spawn;
var threadPlataforma  = spawn(function() {});
var threadControlador  = spawn(function() {});

var ipServer ="";
var ipServer ="192.168.1.8";
var puertoServer =9300;

var db = mysql.createConnection({
  host     : '192.168.1.8',
  user     : 'root',
  password : '0112358',
  database : 'nodos'
});

db.connect();
var plataforma;
var controlador;

var server = ws.createServer(function (conn) {

    console.log("Nueva conexion");
    
    conn.on("text", function (str) {
    console.log("on text:");
    console.log(str);
    	var msj = JSON.parse(str);
    	if(typeof msj['cliente']!== "undefined"){
        	if(msj['cliente']==="plataforma"){
        		conn.tipo="plataforma"
        		console.log('seteand plataforma')
        		plataforma=conn
        		threadControlador
				  .run(function(input, done, progress) {
				  	setInterval(function() { progress(25); },100);//Cada 100 ms
				  })
				  .send()
				  .on('progress', function(progress) {
				  	notificar_a_plataforma(plataforma)
				  });
        	}
        	if(msj['cliente']==="controlador"){
        		conn.tipo="controlador"
        		console.log('seteand controlador')
        		controlador=conn
        		threadPlataforma
				  .run(function(input, done, progress) {
				  	setInterval(function() { progress(25); },100);//Cada 100 ms
				  })
				  .send()
				  .on('progress', function(progress) {
				  	notificar_a_controlador(controlador)
				  });
        	}
    	}else{
    		if(typeof conn.tipo!== "undefined"){
    			if(conn.tipo==="controlador"){
    				guardar_dato_controlador(msj);
    			}
    			if(conn.tipo==="plataforma"){
    				guardar_dato_plataforma(msj);
    			}
    		}
    	}
    })

    conn.on("close", function (code, reason) {
        if(typeof plataforma !== "undefined" && conn.tipo==="plataforma"){
        	threadControlador.kill();
        	threadControlador  = spawn(function() {});
        }
        if(typeof controlador !== "undefined" && conn.tipo==="controlador"){
        	threadPlataforma.kill();
        	threadPlataforma  = spawn(function() {});
        }
    })
}).listen(puertoServer,ipServer)

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str)
	})
}

function guardar_dato_controlador(datos){
	console.log('guardando mensaje de controlador')
	db.query('INSERT INTO controlador SET ?',datos, function(err, result) {
	  if (err) throw err;
		console.log( result);
	});
}

function guardar_dato_plataforma(datos){
	console.log('guardando mensaje de plataforma')
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
	  	try{
			controlador.sendText(JSON.stringify(resultado))
	  	}catch(e){
	  		console.log('conexion a controlador cerrada')
	  	}
	});
}

function notificar_a_plataforma(plataforma) {
	console.log('notificando a plataforma el ultimo dato del controlador');
	db.query('SELECT com,valorx,valory,valorz,errorx,errory,errorz,control FROM controlador ORDER BY id DESC LIMIT 1', function(err, rows, fields) {
	  if (err) throw err;
	  	var resultado = JSON.stringify(rows[0])
	  	try{
			plataforma.sendText(JSON.stringify(resultado))
	  	}catch(e){
	  		console.log('conexion a plataforma cerrada')
	  	}
	});
}
