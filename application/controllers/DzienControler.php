<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DzienControler extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this ->load->model(array('dzienModel'));
		$this ->load->model(array('godzinaModel'));
		$this ->load->model(array('wizytaModel'));
		$this ->load->model(array('uzytkownikModel'));
		$this ->load->model(array('wiadomoscModel'));
		if (!isset($_SESSION)){
			session_start();
		}
		if(empty($_SESSION['admin'])){
			redirect(base_url('strona_404'));
		}
	}
	
	public function newObj($id_dzien,$data,$dzien_id_godzina_pocz,$dzien_id_godzina_kon)
	{
		$obj = new DzienControler();
		
		$obj->setData($data);
		$obj->setDzien_id_godzina_pocz($dzien_id_godzina_pocz);
		$obj->setDzien_id_godzina_kon($dzien_id_godzina_kon);
		$obj->setId_dzien($id_dzien);
		
		return $obj;
	}

	private $id_dzien;
	private $data;
	private $dzien_id_godzina_pocz;
	private $dzien_id_godzina_kon;
	
	private $lista_dni;
	
	public function setData($data){
		$this->data = $data;
	}
	
	public function setId_dzien($id_dzien){
		$this->id_dzien = $id_dzien;
	}
	
	public function setDzien_id_godzina_pocz($dzien_id_godzina_pocz){
		$this->dzien_id_godzina_pocz = $dzien_id_godzina_pocz;
	}
	
	public function setDzien_id_godzina_kon($dzien_id_godzina_kon){
		$this->dzien_id_godzina_kon = $dzien_id_godzina_kon;
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function getId_dzien(){
		return $this->id_dzien;
	}
	
	public function getDzien_id_godzina_pocz(){
		return $this->dzien_id_godzina_pocz;
	}
	
	public function getDzien_id_godzina_kon(){
		return $this->dzien_id_godzina_kon;
	}

	public function index(){
		$data['data']=array();
		$result = $this->dzienModel->get_all();
		foreach($result->result() as $row){
			array_push($data['data'],$row->data.' '.$row->godzina_pocz.' - '.$row->godzina_kon);
		}
		$this->load->view('Dzien/index',$data);

	}
	
	//insert dnia z formularza
	public function insert_form(){
		$id_dzien=NULL;
		$data = NULL;
		$godz_roz= NULL;
		$godz_zak= NULL;
		
		$dane['godzina']= array();

		$data = $this->godzinaModel->get_all_godzina();
		
		
		extract($_POST);
		$data['data'] = $data1;
		$data['dzien_id_godzina_pocz'] = $dodaj_godzina_roz;
		$data['dzien_id_godzina_kon'] = $dodaj_godzina_zak;
		if(isset($submit_dodaj))
		{
			if($_POST['godzinaZgodna']== true){
			echo $_POST['godzinaZgodna'];
			$this->dzienModel->insert($data);
			//var_dump($_POST);
			}
			redirect(base_url('/kalendarz/'.$_POST['year'].'/'.$_POST['month']), 'refresh');
		};
	}
	
	public function update(){
		$id_dzien=NULL;
		$data = NULL;
		$godz_roz= NULL;
		$godz_zak= NULL;
		
		$dane['godzina']= array();

		$data = $this->godzinaModel->get_all_godzina();
		
		
		extract($_POST);
		$data['id_dzien'] = $id_dzien;
		$data['data'] = $data1;
		$data['dzien_id_godzina_pocz'] = $dodaj_godzina_roz;
		$data['dzien_id_godzina_kon'] = $dodaj_godzina_zak;
		if(isset($submit_edytuj))
		{
			if($_POST['godzinaZgodna']== true){
			$this->dzienModel->update($data);
			}
			redirect(base_url('/szczegolyDnia/'.$_POST['id_dzien']), 'refresh');
		};
		
	}
	
	public function delete(){
		extract($_POST);
		//var_dump($_POST);
		$id_dzien=$_POST['id_dzien'];
		$this->dzienModel->delete($id_dzien);
		redirect(base_url('/kalendarz/'.date("Y").'/'.date("m")), 'refresh');
	}
	
	function showDetails($id_dzien){
		
		$query = $this->dzienModel->get_day_by_id($id_dzien);
		if(empty($query)){
			redirect(base_url('strona_404'),'refresh');
		};
		$dzien = $this->newObj($query['id_dzien'],$query['data'],$query['dzien_id_godzina_pocz'],$query['dzien_id_godzina_kon']);
		$params['dzien']=$dzien;

		$godziny_wszystkie=$this->godzinaModel->get_all_godzina_better();
		$params['godziny_wszystkie'] = $godziny_wszystkie;
		//var_dump($godziny_wszystkie);
		
		
		$godziny_pracy = $this->godzinaModel->get_godziny_pracy_better($dzien->getDzien_id_godzina_pocz(),$dzien->getDzien_id_godzina_kon());
		$params['godziny_pracy'] = $godziny_pracy;
		
		$wizyty_zarejestrowani = $this->wizytaModel->get_all_by_day_zarejestrowani($id_dzien);
		//var_dump($wizyty_zarejestrowani);
		$params['wizyty_zarejestrowani'] = $wizyty_zarejestrowani;
		
		$uzytkownicy = array();
		foreach($wizyty_zarejestrowani as $row=>$id){
			array_push($uzytkownicy, $this->uzytkownikModel->get_user_by_id($id['wizyta_id_uzytkownik']));		
		}
		$params['uzytkownicy'] = $uzytkownicy;
		
		$wizyty_niezarejestrowani = $this->wizytaModel->get_all_by_day_niezarejestrowani($id_dzien);
		//var_dump($wizyty_niezarejestrowani);
		$params['wizyty_niezarejestrowani'] = $wizyty_niezarejestrowani;
		
		$opis_niezarejestrowani = array();
		foreach($wizyty_niezarejestrowani as $row=>$id){
			$opis = $this->wiadomoscModel->get_opis_niezarejestrowany($id['id_wizyta']);
			array_push($opis_niezarejestrowani,$opis);		
		}
		//var_dump($opis_niezarejestrowani);
		$params['opis_niezarejestrowani'] = $opis_niezarejestrowani;
		
		$wizyty_wszystkie = array_merge($wizyty_zarejestrowani,$wizyty_niezarejestrowani);
		$this->array_sort_by_column($wizyty_wszystkie, 'wizyta_id_godzina');
		//var_dump($wizyty_wszystkie);
		$params['wizyty_wszystkie'] = $wizyty_wszystkie;
		
		$params['article'] = 'Dzien/showDetails';
		$this->load->view('template',$params);
		
	}
	
	public function showCal($year, $month) {
		
		
		
		$prefs = array(
			'start_day'    => 'monday',
			'month_type'   => 'long',
			'day_type'     => 'short',
			'show_next_prev' => true,
			'next_prev_url'   => base_url('kalendarz')
		);
		$prefs['template'] = '
			{cal_cell_content}<span class="day_listing">{day}</span>&nbsp; {content}&nbsp;{/cal_cell_content}
			{cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>&bull; {content}</div>{/cal_cell_content_today}
			{cal_cell_no_content}<span class="day_listing" id="dodaj">{day}</span>&nbsp;{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
		'; 
		
		$days = array();
		$this->lista_dni = array();
		
		
		$days_query = $this->dzienModel->get_days_by_month_year($year,$month);
		$data['godziny_pracy'] = array();
		if(!empty($days_query)){ //dodanie dni wizyt do kalendarza
			foreach($days_query as $row){
				//array_push($this->lista_dni,$this->newObj($row['id_dzien'],$row['data'],$row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']));
				$tmp = strtok($row['data'],'-');
				$tmp = strtok("-");
				$tmp = strtok("-");
				if((int)$tmp < 10){
					$tmp = $tmp[1];
				}
				//******
					$godziny_wszystkie=$this->godzinaModel->get_all_godzina_better();
					//var_dump($godziny_wszystkie);
					
					
					$wizyty_zarejestrowani = $this->wizytaModel->get_all_by_day_zarejestrowani($row['id_dzien']);
					//var_dump($wizyty_zarejestrowani);
					
					$uzytkownicy = array();
					foreach($wizyty_zarejestrowani as $row1=>$id){
						array_push($uzytkownicy, $this->uzytkownikModel->get_user_by_id($id['wizyta_id_uzytkownik']));		
					}
					$params['uzytkownicy'] = $uzytkownicy;
					
					$wizyty_niezarejestrowani = $this->wizytaModel->get_all_by_day_niezarejestrowani($row['id_dzien']);
					//var_dump($wizyty_niezarejestrowani);
					
					$opis_niezarejestrowani = array();
					foreach($wizyty_niezarejestrowani as $row2=>$id){
						$opis = $this->wiadomoscModel->get_opis_niezarejestrowany($id['id_wizyta']);
						array_push($opis_niezarejestrowani,$opis);		
					}
					//var_dump($opis_niezarejestrowani);
					
					$wizyty_wszystkie = array_merge($wizyty_zarejestrowani,$wizyty_niezarejestrowani);
					$this->array_sort_by_column($wizyty_wszystkie, 'wizyta_id_godzina');
					//var_dump($wizyty_wszystkie);			
					
					$opis = array();
					$niez = 0;
					$zar = 0;
					for($i=0; $i<count($wizyty_wszystkie); $i++){
						if($wizyty_wszystkie[$i]['wizyta_id_uzytkownik']=="0"){
							array_push($opis,array(
							'opis'=>$opis_niezarejestrowani[$niez]['tekst'], 
							"id"=>$wizyty_wszystkie[$i]['wizyta_id_uzytkownik'],
							'godzina'=>$godziny_wszystkie[$wizyty_wszystkie[$i]['wizyta_id_godzina']]['godzina']));
							$niez++;
						}else{
							array_push($opis,array(
							'opis'=>$uzytkownicy[$zar]['imie'].' '.$uzytkownicy[$zar]['nazwisko'], 
							"id"=>$wizyty_wszystkie[$i]['wizyta_id_uzytkownik'],
							'godzina'=>$godziny_wszystkie[$wizyty_wszystkie[$i]['wizyta_id_godzina']]['godzina']));
							$zar++;
						}
					}
					//var_dump($opis);
				//******
				
				
				$godziny_pracy = $this->godzinaModel->get_godziny_pracy($row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']);
				$days[$tmp]='<br/>
				<div id="zawartosc" style="min-width:120px; max-width:200px; height:30%; "><div class="godziny" style="margin:0 auto">
					
					<div class="link">
					<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
					<ul style="padding-left:10px;">';
					for($i=0; $i<count($wizyty_wszystkie); $i++){
						if($opis[$i]['id']=="0"){
							$days[$tmp].= '<li>'.$opis[$i]['godzina'].'<br>'.nl2br($opis[$i]['opis']).'</li>';
						}else {
							$days[$tmp].= '<li>'.$opis[$i]['godzina'].'<br><a href="'.base_url('uzytkownik/'.$opis[$i]['id']).'">'.$opis[$i]['opis'].'</a></li>';
						}
					}
					
					$days[$tmp].='
					</ul>';
					if(count($wizyty_wszystkie)==0){
						$days[$tmp].='<p>Brak wizyt</p>';
					}
					
					$days[$tmp].='	<a class="btn btn-primary" href='.base_url('szczegolyDnia/'.$row['id_dzien']).'>szczegóły</a>
					</div>
				</div>';
				
			}

			$this->load->library('calendar', $prefs);
			
			//wypełnienie reszty dni przyciskiem dodaj
			for($i=1;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				if(empty($days[$i])){
					if($i<10){
						$data_dnia = $year.'-'.$month.'-0'.$i;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$i;
					}				
					if($data_dnia>date("Y-m-d")){
						$days[$i] = '<br/>
						<a href="#dodaj">
						<div class="dodajPrzycisk" id="">
							<i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i>
							<h class="btn btn-default" style="width:90px">dodaj</h>
						</div>
						</a>
						<br/>
						<div class="dodaj'.$i.'" style="display:none">
							<h>Dodaj dzień<h>
							<form method="POST" action="../../dzienControler/insert_form" id="form_dodaj">
								<label for="godzina_roz">Godzina rozpoczęcia:</label>
								<select name="dodaj_godzina_roz" id="dodaj_godzina_roz">
									<?php foreach($godziny as $row): ?>					
										<option value="<?php echo $row["id_godzina"]; ?>"><?php echo substr($row["godzina"],0,5); ?></option>			
									<?php endforeach; ?>
								</select>
								<label for="godzina_zak">Godzina zakończenia:</label>
								<select name="dodaj_godzina_zak" id="dodaj_godzina_zak">
									<?php foreach($godziny as $row): ?>					
										<option value="<?php echo $row["id_godzina"]; ?>"><?php echo substr($row["godzina"],0,5); ?></option>			
									<?php endforeach; ?>
								</select>
								<input readonly="readonly" id="data_dodanie" name="data1"></input>
								<button type="submit" name="submit_dodaj" id="submit_dodaj">Dodaj</button>
							</form>
						</div>';
					}
				}
			}
			
		}else{ // wypełnienie dodaj całego kalendarza jeśli nie ma wizyt
			$this->load->library('calendar', $prefs);
			for($i=0;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				$data_dnia = $year.'-'.$month.'-'.$i;
				if($data_dnia>date("Y-m-d")){
					$days[$i] = '<br/>
					<a href="#dodaj">
					<div class="dodaj" id="d" >
						<i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i>
						<h class="btn btn-default" style="width:80%; margin-left:0 auto;">dodaj</h>
					</div>
					</a>';	
				}
			}
		
		
		}
		$data = $this->godzinaModel->get_all_godzina();
	
		$data['calendar'] = $this->calendar->generate($year, $month,$days);
		$data['article'] = 'my_calendar';
		$this->load->view('template',$data);
		 
	}
	
	public function ustalZarejestrowany($id_user,$year,$month){
		$prefs = array(
			'start_day'    => 'monday',
			'month_type'   => 'long',
			'day_type'     => 'short',
			'show_next_prev' => true,
			'next_prev_url'   => base_url('dzienControler/ustalZarejestrowany/'.$id_user.'/')
		);
		$prefs['template'] = '
			{cal_cell_content}<span class="day_listing">{day}</span>&nbsp; {content}&nbsp;{/cal_cell_content}
			{cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>&bull; {content}</div>{/cal_cell_content_today}
			{cal_cell_no_content}<span class="day_listing" id="dodaj">{day}</span>&nbsp;{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
		'; 
		
		$uzytkownik = $this->uzytkownikModel->get_user_by_id($id_user);
		if(empty($uzytkownik)){
			redirect(base_url('strona_404'),'refresh');
		}

		$wizyta['pierwsza'] = '0';
		
		$days = array();
		$this->lista_dni = array();
		
		$days_query = $this->dzienModel->get_days_by_month_year($year,$month);
		
		$wolne_godziny=array(); //wolne godziny w dniu ktory jest dodany
		if(!empty($days_query)){ //dodanie dni wizyt do kalendarza
		//var_dump($days_query);
			foreach($days_query as $row){
				//array_push($this->lista_dni,$this->newObj($row['id_dzien'],$row['data'],$row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']));
				$tmp = strtok($row['data'],'-');
				$tmp = strtok("-");
				$tmp = strtok("-");
				if((int)$tmp < 10){
					$tmp = $tmp[1];
				}
				$godziny_pracy = $this->godzinaModel->get_godziny_pracy($row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']);
				
				$wolne_godziny[$row['id_dzien']]=$this->wolne_godziny($row['id_dzien'],$wizyta);
				//var_dump($wolne_godziny[$row['id_dzien']]);
				
				if(!empty($wolne_godziny[$row['id_dzien']])){
					if($year.'-'.$month.'-'.$tmp<date("Y-m-d")){
						$days[$tmp]='<br/>
						<div id="zawartosc"><div class="godziny">
						<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
						<div class="dodaj" id="d">
							<i id="dzien'.$tmp.'" style="display:none">'.$year.'-'.$month.'-'.$tmp.'</i>
						</div></div>';	
					}else{
						if($tmp<10){
						$data_dnia = $year.'-'.$month.'-0'.$tmp;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$tmp;
					}				
					if($data_dnia>date("Y-m-d")){
						$days[$tmp]='<br/>
						<div id="zawartosc"><div class="godziny">
						<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
						<div class="dodaj" id="d">
							<i id="dzien'.$tmp.'" style="display:none">'.$year.'-'.$month.'-'.$tmp.'</i>
							<h class="btn btn-default" style="width:90px">wybierz</h>
						</div></div>';	
					}
					}
				} else{
					$days[$tmp]='
					<br/>
					<div id="zawartosc"><div class="godziny">
						<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
					<br/></div>';
				}		
				
				$godziny_do_wyboru[$tmp] = array();
				foreach($wolne_godziny[$row['id_dzien']] as $row => $item){
					array_push($godziny_do_wyboru[$tmp],$item);
				}			
			}
			
			$this->load->library('calendar', $prefs);
			$wszystkie_godziny = array();
			//wypełnienie reszty dni przyciskiem wybierz
			$tmp = $this->godzinaModel->get_all_godzina_better();
			for($i=0;$i<count($tmp)-1;$i++){
					array_push($wszystkie_godziny,$tmp[$i]);
			}
			for($i=1;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				if(empty($days[$i])){
					
					$godziny_do_wyboru[$i] = array();
					foreach ($wszystkie_godziny as $row => $item)
						array_push($godziny_do_wyboru[$i],$item);
					
					if($i<10){
						$data_dnia = $year.'-'.$month.'-0'.$i;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$i;
					}				
					if($data_dnia>date("Y-m-d")){
						$days[$i] = '<br/>
						<div class="dodaj" id="d">
							<i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i>
							<h class="btn btn-default" style="width:90px">wybierz</h>
						</div>';
					}
				}
			}
			//var_dump($godziny_do_wyboru);
			
		}else{ // wypełnienie dodaj całego kalendarza jeśli nie ma wizyt
		
			$wszystkie_godziny = array();
			$tmp = $this->godzinaModel->get_all_godzina_better();
			for($i=0;$i<count($tmp)-1;$i++){
					array_push($wszystkie_godziny,$tmp[$i]);
			}
			
			$this->load->library('calendar', $prefs);
			for($i=1;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				if(empty($days[$i])){
					
					$godziny_do_wyboru[$i] = array();
					foreach ($wszystkie_godziny as $row => $item)
						array_push($godziny_do_wyboru[$i],$item);
					
					if($i<10){
						$data_dnia = $year.'-'.$month.'-0'.$i;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$i;
					}				
					
					if($data_dnia>date("Y-m-d")){
						$days[$i] = '<br/>
						<div class="dodaj" id="d">
							<i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i>
							<h class="btn btn-default" style="width:90px">wybierz</h>
						</div>';
					}
				}
			}
		
		
		}
		$data = $this->godzinaModel->get_all_godzina();
		$data['godziny_do_wyboru'] = $godziny_do_wyboru;
	
		//var_dump($godziny_do_wyboru);
	
		$data['calendar'] = $this->calendar->generate($year, $month,$days);
		$data['article'] = 'Dzien/ustalZarejestrowany';
		$this->load->view('template',$data);
	}
	
	public function przenies($id_wizyta,$year,$month){
		
		/*
		$godziny_do_wyboru - możliwy godziny na które można przenieść wizytę
		$wolne_godziny - wolne godziny w dniu ktory jest dodany
		$wszystkie_godziny - wszystkie możliwe godziny
		$data['godziny_pracy'] - godziny pracy w danym dniu
		*/
		
		$prefs = array(
			'start_day'    => 'monday',
			'month_type'   => 'long',
			'day_type'     => 'short',
			'show_next_prev' => true,
			'next_prev_url'   => base_url('przeniesWizyte/'.$id_wizyta.'/')
		);
		$prefs['template'] = '
			{cal_cell_content}<span class="day_listing">{day}</span>&nbsp; {content}&nbsp;{/cal_cell_content}
			{cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>&bull; {content}</div>{/cal_cell_content_today}
			{cal_cell_no_content}<span class="day_listing" id="dodaj">{day}</span>&nbsp;{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
		'; 
		
		$wizyta_przenoszona = $this->wizytaModel->get_wizyta_by_id($id_wizyta);
		if(empty($wizyta_przenoszona)){
			redirect(base_url('strona_404'),'refresh');
		}
		//var_dump($wizyta_przenoszona);
		
		$days = array();
		$this->lista_dni = array();
		
		$days_query = $this->dzienModel->get_days_by_month_year($year,$month);
		
		$wolne_godziny=array(); //wolne godziny w dniu ktory jest dodany
		if(!empty($days_query)){ //dodanie dni wizyt do kalendarza
		//var_dump($days_query);
			foreach($days_query as $row){
				//array_push($this->lista_dni,$this->newObj($row['id_dzien'],$row['data'],$row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']));
				$tmp = strtok($row['data'],'-');
				$tmp = strtok("-");
				$tmp = strtok("-");
				if((int)$tmp < 10){
					$tmp = $tmp[1];
				}
				$godziny_pracy = $this->godzinaModel->get_godziny_pracy($row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']);
				
				$wolne_godziny[$row['id_dzien']]=$this->wolne_godziny($row['id_dzien'],$wizyta_przenoszona);
				//var_dump($wolne_godziny[$row['id_dzien']]);
				
				if(!empty($wolne_godziny[$row['id_dzien']])){
					if($year.'-'.$month.'-'.$tmp<date("Y-m-d")){
						$days[$tmp]='<br/>
						<div id="zawartosc"><div class="godziny">
						<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
						<div class="dodaj" id="d">
							<i id="dzien'.$tmp.'" style="display:none">'.$year.'-'.$month.'-'.$tmp.'</i>
						</div></div>';	
					}else{
						if($tmp<10){
						$data_dnia = $year.'-'.$month.'-0'.$tmp;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$tmp;
					}				
					if($data_dnia>date("Y-m-d")){
						$days[$tmp]='<br/>
						<div id="zawartosc"><div class="godziny">
						<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
						<div class="dodaj" id="d">
							<i id="dzien'.$tmp.'" style="display:none">'.$year.'-'.$month.'-'.$tmp.'</i>
							<h class="btn btn-default" style="width:90px">wybierz</h>
						</div></div>';	
					}
					}
				} else{
					$days[$tmp]='
					<br/>
					<div id="zawartosc"><div class="godziny">
						<p>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5).'</p>
					<br/></div>';
				}		
				
				$godziny_do_wyboru[$tmp] = array();
				foreach($wolne_godziny[$row['id_dzien']] as $row => $item){
					array_push($godziny_do_wyboru[$tmp],$item);
				}			
			}
			
			$this->load->library('calendar', $prefs);
			$wszystkie_godziny = array();
			//wypełnienie reszty dni przyciskiem wybierz
			$tmp = $this->godzinaModel->get_all_godzina_better();
			for($i=0;$i<count($tmp)-1;$i++){
				if($wizyta_przenoszona['pierwsza']=='1' && $i<count($tmp)-2)
					array_push($wszystkie_godziny,$tmp[$i]);
				else if($wizyta_przenoszona['pierwsza']=='0')
					array_push($wszystkie_godziny,$tmp[$i]);
			}
			for($i=1;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				if(empty($days[$i])){
					
					$godziny_do_wyboru[$i] = array();
					foreach ($wszystkie_godziny as $row => $item)
						array_push($godziny_do_wyboru[$i],$item);
					
					if($i<10){
						$data_dnia = $year.'-'.$month.'-0'.$i;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$i;
					}				
					if($data_dnia>date("Y-m-d")){
						$days[$i] = '<br/>
						<div class="dodaj" id="d">
							<i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i>
							<h class="btn btn-default" style="width:90px">wybierz</h>
						</div>';
					}
				}
			}
			//var_dump($godziny_do_wyboru);
			
		}else{ // wypełnienie dodaj całego kalendarza jeśli nie ma wizyt
		
			$wszystkie_godziny = array();
			$tmp = $this->godzinaModel->get_all_godzina_better();
			for($i=0;$i<count($tmp)-1;$i++){
				if($wizyta_przenoszona['pierwsza']=='1' && $i<count($tmp)-2)
					array_push($wszystkie_godziny,$tmp[$i]);
				else if($wizyta_przenoszona['pierwsza']=='0')
					array_push($wszystkie_godziny,$tmp[$i]);
			}
			
			$this->load->library('calendar', $prefs);
			for($i=1;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				if(empty($days[$i])){
					
					$godziny_do_wyboru[$i] = array();
					foreach ($wszystkie_godziny as $row => $item)
						array_push($godziny_do_wyboru[$i],$item);
					
					if($i<10){
						$data_dnia = $year.'-'.$month.'-0'.$i;
					}else{
						$data_dnia = $year.'-'.$month.'-'.$i;
					}				
					if($data_dnia>date("Y-m-d")){
						$days[$i] = '<br/>
						<div class="dodaj" id="d">
							<i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i>
							<h class="btn btn-default" style="width:90px">wybierz</h>
						</div>';
					}
				}
			}
		
		
		}
		$data = $this->godzinaModel->get_all_godzina();
		$data['godziny_do_wyboru'] = $godziny_do_wyboru;
	
		//var_dump($godziny_do_wyboru);
	
		$data['calendar'] = $this->calendar->generate($year, $month,$days);
		$data['article'] = 'Dzien/przenies';
		$this->load->view('template',$data);
		 
		
	}
	
	private function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}

	private function wolne_godziny ($id_dzien, $wizyta_przenoszona){
		//zwraca wolne godziny wg dnia
		
		
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
				if($wizyta_przenoszona['pierwsza']=='1' && 	!empty($iterator[$i+1]) && empty($iterator[$i+1]['id_wizyta']) && $iterator[$i+1]['id_godzina']<$dzien['dzien_id_godzina_kon']){
					array_push($wolne_godziny, $iterator[$i]);
					$tmp=0;
				}else if($wizyta_przenoszona['pierwsza']=='0'){
					array_push($wolne_godziny, $iterator[$i]);
					$tmp=0;
				}
			}else {
				$tmp=0;
			}
			
		}
		return $wolne_godziny;
	}
}






