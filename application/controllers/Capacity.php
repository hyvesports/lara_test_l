<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capacity extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('order_model', 'order_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('calendar_model', 'calendar_model');
		
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	
	
	public function load_capacity(){
		$this->load->view('capacity/load_capacity',$data);
	}
	public function index(){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		//print_r($accessArray);
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("checking",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']=$accessArray['module_parent']." | Online";
		$data['title_head']=$accessArray['menu_name'];
		$data['punits']= $this->schedule_model->get_my_business_unit('');
		$data['view']='capacity/checking';
		$this->load->view('layout',$data);
		
	}


}
