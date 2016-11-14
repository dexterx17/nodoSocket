<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permite administrar la conexion y los mensajes que se 
 * transmite a traves del Socket
 * 
 */

class Clon extends CI_Controller {

	var $socket;

	var $plataformaID;
	var $controladorID;

	var $plataformaIP;
	var $controladorIP;
	var $clientes;


	/**
	 * Inicializa un socket en la ip y puertos especificados
	 * 
	 * @return TRUE Devuelve verdadero si se inicializo correctamente
	 */
	public function init($ip='192.168.1.107',$puerto=9301){
		$this->socket= new PHPWebSocket();	
		
		$this->socket->bind('message', 'wsOnMessage');
		$this->socket->bind('open', 'wsOnOpen');
		$this->socket->bind('close', 'wsOnClose');     
		return $this->socket->wsStartServer($ip,$puerto);
	}

	public function a(){
		// Create a array
		$stack = array();

		//Initiate Multiple Thread
		foreach ( range("A", "D") as $i ) {
		    $stack[] = new AsyncOperation($i);
		}

		// Start The Threads
		foreach ( $stack as $t ) {
		    $t->start();
		}
	}
	public function client(){
		$data['control'] = $this->controlador->get_last();
		$data['plataforma'] = $this->plataforma->get_last();
		
		
		$this->load->view('admin/consola',$data);
	}

	/**
	 * Se ejecuta cuando llega un mensaje al socket enmascarado 
	 * de acuerdo al estandar WebSocket Protocol 07 (http://tools.ietf.org/html/draft-ietf-hybi-thewebsocketprotocol-07)
	 * 
	 * @param  Integer $clientID      Identificador del cliente
	 * @param  String $message       Mensaje
	 * @param  Integer $messageLength Tamano del mensaje
	 * @param  [type] $binary        [description]
	 */
		
	function wsOnMessage($clientID, $message, $messageLength, $binary) {
	

		$ip = long2ip($this->socket->wsClients[$clientID][6]);		
	
	//	$this->socket->log("$ip ($clientID) send to message.");	

		// check if message length is 0
		if ($messageLength == 0) {
			$this->socket->wsClose($clientID);
			return;
		}
		$msj=json_decode($message,true);
		print_r($msj);
		//Si es un mensaje tipo {'cliente':'admin'} seteo la posicion 12 
		//ademas seteo dos variables para mantener el ID del cliente de cada extremo
		if (isset($msj['cliente'])){
			if($msj['cliente']=="plataforma"){
				$this->plataformaID=$clientID;
				//2 segundos
				usleep(2000000);
			}
			if($msj['cliente']=="controlador"){
				$this->controladorID=$clientID;
			}
			$this->socket->wsClients[$clientID][12] = $msj['cliente'];
		}
	
		//verifico si ya tienen definido un tipo en la posicion 12
		//ya se sabe si el mensaje viene desde el controlador o la plataforma
		if(isset($this->socket->wsClients[$clientID][12]) && !isset($msj['cliente'])){
			echo "clientID: [".$clientID.'] === ';
			echo "plataformaID: [".$this->plataformaID.'] === ';
			echo "controladorID: [".$this->controladorID.'],  ';
			//si el mensaje vino de la plataforma
			if($clientID==$this->plataformaID){

				//obtengo la ultima orden escrita en la base de datos por el controlador
				$ultima_orden = $this->controlador->get_last();
				if(!is_null($ultima_orden)){
					echo 'enviando datos del controlador';
					$this->socket->wsSend($clientID,json_encode($ultima_orden));
				}

				$datos = array(
					'leido'=>FALSE,
					'fecha'=>microtime(true)
				);
				$datos = array_merge($datos,$msj);
				//guardo los datos en la tabla plataforma
				$this->plataforma->save($datos);

				//if($this->controladorID)
				//	$this->socket->wsSend($this->controladorID,json_encode($msj));
			}
			//si el mensaje vino del controlador
			if($clientID==$this->controladorID){
				echo "msj from: controlador".$this->controladorID;
				$datos = array(
					'leido'=>FALSE,
					'fecha'=>microtime(true)
				);
				$datos = array_merge($datos,$msj);
				//guardo los datos en la tabla controlador
				$this->controlador->save($datos);
				echo "plataformaID: [".$this->plataformaID.'] ';
				if($this->plataformaID){
					echo "enviando mensaje a plataforma";
					$this->socket->wsSend($this->plataformaID,json_encode($msj));
				}
				//obtengo la ultima posicion escfrita en la base de datos por la plataforma
				$ultimo_comando = $this->plataforma->get_last();
				if(!is_null($ultimo_comando)){
					//foreach ($this->socket->wsClients as $d => $c) {
						//echo json_encode($ultimo_comando);
						//envio la ultima posicion de la plataforma al controlador
						$this->socket->wsSend($clientID,json_encode($ultimo_comando));
					//}
				}
			}
		//	$this->socket->wsSend($clientID,json_encode($msj));
	 	//	$this->socket->log("$ip ($clientID) se guardo");
		//}
		}	 
	}


	/**
	 * Se ejecuta cuando un nuevo cliente se conecta al socket
	 * 
	 * @param  Integer $clientID Identificador del cliente
	 * @return [type]           [description]
	 */
	function wsOnOpen($clientID) {
		$ip = long2ip($this->socket->wsClients[$clientID][6]);
		$this->socket->log("$ip ($clientID) has connected.");
		//Send a join notice to everyone but the person who joined
		/*foreach ($this->socket->wsClients as $id => $client)
			if ($id != $clientID)
				$this->socket->wsSend($id, json_encode(array('tipo'=>'conexion','clienteId'=>$clientID ,'ip'=>$ip)));
		*/
	}

	/**
	 * Se ejecuta cuando un cliente se desconecta del socket
	 * 
	 * @param  Integer $clientID Identificador del cliente
	 * @return [type]           [description]
	 */

	function wsOnClose($clientID, $status) {

		$ip = long2ip($this->socket->wsClients[$clientID][6]);
	
		$this->socket->log("$ip ($clientID) has disconnected.");
 
		//Send a user left notice to everyone in the room
		//foreach ($this->socket->wsClients as $id => $client)
		//	$this->socket->wsSend($id, json_encode(array('tipo'=>'desconexion','cliente'=>$clientID ,'ip'=>$ip)));
	}


}

