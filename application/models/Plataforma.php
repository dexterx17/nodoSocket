<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plataforma extends CI_Model{

	/**
	 * Devuelve todos los datos registrados de la plataforma
	 */
	public function get_all_new(){
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


		$result = mysqli_query($conn,"SELECT ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal FROM plataforma order by id desc limit 1 ");
		$new_array= array();
		while ($row = mysqli_fetch_array($result)) {
		//	print_r($row);
		    $new_array[] = $row;
		}
		mysqli_close($conn);// close mysql then do other job with set_time_limit(59)
		return $new_array;
	}

	/**
	 * Devuelve todos los datos registrados de la plataforma
	 */
	public function get_all(){
		$this->db->select('ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal');
		return $this->db->limit(1)->order_by('id','desc')->get('plataforma')->result_array();
	}


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


		$result = mysqli_query($conn,"SELECT ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal FROM plataforma order by id desc limit 1 ");
		$new_array= array();
		while ($row = mysqli_fetch_array($result)) {
		    $new_array = $row;
		}
		mysqli_close($conn);// close mysql then do other job with set_time_limit(59)
		return $new_array;
	}

	/**
	 * Devuelve el ultimo dato registrado de la plataforma
	 */
	public function get_last_old(){
		$this->db->select('ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal');
		$dato = $this->db->limit(1)->order_by('id','desc')->get('plataforma')->row_array();
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

		$sql = "INSERT INTO plataforma (ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal)
			VALUES ('".$datos['ok']."', '".$datos['valorx']."', '".$datos['valory']."', '".$datos['teta']."', '".$datos['q1']."', '".$datos['q2']."', '".$datos['q3']."', '".$datos['q4']."', '".$datos['ftang']."', '".$datos['fnormal']."')";

		if (mysqli_query($conn, $sql)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Guarda los datos enviados desde la plataforma
	 */
	public function save_old($datos){

		return $this->db->insert('plataforma',$datos);
	}
}