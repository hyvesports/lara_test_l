<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Task extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('task_model', 'task_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	//
	public function list_previous(){
		$loginid=$this->session->userdata('loginid');
		$records = $this->task_model->get_my_previous_tasks($loginid);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$ld='<td><a href="'.base_url('leads/view/'.$row['lead_uuid']).'" style="cursor: pointer;" target="_blank"><label class="badge badge-warning" style="cursor: pointer;"> '.$row['lead_code'].'</label></a>';
			$cus='<div class="d-flex align-items-center"><div class=""><p class="mb-2">'.$row['customer_name'].'</p><p class="mb-0 text-muted text-small">'.$row['customer_mobile_no'].'<br/>'.$row['customer_email'].'</p></div></div>';
			$tm='<td><small class="text-muted ml-4"><em>'.date("d-m-Y",strtotime($row['reminder_date'])).','.$row['reminder_time'].'</em></small></td>';
			$data[]= array(
				$row['task_desc'],
				$ld,
				$cus,
				$tm,
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function list_next(){
		$loginid=$this->session->userdata('loginid');
		$records = $this->task_model->get_my_next_tasks($loginid);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$ld='<td><a href="'.base_url('leads/view/'.$row['lead_uuid']).'" style="cursor: pointer;" target="_blank"><label class="badge badge-warning" style="cursor: pointer;"> '.$row['lead_code'].'</label></a>';
			$cus='<div class="d-flex align-items-center"><div class=""><p class="mb-2">'.$row['customer_name'].'</p><p class="mb-0 text-muted text-small">'.$row['customer_mobile_no'].'<br/>'.$row['customer_email'].'</p></div></div>';
			$tm='<td><small class="text-muted ml-4"><em>'.date("d-m-Y",strtotime($row['reminder_date'])).','.$row['reminder_time'].'</em></small></td>';
			$data[]= array(
				$row['task_desc'],
				$ld,
				$cus,
				$tm,
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function list_today(){
		$loginid=$this->session->userdata('loginid');
		$records = $this->task_model->get_my_today_tasks($loginid);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$ld='<td><a href="'.base_url('leads/view/'.$row['lead_uuid']).'" style="cursor: pointer;" target="_blank"><label class="badge badge-warning" style="cursor: pointer;"> '.$row['lead_code'].'</label></a>';
			$cus='<div class="d-flex align-items-center"><div class=""><p class="mb-2">'.$row['customer_name'].'</p><p class="mb-0 text-muted text-small">'.$row['customer_mobile_no'].'<br/>'.$row['customer_email'].'</p></div></div>';
			$tm='<td><small class="text-muted ml-4"><em>'.date("d-m-Y",strtotime($row['reminder_date'])).','.$row['reminder_time'].'</em></small></td>';
			$data[]= array(
				$row['task_desc'],
				$ld,
				$cus,
				$tm,
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function list_all(){
		$loginid=$this->session->userdata('loginid');
		$records = $this->task_model->get_my_all_tasks($loginid);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$task_id=$row['task_id'];
		
			if($row['customer_info']==""){
				$cinfo=$row['lead_code'];
				$cinfo.=",".$row['customer_name'];
				$cinfo.=",".$row['customer_mobile_no'];
				$cinfo.=",".$row['customer_email'];
				$up="UPDATE tasks SET customer_info='$cinfo' WHERE task_id='$task_id' ";
				$query=$this->db->query($up);	
			}
			
			$ld='<td><a href="'.base_url('leads/view/'.$row['lead_uuid']).'" style="cursor: pointer;" target="_blank"><label class="badge badge-warning" style="cursor: pointer;"> '.$row['lead_code'].'</label></a>';
			$cus='<div class="d-flex align-items-center"><div class=""><p class="mb-2">'.$row['customer_name'].'</p><p class="mb-0 text-muted text-small">'.$row['customer_mobile_no'].'<br/>'.$row['customer_email'].'</p></div></div>';
			$tm='<td><small class="text-muted ml-4"><em>'.date("d-m-Y",strtotime($row['reminder_date'])).','.$row['reminder_time'].'</em></small></td>';
			$data[]= array(
				$row['task_desc'],
				$ld,
				$cus,
				$tm,
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function index(){
		$accessArray=$this->rbac->check_operation_access_my_account('leads'); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("task",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']="Tasks";
		$data['title_head']=$accessArray['menu_name'];
		$data['view']='task/index';
		$this->load->view('layout',$data);
	}
	public function today(){
		$accessArray=$this->rbac->check_operation_access_my_account('leads'); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("task",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']="Tasks";
		$data['title_head']=$accessArray['menu_name'];
		$data['view']='task/today';
		$this->load->view('layout',$data);
	}
	
	public function nextday(){
		$accessArray=$this->rbac->check_operation_access_my_account('leads'); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("task",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']="Tasks";
		$data['title_head']=$accessArray['menu_name'];
		$data['view']='task/nextday';
		$this->load->view('layout',$data);
	}
	public function previousday(){
		$accessArray=$this->rbac->check_operation_access_my_account('leads'); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("task",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']="Tasks";
		$data['title_head']=$accessArray['menu_name'];
		$data['view']='task/previousday';
		$this->load->view('layout',$data);
	}
	
	
	
	
	//________________________________________________________________________________________________________________________________________



}

