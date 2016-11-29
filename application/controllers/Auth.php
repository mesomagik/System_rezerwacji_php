<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	public function __constuct()
	{
		parent::__constuct();
		
		//$this->load->library('session');
		$this->load->model(array('uzytkownikModel'));
	}

	public function login()
	{
		
		extract($_POST);
		var_dump($_POST);
		
		$admin = $this->uzytkownikModel->get_user_by_id('1');
		if($admin['email'] == $_POST['email'] && $admin['haslo'] == $_POST['haslo']){
			$_SESSION['admin']==true;
			redirect(base_url('home/index'));
		}
	}
	
	public function logout(){
		session_destroy();
		redirect(base_url('home/index'));
	}
	
	
}
