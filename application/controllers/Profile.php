<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('settings_model', 'settings_model');
		
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}

	public function index(){
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']="Pofile | My account";
		$data['title_head']=$moduleData['menu_name'];
		
		//$data['results']=$results;
		$data['view']='profile/index';
		$this->load->view('layout',$data);
	}

}
