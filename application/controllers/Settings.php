<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('settings_model', 'settings_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	public function save_wh(){
		//print_r($_POST);
		$system_master_id=$this->input->post('system_master_id');
		$working_hrs=$this->input->post('working_hrs');
		$working_min=$this->input->post('working_min');
		
		$hr_to_seconds=$working_hrs*3600;
		$min_to_seconds=$working_min*60;
		$total_seconds=$hr_to_seconds+$min_to_seconds;
		$up="UPDATE system_master SET calculation_value='$total_seconds',wh_hrs='$working_hrs',wh_min='$working_min' WHERE system_master_id='$system_master_id' ";
		$query = $this->db->query($up);
		$responseMsg='<div class="alert alert-success" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>System working time updated successfully</div>';
		echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
		exit;
	}

	public function index(){
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']="System | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		$row = $this->settings_model->get_system_working_hours();
		//print_r($row);
		$data['row']=$row;
		$data['view']='settings/index';
		$this->load->view('layout',$data);
	}

}
