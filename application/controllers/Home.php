<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function __constuct()
	{
		parent::__constuct();
		
		if (!isset($_SESSION)){
			session_start();
		}
	}

	public function index()
	{
		$this->load->model('StronaDomowaModel');
		
		$strona_info = $this->StronaDomowaModel->get_info();
		//var_dump($strona_info);
		
		$data['strona_info'] = $strona_info;
		$data['article'] = 'home';
		
		$this->load->view('template',$data);
	}
	
	public function edycjaStrony(){
		
		
		extract($_POST);
		//var_dump($_POST);
		
		$this->load->model('StronaDomowaModel');
		
		$strona_info = $this->StronaDomowaModel->get_info();
		//var_dump($strona_info);
		
		$data['strona_info'] = $strona_info;
		$data['article'] = 'edycjaDanych';
		
		$this->load->view('template',$data);	
		if(isset($input_button))
		{

			$this->StronaDomowaModel->update($_POST);
			redirect(base_url('/home/index'));
		};
			
	}
	


}
