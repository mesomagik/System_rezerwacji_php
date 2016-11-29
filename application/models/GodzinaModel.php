<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GodzinaModel extends CI_Model {
	protected $table = 'godzina';
	function __construct(){
		parent::__construct();
	}
	
	public function get_godzina_by_id_better($id){
		//godzina po id
		$query = $this->db->query('SELECT * FROM godzina WHERE id_godzina='.$id);
		
		foreach($query->result() as $row=>$obj){
			$result =array(
			'id_godzina'=>$obj->id_godzina,
			'godzina'=>$obj->godzina);
		}
		return $result;
	}
	
	public function get_godziny_pracy_better($id_pocz,$id_kon){
		$result = array();
		array_push($result,$this->get_godzina_by_id_better($id_pocz));
		array_push($result,$this->get_godzina_by_id_better($id_kon));
		return $result;
	}
	
	public function get_all_godzina_better(){
		//zwraca wszystkie dni pracy
		$data=array();
		$query = $this->db->query('select * from godzina');	
		foreach($query->result() as $row){
				array_push($data,array(
				'id_godzina'=>$row->id_godzina,
				'godzina'=>substr($row->godzina,0,5)
				));
			
		}
		return $data;
	}
	
	public function get_free_hours_by_day($id_dzien,$godz_pocz,$godz_kon){
		
		//TODO: wykluczyć indeksy dni których nie ma w bazie i zrobić redirect
		
		$result=array();
		$query = $this->db->query('SELECT g.*, w.id_wizyta FROM godzina g, wizyta w WHERE g.id_godzina not in 
		(select g.id_godzina from godzina g, wizyta w where w.wizyta_id_data='.$id_dzien.' and wizyta_id_godzina=id_godzina) 
		group by g.id_godzina');
		
		$query = $query->result();
		
		for($i=0;$i<count($query);$i++){
			array_push($result,array(
			'id_godzina'=>$query[$i]->id_godzina,
			'godzina'=>substr($query[$i]->godzina,0,5)));
			}

		return $result;
	}
	
	public function get_all_godzina(){
		//zwraca wszystkie dni pracy
		$data['godziny']=array();
		$query = $this->db->query('select * from godzina');	
		foreach($query->result() as $row){
				array_push($data['godziny'],array('id_godzina'=>$row->id_godzina,'godzina'=>$row->godzina));
			
		}
		return $data;
	}
	
	public function get_godzina_by_id($id){
		//godzina po id
		$result = array();
		$query = $this->db->query('SELECT * FROM godzina WHERE id_godzina='.$id);
		
		foreach($query->result() as $row=>$obj){
			array_push($result,array(
			'id_godzina'=>$obj->id_godzina,
			'godzina'=>$obj->godzina));
		}
		return $result;
	}
	
	public function get_godziny_pracy($id_pocz,$id_kon){
		$result = array();
		array_push($result,$this->get_godzina_by_id($id_pocz));
		array_push($result,$this->get_godzina_by_id($id_kon));
		return $result;
	}
	
	//duplikat żeby nie zmieniać dużo (lepsze funkcje poniżej)
	
	
	
}

?>