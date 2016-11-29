<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UzytkownikControler extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('uzytkownikModel'));
		$this->load->model(array('wizytaModel'));
		$this->load->model(array('godzinaModel'));
		$this->load->model(array('dzienModel'));
		if (!isset($_SESSION)){
			session_start();
		}
		
		
	}
	
	public function newObj($user)
	{
		$obj = new UzytkownikControler();
		
		$obj->setId($user['id']);
		$obj->setImie($user['imie']);
		$obj->setEmail($user['email']);
		$obj->setNazwisko($user['nazwisko']);
		$obj->setAdres($user['adres']);
		$obj->setTelefon($user['telefon']);
		$obj->setPesel($user['pesel']);
		$obj->setHaslo($user['haslo']);
		$obj->setAktywne($user['aktywne']);
		
		return $obj;
		
	}

	private $id;
	private $email;
	private $imie;
	private $nazwisko;
	private $adres;
	private $pesel;
	private $telefon;
	private $haslo;
	private $aktywne;
	
	public function getObj(){
		return $this;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setImie($imie){
		$this->imie = $imie;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function setNazwisko($nazwisko){
		$this->nazwisko = $nazwisko;
	}
	
	public function setAdres($adres){
		$this->adres = $adres;
	}
	
	public function setPesel($pesel){
		$this->pesel = $pesel;
	}
	
	public function setTelefon($telefon){
		$this->telefon = $telefon;
	}
	
	public function setHaslo($haslo){
		$this->haslo = $haslo;
	}
	
	public function setKod_pocztowy($kod_pocztowy){
		$this->kod_pocztowy = $kod_pocztowy;
	}
	
	public function setAktywne($aktywne){
		$this->aktywne = $aktywne;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getImie(){
		return $this->imie;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getNazwisko(){
		return $this->nazwisko;
	}
	
	public function getAdres(){
		return $this->adres;
	}
	
	public function getPesel(){
		return $this->pesel;
	}
	
	public function getTelefon(){
		return $this->telefon;
	}
	
	public function getHaslo(){
		return $this->haslo;
	}
	
	public function getAktywne(){
		return $this->aktywne;
	}

	private function update($user){
		//var_dump($this);
		$this->uzytkownikModel->update($user);
	}
	
	private function usun($user){
		$this->uzytkownikModel->usun($user);
	}
	
	
	
	public function login()
	{
		
		extract($_POST);
		var_dump($_POST);
		
		$admin = $this->uzytkownikModel->get_user_by_id('1');
		var_dump($admin);
		if($admin['email'] == $_POST['email'] && $admin['haslo'] == $_POST['haslo']){
			//echo' 123';
			
			$_SESSION['admin']='1';
			redirect(base_url(''));
			$data = 'no_error';
			$this->session->set_flashdata('error',$data);
		}else{
			session_destroy();

			$data = 'error';
			$this->session->set_flashdata('error',$data);
			
			redirect(base_url(''),'refresh');
		}
	}
	
	public function logout(){
		session_destroy();
		redirect(base_url(''));
	}
	
	
	public function index($strona)
	{
		if(empty($_SESSION['admin'])){
			redirect(base_url('strona_404'));
		}
		if(empty($strona)){
			$strona=1;
		}
		extract($_POST);
			
		$ilosc = 7; // ilosc wyników na stronie
			
		$query = $this->uzytkownikModel->get_all_user($ilosc);
		$uzytkownicy = array();
		
		foreach($query as $row){
			array_push($uzytkownicy,$this->newObj($row));
		}
		if(isset($_POST['aktywuj'])){
			for($i=0; $i<count($uzytkownicy);$i++){
				if($uzytkownicy[$i]->getId() == $_POST['id']){
					$uzytkownicy[$i]->setAktywne($_POST['aktywne']);
					$this->update($uzytkownicy[$i]);
				}
			}			
		}
		
		$params['strona'] = $strona;
		$params['ilosc'] = $ilosc;
		$params['uzytkownicy'] = $uzytkownicy;
		
		$params['article'] = 'uzytkownik/index';
		$this->load->view('template',$params);
		
	}
	
	public function wyszukaj(){

	
		if(empty($_SESSION['admin'])){
			redirect(base_url('strona_404'));
		}
		extract($_POST);
		//var_dump($_POST);
		
		$wysz = $_POST;
		
		if(!empty($_POST)){
			$query = $this->uzytkownikModel->search_user($_POST);
			$uzytkownicy = array();
			
			foreach($query as $row){
				array_push($uzytkownicy,$this->newObj($row));
			}
			if(isset($_POST['aktywuj'])){
				for($i=0; $i<count($uzytkownicy);$i++){
					if($uzytkownicy[$i]->getId() == $_POST['id']){
						$uzytkownicy[$i]->setAktywne($_POST['aktywne']);
						$this->update($uzytkownicy[$i]);
					}
				}			
			}
			$params['wyniki'] = $wysz;
			$params['uzytkownicy'] = $uzytkownicy;
			$params['pierwsze_wyszukiwanie'] = 0;
		}else{
			$params['pierwsze_wyszukiwanie'] = 1;
		}
		
		
		$params['article'] = 'uzytkownik/wyszukaj';
		$this->load->view('template',$params);
		
	
	}
	
	public function user($id){
		
		if(empty($_SESSION['admin'])){
			redirect(base_url('strona_404'));
		}
		extract($_POST);
		//var_dump($_POST);
			
		$query = $this->uzytkownikModel->get_user_by_id($id);
		
		if(empty($query)){
			redirect(base_url('strona_404'));
		}
		
		$uzytkownik = $this->newObj($query);
	
		$wizyty = $this->wizytaModel->get_wyzyty_by_user($uzytkownik->getId());

		//var_dump($wizyty);
		
		$dni = array();
		for($i=0;$i<count($wizyty);$i++){
			array_push($dni,$this->dzienModel->get_day_by_id($wizyty[$i]['wizyta_id_data']));
		}
		//var_dump($dni);
		
		$godziny = $this->godzinaModel->get_all_godzina_better();
		//var_dump($godziny);
		
		
		if(isset($_POST['aktywuj'])){
			//var_dump($uzytkownik);
			$uzytkownik->setAktywne($_POST['aktywne']);
			$this->update($uzytkownik);
		}
		
		if(isset($_POST['usun'])){
			$this->usun($uzytkownik);
			redirect(base_url('pacjenci/1'));
		}
		
		$params['wizyty'] = $wizyty;
		$params['dni'] = $dni;
		$params['godziny'] = $godziny;
		$params['uzytkownik'] = $uzytkownik;
		
		$params['article'] = 'uzytkownik/user';
		$this->load->view('template',$params);
		
		
	}
	
	public function haslo($id,$nowe_haslo){
		
		$id_baza= hexdec($id)/74;
		$nowe_haslo;
		
		$query = $this->uzytkownikModel->get_user_by_id($id_baza);
		
		if(empty($query)){
			redirect(base_url('strona_404'));
		}
		
		$uzytkownik = $this->newObj($query);
		$uzytkownik->setHaslo($nowe_haslo);
		$this->update($uzytkownik);
		
	}
	
}






