<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DzienModel extends CI_Model {
	
	private $table = "dzien";
	
	public function insert($params){
		
		$id = $this->get_max_id();
		$fields = array(
			'id_dzien'=>$id+1,
			'data'=>$params['data'],
			'dzien_id_godzina_pocz'=>$params['dzien_id_godzina_pocz'],
			'dzien_id_godzina_kon'=>$params['dzien_id_godzina_kon'] 
		);
		
		$this->db->insert($this->table,$fields);
	}
	
	public function update($params){
		
		$id = $params['id_dzien'];
		$fields = array(
			'data'=>$params['data'],
			'dzien_id_godzina_pocz'=>$params['dzien_id_godzina_pocz'],
			'dzien_id_godzina_kon'=>$params['dzien_id_godzina_kon'] 
		);
		$this->db->where('id_dzien',$id);
		$this->db->update($this->table,$fields);
	}
	
	public function get_max_id(){
		$id=NULL;
		$max_id  = $this->db->query('select max(id_dzien) as id_dzien from dzien');
		foreach($max_id->result() as $row){
			$id=$row->id_dzien;
		}
		return $id;
	}
	
	public function delete($id_dzien){
		$this->db->where('id_dzien',$id_dzien);
		return $this->db->delete($this->table);	 
	}
	
	public function get_all(){
		//zwraca wszystkie dni pracy
		$query = $this->db->query('select d.data, g1.godzina as godzina_pocz, g2.godzina as godzina_kon from dzien d, godzina g1, godzina g2 where d.dzien_id_godzina_pocz=g1.id_godzina and d.dzien_id_godzina_kon=g2.id_godzina' );	
		return $query;
	}
	
	public function get_days_by_month_year($year,$month){
		//dni robocze wg miesiąca i roku
		$result = array();
		$query = $this->db->query('SELECT * FROM dzien WHERE data between "'.$year.'-'.$month.'-01" and "'.$year.'-'.$month.'-31"');
		
		foreach($query->result() as $row=>$obj){
			array_push($result,array(
				'id_dzien'=>$obj->id_dzien,
				'data'=>$obj->data,
				'dzien_id_godzina_pocz'=>$obj->dzien_id_godzina_pocz,
				'dzien_id_godzina_kon'=>$obj->dzien_id_godzina_kon));
		}
		return $result;
	}
	
	public function get_day_by_id($id_dzien){
		$query = $this->db->query('SELECT * FROM dzien WHERE id_dzien="'.$id_dzien.'";');
		
		foreach($query->result() as $row=>$obj){
			$result = array(
				'id_dzien'=>$obj->id_dzien,
				'data'=>$obj->data,
				'dzien_id_godzina_pocz'=>$obj->dzien_id_godzina_pocz,
				'dzien_id_godzina_kon'=>$obj->dzien_id_godzina_kon);
		}
		if(!empty($result))return $result;
	}
	
	public function check_if_exist($data_rok_miesiac_dzien){
		$query = $this->db->query('select id_dzien as liczba from dzien where data ="'.$data_rok_miesiac_dzien.'"');
		foreach($query->result() as $row=>$obj){
			$result = $obj->liczba;
		}
		if(!empty($result))
			return $result;
		else return 0;
	}
	
	
}

?>