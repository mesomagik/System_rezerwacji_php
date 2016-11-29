<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {


	public function index()
	{
		$this->load->view('template');
		
		
		$this->load->library('template_lib');
		$this->template_lib->show('views','get');
	}
}
