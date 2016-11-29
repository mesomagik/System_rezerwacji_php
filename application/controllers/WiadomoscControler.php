<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WiadomoscControler extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this ->load->model(array('wiadomoscModel'));
		$this ->load->model(array('uzytkownikModel'));
		$this ->load->model(array('wizytaModel'));
		$this ->load->model(array('dzienModel'));
		$this ->load->model(array('godzinaModel'));
		if (!isset($_SESSION)){
			session_start();
		}
		if(empty($_SESSION['admin'])){
			redirect(base_url('strona_404'));
		}
	}
	
	public function newObj($id_wiadomosc,$wiadomosc_id_wizyta,$wiadomosc_id_user,$tekst)
	{
		$obj = new WiadomoscControler;
		
		$obj->setId_wiadomosc($id_wiadomosc);
		$obj->setWiadomosc_id_wizyta($wiadomosc_id_wizyta);
		$obj->setWiadomosc_id_user($wiadomosc_id_user);
		$obj->setTekst($tekst);	

		return $obj;
	}

	private $id_wiadomosc;
	private $wiadomosc_id_wizyta;
	private $wiadomosc_id_user;
	private $tekst;
	
	public function setId_wiadomosc($id_wiadomosc){
		$this->id_wiadomosc = $id_wiadomosc;
	}
	
	public function setWiadomosc_id_wizyta($wiadomosc_id_wizyta){
		$this->wiadomosc_id_wizyta = $wiadomosc_id_wizyta;
	}
	
	public function setWiadomosc_id_user($wiadomosc_id_user){
		$this->wiadomosc_id_user = $wiadomosc_id_user;
	}
	
	public function setTekst($tekst){
		$this->tekst = $tekst;
	}
	
	
	public function getId_wiadomosc(){
		return $this->id_wiadomosc;
	}
	
	public function getWiadomosc_id_wizyta(){
		return $this->wiadomosc_id_wizyta;
	}
	
	public function getWiadomosc_id_user(){
		return $this->wiadomosc_id_user;
	}
	
	public function getTekst(){
		return $this->tekst;
	}

	public function index()
	{
		extract($_POST);
		if(isset($_POST['ilosc'])){
			$ilosc = $_POST['ilosc'];
		}else{
			$ilosc = 5;
		}
		$ostatnie_id_wiadomosci = $this->wiadomoscModel->get_ostatnie_id_wiadomosci($ilosc);
		//var_dump($ostatnie_id_wiadomosci);
		
		$ostatnie_wiadomosci = array();
		for($i=0;$i<count($ostatnie_id_wiadomosci);$i++){
			array_push($ostatnie_wiadomosci, $this->wiadomoscModel->get_ostatnia_wiadomosc($ostatnie_id_wiadomosci[$i]['wiadomosc_id_wizyta']));
		}
		//var_dump($ostatnie_wiadomosci);
		
		$wizyty = array();
		for($i=0;$i<count($ostatnie_id_wiadomosci);$i++){
			array_push($wizyty,$this->wizytaModel->get_wizyta_by_id($ostatnie_id_wiadomosci[$i]['wiadomosc_id_wizyta']));
		}
		//var_dump($wizyty);
		
		$dni = array();
		for($i=0;$i<count($ostatnie_id_wiadomosci);$i++){
			array_push($dni,$this->dzienModel->get_day_by_id($wizyty[$i]['wizyta_id_data']));
		}
		//var_dump($dni);
		
		$godziny = $this->godzinaModel->get_all_godzina_better();
		//var_dump($godziny);
		
		$uzytkownicy = array();
		for($i=0;$i<count($ostatnie_id_wiadomosci);$i++){
			array_push($uzytkownicy, $this->uzytkownikModel->get_user_by_id_wizyta($ostatnie_id_wiadomosci[$i]['wiadomosc_id_wizyta']));
		}
		//var_dump($uzytkownicy);
		$dane['ostatnie_wiadomosci'] = $ostatnie_wiadomosci;
		$dane['uzytkownicy'] = $uzytkownicy;
		$dane['wizyty'] = $wizyty;
		$dane['dni'] = $dni;
		$dane['godziny'] = $godziny;
		
		$dane['article']= 'wiadomosc/index';
		$this->load->view('template',$dane);
	}
	
	public function insert(){
		
		extract($_POST);
		
		if($_POST['daneZgodne']){
			$params['tekst'] = $_POST['wiadomosc'];
			$params['wiadomosc_id_wizyta'] = $_POST['id_wizyta'];
			$params['wizyta_id_uzytkownik']='1';
			
			$this->wiadomoscModel->insert($params);
			
			redirect(base_url('korespondencja/'.$_POST['id_wizyta']));
		}
	}
	
	public function delete(){
		extract($_POST);
		
			$id_wiadomosc = $_POST['id_wiadomosc'];
			
			$this->wiadomoscModel->delete($id_wiadomosc);
			
			redirect(base_url('korespondencja/'.$_POST['id_wizyta']));
	}
	
	
	public function korespondencja($id){
		$lista_wiadomosci['lista'] = array();
		
		$query = $this->wiadomoscModel->get_wiadomosci_konwersacji($id);
		foreach($query as $row=>$item){
			foreach($item as $row1){
				array_push($lista_wiadomosci['lista'],$this->newObj(
				$row1['id_wiadomosc'],
				$row1['wiadomosc_id_wizyta'],
				$row1['wiadomosc_id_user'],
				$row1['tekst']));					
			}
		}
		
		//var_dump($query);
		
		$lista_wiadomosci['user'] = $this->uzytkownikModel->get_user_by_id_wizyta($id);
		//var_dump($lista_wiadomosci['user']);
		
		$lista_wiadomosci['wizyta'] = $this->wizytaModel->get_wizyta_by_id($id);
		//var_dump($lista_wiadomosci['wizyta']);
		
		$lista_wiadomosci['dzien'] = $this->dzienModel->get_day_by_id($lista_wiadomosci['wizyta']['wizyta_id_data']);
		//var_dump($lista_wiadomosci['dzien']);
		
		$lista_wiadomosci['godzina'] = $this->godzinaModel->get_godzina_by_id_better($lista_wiadomosci['wizyta']['wizyta_id_godzina']);
		//var_dump($lista_wiadomosci['godzina']);
		
		$lista_wiadomosci['article']= 'wiadomosc/korespondencja';
		$this->load->view('template',$lista_wiadomosci);
	}
	
	
	
	
	
}






