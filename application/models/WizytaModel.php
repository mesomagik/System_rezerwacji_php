<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WizytaModel extends CI_Model {
	
	private $table = 'wizyta';
	
	public function update($params){
		
		//var_dump($params);
		$id = $params['id_wizyta'];
		$fields = array(
			'wizyta_id_data'=>$params['wizyta_id_data'],
			'wizyta_id_godzina'=>$params['wizyta_id_godzina'],
		);
		$this->db->where('id_wizyta',$id);
		$this->db->update($this->table,$fields);
	}
	
	public function get_wizyta_by_id($id_wizyta){
		$result=array();
		$query = $this->db->query('select * from wizyta where id_wizyta='.$id_wizyta);
		foreach($query->result() as $row=>$obj){
			$result=array(
				'id_wizyta'=>$obj->id_wizyta,
				'wizyta_id_uzytkownik'=>$obj->wizyta_id_uzytkownik,
				'wizyta_id_data'=>$obj->wizyta_id_data,
				'odbyta'=>$obj->odbyta,
				'wizyta_id_godzina'=>$obj->wizyta_id_godzina,
				'pierwsza'=>$obj->pierwsza);
		}
		return $result;
		
	}
	
	public function insert($params){
		
		$id=NULL;
		$max_id  = $this->db->query('select max(id_wizyta) as id_wizyta from wizyta');
		foreach($max_id->result() as $row){
			$id=$row->id_wizyta;
		}
		
		$fields = array(
			'id_wizyta'=>$id+1,
			'wizyta_id_uzytkownik'=>$params['wizyta_id_uzytkownik'],
			'wizyta_id_data'=>$params['wizyta_id_data'],
			'odbyta'=>$params['odbyta'],
			'wizyta_id_godzina'=>$params['wizyta_id_godzina'],
			'pierwsza'=>$params['pierwsza'] 			
		);
		
		$this->db->insert($this->table,$fields);
		
		return $id+1; 
	}
	
	public function delete($id_wizyta) {
		$this->db->where('id_wizyta',$id_wizyta);
		return $this->db->delete($this->table);
	}
	
	
	public function get_all_by_day_zarejestrowani($id_dzien){
		//wizyty w danym dniu
		$result = array();
		$query = $this->db->query('SELECT * FROM wizyta WHERE wizyta_id_data='.$id_dzien);
		
		foreach($query->result() as $row=>$obj){
			if($obj->wizyta_id_uzytkownik != '0')
			array_push($result,array(
				'id_wizyta'=>$obj->id_wizyta,
				'wizyta_id_uzytkownik'=>$obj->wizyta_id_uzytkownik,
				'wizyta_id_data'=>$obj->wizyta_id_data,
				'odbyta'=>$obj->odbyta,
				'wizyta_id_godzina'=>$obj->wizyta_id_godzina,
				'pierwsza'=>$obj->pierwsza));
		}
		return $result;
	}
	
	public function get_all_by_day_niezarejestrowani($id_dzien){
		//wizyty w danym dniu
		$result = array();
		$query = $this->db->query('SELECT * FROM wizyta WHERE wizyta_id_data='.$id_dzien);
		
		foreach($query->result() as $row=>$obj){
			if($obj->wizyta_id_uzytkownik == '0')
			array_push($result,array(
				'id_wizyta'=>$obj->id_wizyta,
				'wizyta_id_uzytkownik'=>$obj->wizyta_id_uzytkownik,
				'wizyta_id_data'=>$obj->wizyta_id_data,
				'odbyta'=>$obj->odbyta,
				'wizyta_id_godzina'=>$obj->wizyta_id_godzina,
				'pierwsza'=>$obj->pierwsza));
		}
		return $result;
	}
	
	public function get_count_by_day($data_rok_miesiac_dzien){
		//liczba wizyt w danym dniu
		$query = $this->db->query('select count(id_wizyta) as liczba from wizyta where wizyta_id_data =(select id_dzien from dzien where data="'.$data_rok_miesiac_dzien.'")');
		foreach($query->result() as $row=>$obj){
			$result = $obj->liczba;
		}
		return $result;
	}
	
	public function get_wyzyty_by_user($id_user){
		$result = array();
		$query = $this->db->query('SELECT * FROM wizyta WHERE wizyta_id_uzytkownik='.$id_user.' order by wizyta_id_data');
		
		foreach($query->result() as $row=>$obj){
			array_push($result,array(
				'id_wizyta'=>$obj->id_wizyta,
				'wizyta_id_uzytkownik'=>$obj->wizyta_id_uzytkownik,
				'wizyta_id_data'=>$obj->wizyta_id_data,
				'odbyta'=>$obj->odbyta,
				'wizyta_id_godzina'=>$obj->wizyta_id_godzina,
				'pierwsza'=>$obj->pierwsza));
		}
		return $result;
	}
	
	
}

?>