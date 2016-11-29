<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WizytaControler extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this ->load->model(array('dzienModel'));
		$this ->load->model(array('godzinaModel'));
		$this ->load->model(array('wizytaModel'));
		$this ->load->model(array('wiadomoscModel'));
		if (!isset($_SESSION)){
			session_start();
		}
		if(empty($_SESSION['admin'])){
			redirect(base_url('strona_404'));
		}
	}
	
	public function update(){
		
		
		extract($_POST);
		var_dump($_POST);
		
		$wizyta_przenoszona = $this->wizytaModel->get_wizyta_by_id($_POST['id_wizyta']);
		
		$id_dzien = $this->dzienModel->check_if_exist($_POST['data1']); //sprawdzenie czy dzien istnieje w bazie
		echo $id_dzien;
		if($id_dzien==0){
			
			$params['data'] = $_POST['data1'];
			$params['dzien_id_godzina_pocz'] = $_POST['przenies_godzina'];
			if($wizyta_przenoszona['pierwsza'] == '1'){
				$params['dzien_id_godzina_kon'] = $_POST['przenies_godzina']+2;
			}
			else{
				$params['dzien_id_godzina_kon'] = $_POST['przenies_godzina']+1;
			}
			$this->dzienModel->insert($params);
			
			$id_dzien = $this->dzienModel->check_if_exist($_POST['data1']); //pobranie id dnia
			
			$data['id_wizyta'] = $_POST['id_wizyta'];
			$data['wizyta_id_data'] = $id_dzien;
			$data['wizyta_id_godzina'] = $_POST['przenies_godzina'];
	
			$this->wizytaModel->update($data);
			redirect(base_url('szczegolyDnia/'.$id_dzien));
		}else{
			$data['id_wizyta'] = $_POST['id_wizyta'];
			$data['wizyta_id_data'] = $id_dzien;
			$data['wizyta_id_godzina'] = $_POST['przenies_godzina'];
	
			$this->wizytaModel->update($data);
			redirect(base_url('szczegolyDnia/'.$id_dzien));
		}
	}
	
	public function delete($id_wizyta){
		extract($_POST);
		//var_dump($_POST);
		$id_wizyta=$_POST['id_wizyta'];
		$this->wizytaModel->delete($id_wizyta);
		redirect(base_url('/szczegolyDnia/'.$id_dzien));
	}
	
	public function insertZarejestrowany(){
		extract($_POST);
		var_dump($_POST);
		
		
		$id_dzien = $this->dzienModel->check_if_exist($_POST['data1']); //sprawdzenie czy dzien istnieje w bazie
		//echo $id_dzien;
		if($id_dzien==0){
			
			$params['data'] = $_POST['data1'];
			$params['dzien_id_godzina_pocz'] = $_POST['przenies_godzina'];			
			$params['dzien_id_godzina_kon'] = $_POST['przenies_godzina']+1;
			$this->dzienModel->insert($params);
			
			$id_dzien = $this->dzienModel->check_if_exist($_POST['data1']); //pobranie id dnia			
		}
		
		$params['wizyta_id_uzytkownik'] = $_POST['id_user'];
		$params['wizyta_id_data'] = $id_dzien;
		$params['odbyta'] = '0';
		$params['wizyta_id_godzina'] = $_POST['przenies_godzina'];
		$params['pierwsza'] = '0';
		//wizyta
		$id_wizyta = $this->wizytaModel->insert($params);
		
		//wiadomosc
		$params['wiadomosc_id_wizyta'] = $id_wizyta;
		$params['wiadomosc_id_user'] = '1';
		$params['tekst'] = 'wizyta zarejestrowana przez administratora w dniu '.date('Y-m-d').'.';
		//wiadomosc
		$this->wiadomoscModel->insert($params);
		
		redirect(base_url('szczegolyDnia/'.$id_dzien));
	}
	
	public function dodajWizyte($id_dzien){
		
		
		$dzien = $this->dzienModel->get_day_by_id($id_dzien);
		$params['dzien'] = $dzien;
		//var_dump($dzien);
		
		$wizyty_dnia_zarejestrowani = $this->wizytaModel->get_all_by_day_zarejestrowani($id_dzien);
		$wizyty_dnia_niezarejestrowani = $this->wizytaModel->get_all_by_day_niezarejestrowani($id_dzien);
		$wizyty_wszystkie = array_merge($wizyty_dnia_zarejestrowani,$wizyty_dnia_niezarejestrowani);
		//var_dump($wizyty_wszystkie);
		
		$godziny = $this->godzinaModel->get_free_hours_by_day($id_dzien,$dzien['dzien_id_godzina_pocz'],$dzien['dzien_id_godzina_kon']);	
		
		//var_dump($godziny);
		
		$iterator= array_merge($wizyty_wszystkie, $godziny); //iterator - array wizyt i wolnych godzin

		array_walk($iterator, function (& $item) { //zamiana 'wizyta_id_godzina' na 'id_godzina
			if(!empty($item['id_wizyta'])){
				$item['id_godzina'] = $item['wizyta_id_godzina'];
				unset($item['wizyta_id_godzina']);
			}
		});
		
		$this->array_sort_by_column($iterator, 'id_godzina'); //sortowanie
		
		//var_dump($iterator);
		
		$wolne_godziny = array();
		$tmp=0; //flaga pierwszej wizyty
		
		for($i=$dzien['dzien_id_godzina_pocz']-1;$i<$dzien['dzien_id_godzina_kon']-1;$i++){
			//wybranie wolnych godzin
			if(!empty($iterator[$i]['pierwsza']) && $iterator[$i]['pierwsza']=='1'){
				$tmp=1;
				
			}else if(!empty($iterator[$i]['pierwsza']) && $iterator[$i]['pierwsza']=='0'){
				$tmp=0;
			}else if(!empty($iterator[$i]['id_godzina']) && $iterator[$i]['id_godzina']==$i+1 && $tmp!=1 && $iterator[$i]['id_godzina']<$dzien['dzien_id_godzina_kon'] && !empty($iterator[$i]['godzina'])){
					array_push($wolne_godziny, $iterator[$i]);
					$tmp=0;
			}else {
				$tmp=0;
			}
			
			/* stara funkcja
			if(!empty($wizyty_wszystkie)){
				for($j=0;$j<count($wizyty_wszystkie);$j++){
					echo $i;
					if($godziny[$i]['id_godzina']>=$dzien['dzien_id_godzina_pocz'] && $godziny[$i]['id_godzina']<$dzien['dzien_id_godzina_kon']){
						if($wizyty_wszystkie[$j]['pierwsza'] == '1' && $wizyty_wszystkie[$j]['wizyta_id_godzina'] == $godziny[$i]['id_godzina']-1)	{ //nic nie robi	
						}else{
							array_push($wolne_godziny, $godziny[$i]);
						}
					}else{
					//nic nie robi	
					}
				}		
			}else{ 
				if(!empty($godziny[$i]) && $godziny[$i]['id_godzina']>$dzien['dzien_id_godzina_pocz'] && $godziny[$i]['id_godzina']<$dzien['dzien_id_godzina_kon']){
					array_push($wolne_godziny, $godziny[$i]);
				}
			}
			*/
		}
		if(count($wolne_godziny)<1 || $dzien['data']<date("Y-m-d")){ //powrot do szczegolow dnia jesli nie ma wolnych godzin lub data jest stara
			redirect(base_url('szczegolyDnia/'.$id_dzien));
		}
		//var_dump($wolne_godziny);
		$params['wolne_godziny'] = $wolne_godziny;
		
		$params['article'] = 'wizyta/dodajWizyte';
		$this->load->view('template',$params);
		
	}
	
	public function insertAnonim() {
		
		extract($_POST);
		if(isset($_POST['input_button'])){
		if($_POST['input_pierwsza']=='1'){
			$pierwsza='tak';
		}else{
			$pierwsza='nie';
		}
		
		echo $opis='Imie i nazwisko: '.$_POST['input_imie'].'
Telefon: '.$_POST['input_telefon'].'
Pesel: '.$_POST['input_pesel'].'
Opis: '.$_POST['input_opis'];
		
		//wizyta
		$params['wizyta_id_uzytkownik'] = '0';
		$params['wizyta_id_data'] = $_POST['id_dzien'];
		$params['odbyta'] = '0';
		$params['wizyta_id_godzina'] = $_POST['input_godzina'];
		$params['pierwsza'] = $_POST['input_pierwsza'];
		//wizyta
		$id_wizyta = $this->wizytaModel->insert($params);
		
		//wiadomosc
		$params['wiadomosc_id_wizyta'] = $id_wizyta;
		$params['wiadomosc_id_user'] = '0';
		$params['tekst'] = $opis;
		//wiadomosc
		$this->wiadomoscModel->insert($params);
		
		redirect(base_url('szczegolyDnia/'.$_POST['id_dzien']));
		}
	}
	
	
	
	
	public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
}