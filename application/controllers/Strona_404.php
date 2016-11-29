<?php 
class strona_404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
		if (!isset($_SESSION)){
			session_start();
		}
    } 

    public function index() 
    { 
        $this->output->set_status_header('404'); 
        $data['article'] = 'widok_404'; 
        $this->load->view('template',$data);
    } 
} 
?> 