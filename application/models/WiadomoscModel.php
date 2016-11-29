<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WiadomoscModel extends CI_Model {
	
	private $table = 'wiadomosc';
	
	public function get_wiadomosci_konwersacji($id){
		//wszystkie wiadomosci w konwersacji
		$result['wiadomosc'] = array();
		$query = $this->db->query('SELECT * FROM wiadomosc WHERE wiadomosc_id_wizyta='.$id);
		
		foreach($query->result() as $row=>$obj){
			array_push($result['wiadomosc'],array(
				'id_wiadomosc'=>$obj->	id_wiadomosc,
				'wiadomosc_id_wizyta'=>$obj->wiadomosc_id_wizyta,
				'wiadomosc_id_user'=>$obj->	wiadomosc_id_user,
				'tekst'=>$obj->tekst));
		}
		return $result;
	}
	
	public function insert($params){
		$id = $this->get_max_id();
		$fields = array(
			'id_wiadomosc'=>$id+1,
			'wiadomosc_id_wizyta'=>$params['wiadomosc_id_wizyta'],
			'wiadomosc_id_user'=>$params['wizyta_id_uzytkownik'],
			'tekst'=>$params['tekst'] 
		);
		
		$this->db->insert($this->table,$fields);
	}
	
	public function delete($id_dzien){
		$this->db->where('id_wiadomosc',$id_dzien);
		return $this->db->delete($this->table);	 
	}
	
	public function get_max_id(){
		$id=NULL;
		$max_id  = $this->db->query('select max(id_wiadomosc) as id_wiadomosc from wiadomosc');
		foreach($max_id->result() as $row){
			$id=$row->id_wiadomosc;
		}
		return $id;
	}
	
	public function get_opis_niezarejestrowany($id){
		$query = $this->db->query('SELECT * FROM wiadomosc WHERE wiadomosc_id_wizyta='.$id);
		foreach($query->result() as $row=>$obj){
			$result = array(
				'id_wiadomosc'=>$obj->id_wiadomosc,
				'wiadomosc_id_wizyta'=>$obj->wiadomosc_id_wizyta,
				'wiadomosc_id_user'=>$obj->	wiadomosc_id_user,
				'tekst'=>$obj->tekst);
				return $result;
		}		
	}
	
	public function get_ostatnia_wiadomosc($id_wizyta){
		$query = $this->db->query('SELECT * FROM wiadomosc WHERE wiadomosc_id_wizyta='.$id_wizyta.' and id_wiadomosc=(select max(id_wiadomosc) from wiadomosc where wiadomosc_id_wizyta='.$id_wizyta.')');
		foreach($query->result() as $row=>$obj){
			$result = array(
				'id_wiadomosc'=>$obj->id_wiadomosc,
				'wiadomosc_id_wizyta'=>$obj->wiadomosc_id_wizyta,
				'wiadomosc_id_user'=>$obj->	wiadomosc_id_user,
				'tekst'=>$obj->tekst);
				return $result;
		}
	}
	
	public function get_ostatnie_id_wiadomosci($ilosc){
		$result=array();
		$query = $this->db->query('select wiadomosc_id_wizyta, max(id_wiadomosc) as id_wiadomosc from wiadomosc where id_wiadomosc not in (select id_wiadomosc from wiadomosc where wiadomosc_id_user="0") group by wiadomosc_id_wizyta order by id_wiadomosc desc limit '.$ilosc);
		foreach($query->result() as $row=>$obj){
			array_push($result, array(
				'wiadomosc_id_wizyta'=>$obj->wiadomosc_id_wizyta,
				'id_wiadomosc'=>$obj->id_wiadomosc));				
		}
		return $result;
	}
}

?>