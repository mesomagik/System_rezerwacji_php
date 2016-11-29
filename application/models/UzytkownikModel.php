<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UzytkownikModel extends CI_Model {
	
	private $table = 'user';
	
	public function get_all(){
		//zwraca wszystkie dni pracy
		$query = $this->db->query('select d.data, g1.godzina as godzina_pocz, g2.godzina as godzina_kon from dzien d, godzina g1, godzina g2 where d.dzien_id_godzina_pocz=g1.id_godzina and d.dzien_id_godzina_kon=g2.id_godzina' );	
		return $query;
	}
	
	public function get_user_by_id($id){
		//uzytkownik po id
		$query = $this->db->query('SELECT * FROM user WHERE id="'.$id.'";');
		
		foreach($query->result() as $row=>$obj){
			$result=array(
				'id'=>$obj->id,
				'email'=>$obj->email,
				'imie'=>$obj->imie,
				'nazwisko'=>$obj->nazwisko,
				'adres'=>$obj->adres,
				'pesel'=>$obj->pesel,
				'telefon'=>$obj->telefon,
				'haslo'=>$obj->haslo,
				'aktywne'=>$obj->aktywne);
		}
		return $result;
	}
	
	public function get_user_by_id_wizyta($id_wizyta){
		//uzytkownik po id
		$query = $this->db->query('SELECT * FROM user u,wiadomosc wia, wizyta wiz WHERE wiz.wizyta_id_uzytkownik=u.id and wia.wiadomosc_id_wizyta = wiz.id_wizyta and id_wizyta="'.$id_wizyta.'";');
		
		foreach($query->result() as $row=>$obj){
			$result=array(
				'id'=>$obj->id,
				'email'=>$obj->email,
				'imie'=>$obj->imie,
				'nazwisko'=>$obj->nazwisko,
				'adres'=>$obj->adres,
				'pesel'=>$obj->pesel,
				'telefon'=>$obj->telefon,
				'haslo'=>$obj->haslo,
				'aktywne'=>$obj->aktywne);
		}
		return $result;
	}
	
	public function usun($user){
		$this->db->where('id',$user->getId());
		return $this->db->delete($this->table);	 
	}
	
	
	public function update($user){
		
		//var_dump($user);
		$id = $user->getId();
		$fields = array(			
		'imie'=>$user->getImie(),
		'email'=>$user->getEmail(),
		'nazwisko'=>$user->getNazwisko(),
		'adres'=>$user->getAdres(),
		'telefon'=>$user->getTelefon(),
		'pesel'=>$user->getPesel(),
		'haslo'=>$user->getHaslo(),
		'aktywne'=>$user->getAktywne()
		);
		
		$this->db->where('id',$id);
		$this->db->update($this->table,$fields);
	}
	
	public function get_all_user($ilosc){
		$result = array();
		
		$query = $this->db->query('SELECT * FROM user order by id desc');
		
		foreach($query->result() as $row=>$obj){
			if($obj->id>1)
			array_push($result,array(
				'id'=>$obj->id,
				'email'=>$obj->email,
				'imie'=>$obj->imie,
				'nazwisko'=>$obj->nazwisko,
				'adres'=>$obj->adres,
				'pesel'=>$obj->pesel,
				'telefon'=>$obj->telefon,
				'haslo'=>$obj->haslo,
				'aktywne'=>$obj->aktywne));
		}
		return $result;
	}
	
	public function search_user($params){
		$result = array();
		
		$zapytanie = 'select * from user where ';
		
		$i=0;
		
		if($params['imie'] != ''){
			$zapytanie.="imie = '".$params['imie']."' ";
			$i++;
			
		}
		if($params['nazwisko'] != ''){
			if($i>0){
				$zapytanie.=' and ';
			}
			$zapytanie.='nazwisko = "'.$params['nazwisko'].'" ';
			$i++;
			
		}
		if($params['pesel'] != ''){
			if($i>0){
				$zapytanie.=' and ';
			}
			$zapytanie.='pesel = "'.$params['pesel'].'" ';
			$i++;
		}
		if($params['telefon'] != ''){
			if($i>0){
				$zapytanie.=' and ';
			}
			$zapytanie.='telefon = "'.$params['telefon'].'" ';
			$i++;
		}
		if($params['adres'] != ''){
			if($i>0){
				$zapytanie.=' and ';
			}
			$zapytanie.='adres = "'.$params['adres'].'" ';
			$i++;
		}
		if($params['nieaktywne_szukaj'] == '1'){
			if($i>0){
				$zapytanie.=' and ';
			}
			$zapytanie.='aktywne = "0" ';
			$i++;
		}
		
		$query = $this->db->query($zapytanie);
		
		foreach($query->result() as $row=>$obj){
			if($obj->id>1)
			array_push($result,array(
				'id'=>$obj->id,
				'email'=>$obj->email,
				'imie'=>$obj->imie,
				'nazwisko'=>$obj->nazwisko,
				'adres'=>$obj->adres,
				'pesel'=>$obj->pesel,
				'telefon'=>$obj->telefon,
				'haslo'=>$obj->haslo,
				'aktywne'=>$obj->aktywne));
		}
		return $result;
	}
}

?>