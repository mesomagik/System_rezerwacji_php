<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_model extends CI_Model {
	protected $table = 'dzien';
	function __construct(){
		parent::__construct();
	}
	
	
	public function update($params){
		
		$fields = array(
			'id_dzien'=>$params['id_dzien'],
			'data'=>$params['data'],
			'dzien_id_godzina_pocz'=>$params['dzien_id_godzina_pocz'],
			'dzien_id_godzina_kon'=>$params['dzien_id_godzina_kon'] 
		);
		
		$this->db->insert($this->table,$fields);
	}
	
	public function get_all(){
		$this->db->select('data');
		$this->db->from('dzien');
		$this->db->where('id_dzien=1');
		$query = $this->db->get();
			
		return $query;
	}
}

?>