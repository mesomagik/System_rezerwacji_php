<?php

class My_Calendar extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dzienModel');
		$this->load->model('godzinaModel');
		
	}
	
	public function index($year, $month){
		$this->showcal($year,$month);
		
	}
	
	public function showCal($year, $month) {
		
		
		
		$prefs = array(
			'start_day'    => 'monday',
			'month_type'   => 'long',
			'day_type'     => 'short',
			'show_next_prev' => true,
			'next_prev_url'   => base_url('my_calendar/showcal')
		);
		$prefs['template'] = '
			{cal_cell_content}<span class="day_listing">{day}</span>&nbsp; {content}&nbsp;{/cal_cell_content}
			{cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>&bull; {content}</div>{/cal_cell_content_today}
			{cal_cell_no_content}<span class="day_listing" id="dodaj">{day}</span>&nbsp;{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
		'; 
		
		$days = array();
		
		$days_query = $this->dzienModel->get_days_by_month_year($year,$month);
		if(!empty($days_query)){
			foreach($days_query as $row){
				$tmp = strtok($row['data'],'-');
				$tmp = strtok("-");
				$tmp = strtok("-");
				if((int)$tmp < 10){
					$tmp = $tmp[1];
				}
				$godziny_pracy = $this->godzinaModel->get_godziny_pracy($row['dzien_id_godzina_pocz'],$row['dzien_id_godzina_kon']);
				$days[$tmp]='<br/><a href='.base_url('wizytaControler/index/'.$row['id_dzien']).'>wizyty</a><br/>'.substr($godziny_pracy[0][0]['godzina'],0,5).' - '.substr($godziny_pracy[1][0]['godzina'],0,5);
			}

			$this->load->library('calendar',$prefs);
			
			for($i=0;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
				if(empty($days[$i])){
					$days[$i] = '<br/><div class="edytuj" id="d"><i id="dzien'.$i.'" style="display:none">'.$year.'-'.$month.'-'.$i.'</i><h style="width:90px">dodaj</h></div>';
				}
			}
		}else{
			$this->load->library('calendar', $prefs);
			for($i=0;$i<$this->calendar->get_total_days($month, $year)+1;$i++){
					
					$days[$i] = '<br/><a href='.base_url('dzienControler/insert/'.$year.'-'.$month.'-'.$i).' id="dodaj">Dodaj</a>';
			
			}
		
			
	
		}
		$id_dzien=NULL;
		$data1 = NULL;
		$godzina_roz= NULL;
		$godzina_zak= NULL;
		
		$dane['godzina']= array();

		$data = $this->godzinaModel->get_all_godzina();
		
		
		extract($_POST);
		
		$data['data'] = $data1;
		$data['dzien_id_godzina_pocz'] = $godzina_roz;
		$data['dzien_id_godzina_kon'] = $godzina_zak;
		if(isset($submit))
		{
			$this->dzienModel->insert($data);
		}
		
		$data['calendar'] = $this->calendar->generate($year, $month,$days);
		$data['article'] = 'my_calendar';
		
		$this->load->view('template',$data);
		 
	}
	
}
