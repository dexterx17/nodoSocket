<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlador extends CI_Model{

	public function get_last(){
		$servername = "192.168.120.6";
		$servername = "localhost";
		$username = "root";
		$password = "hunterhacker";
		$password = "0112358";

		$db = "nodos";
		$db = "nodo";

		// Create connection
		$conn =  mysqli_connect($servername, $username, $password,$db);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}


		$result = mysqli_query($conn,"SELECT com,valorx,valory,valorz,errorx,errory,errorz,control FROM controlador order by id desc limit 1 ");
		$new_array= array();
		while ($row = mysqli_fetch_array($result)) {
		    $new_array = $row;
		}
		mysqli_close($conn);// close mysql then do other job with set_time_limit(59)
		return $new_array;
	}
	/**
	 * Devuelve el ultimo dato enviado desde el controlador
	 */
	public function get_last_old(){
		$this->db->select('com,valorx,valory,valorz,errorx,errory,errorz,control');
		$dato = $this->db->limit(1)->order_by('id','desc')->get('controlador')->row_array();
		return $dato;
	}

	/**
	 * Guarda los datos enviados desde la plataforma
	 */
	public function save($datos){
		$servername = "192.168.120.6";
		$servername = "localhost";
		$username = "root";
		$password = "hunterhacker";
		$password = "0112358";

		$db = "nodos";
		$db = "nodo";

		// Create connection
		$conn =  mysqli_connect($servername, $username, $password,$db);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$sql = "INSERT INTO controlador (com,valorx,valory,valorz,errorx,errory,errorz,control)
			VALUES ('".$datos['com']."', '".$datos['valorx']."', '".$datos['valory']."', '".$datos['valorz']."', '".$datos['errorx']."', '".$datos['errory']."', '".$datos['errorz']."', '".$datos['control']."')";

		if (mysqli_query($conn, $sql)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Guarda los datos enviados desde el controlador
	 */
	public function save_old($datos){

		return $this->db->insert('controlador',$datos);
	}


}