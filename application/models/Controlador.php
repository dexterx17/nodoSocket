<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlador extends CI_Model{

	/**
	 * Devuelve el ultimo dato enviado desde el controlador
	 */
	public function get_last(){
		$this->db->select('com,valorx,valory,valorz,errorx,errory,errorz,control');
		$dato = $this->db->limit(1)->order_by('id','desc')->get('controlador')->row_array();
		echo "CONTROL";
		print_r($dato);
		return $dato;
	}

	/**
	 * Guarda los datos enviados desde el controlador
	 */
	public function save($datos){

		return $this->db->insert('controlador',$datos);
	}
}