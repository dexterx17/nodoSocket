var ws = require("nodejs-websocket");
const threads = require('threads');
const spawn   = threads.spawn;

const threadControlador  = spawn(function() {});

threadControlador
  .run(function(){
  	setInterval(function() { console.log('exec') },100)//Cada 100 ms
  })
  .send();
  
setTimeout(function(){
	threadControlador.kill()
},2000);