<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this ->load->model(array('get_model'));
	}


	public function index()
	{
		$id_dzien=NULL;
		$data = NULL;
		$godz_roz= NULL;
		$godz_zak= NULL;
		
		extract($_POST);
		
		$params['id_dzien'] = '5';
		$params['data'] = date('y-m-d');
		$params['dzien_id_godzina_pocz'] = $godz_roz;
		$params['dzien_id_godzina_kon'] = $godz_zak;
		if(isset($submit))
		{
			$this->get_model->update($params);
		}
		
		$this->load->view('get');
	}
	
	public function get_all(){
		
		$result = $this->get_model->get_all();
		
		foreach($result->result() as $row){
			echo $row->data;
		}

		$this->load->view('get');
	}
}
