<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plataforma extends CI_Model{

	/**
	 * Devuelve el ultimo dato registrado de la plataforma
	 */
	public function get_last(){
		$this->db->select('ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal');
		$dato = $this->db->limit(1)->order_by('id','desc')->get('plataforma')->row_array();
		return $dato;
	}

	/**
	 * Guarda los datos enviados desde la plataforma
	 */
	public function save($datos){

		return $this->db->insert('plataforma',$datos);
	}
}