<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('order_model', 'order_model');
		$this->load->model('accounts_model', 'accounts_model');
		$this->load->model('schedule_model', 'schedule_model');
		
		$this->load->model('calendar_model', 'calendar_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}

	
	public function calculate_date_diff(){
		//echo $_POST['for'];
		if($_POST['for']=="online"){
			$systemRow=$this->schedule_model->get_system_production_days('ONPD');
			$dayLimit=$systemRow['calculation_value'];
		}else{
			$systemRow=$this->schedule_model->get_system_production_days('OFPD');
			$dayLimit=$systemRow['calculation_value'];
		}
			//print_r($systemRow);
			
			$fd=$_POST['fd'];
			$from_date=date('Y-m-d');
			$td=$_POST['td'];
			$to_date=date('Y-m-d', strtotime($td));
			//echo $from_date."=".$to_date;
			$earlier = new DateTime($from_date);
			$later = new DateTime($to_date);
			$abs_diff = $later->diff($earlier)->format("%a"); //3
			
			if($abs_diff<$dayLimit){
				echo '<span class="badge badge-danger mt-2 w-100" >Dispatch date less than '.$dayLimit.'</span>';
			}else{
				echo '<span class="badge badge-success mt-2 w-100" >Dispatch date greater than '.$dayLimit.'</span>';
			}
		
	}
	
}
