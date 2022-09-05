<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Access extends CI_Controller {
	
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	//----------------------------------------------------------------------------------
	public function not_found(){
		$this->load->view('not_found');
	}
	public function access_denied(){
		$this->load->view('access_denied');
	}
	//----------------------------------------------------------------------------------
	
}
