<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StronaDomowaModel extends CI_Model {
	
	private $table = 'strona_domowa';
	
	public function get_info(){
		$query = $this->db->query('SELECT * FROM strona_domowa');
		
		foreach($query->result() as $row=>$obj){
			$result = array(
			'imie_nazwisko'=>$obj->imie_nazwisko,
			'profesja'=>$obj->profesja,
			'miejscowosc'=>$obj->miejscowosc,
			'opis'=>$obj->opis,
			'telefon'=>$obj->telefon,
			'adres_dokladny'=>$obj->adres_dokladny,
			'mapa_x'=>$obj->mapa_x,
			'mapa_y'=>$obj->mapa_y,
			'opis_markera'=>$obj->opis_markera,
			'opis_aplikacji'=>$obj->opis_aplikacji,
			'link_aplikacji'=>$obj->link_aplikacji);
			
		}
		if(!empty($result))return $result;
	}
	
	public function update($params){
		
		//var_dump($params);
		$fields = array(
			'imie_nazwisko'=>$params['imie_nazwisko'],
			'profesja'=>$params['profesja'],
			'miejscowosc'=>$params['miejscowosc'],
			'opis'=>$params['opis'],
			'telefon'=>$params['telefon'],
			'adres_dokladny'=>$params['adres_dokladny'],
			'mapa_x'=>$params['mapa_x'],
			'mapa_y'=>$params['mapa_y'],
			'opis_markera'=>$params['opis_markera'],
			'opis_aplikacji'=>$params['opis_aplikacji'],
			'link_aplikacji'=>$params['link_aplikacji']);
		$this->db->update($this->table,$fields);
	}
	
	
}

?>