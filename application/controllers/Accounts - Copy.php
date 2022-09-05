<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {
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
	
	//
	
	public function save_updates(){
	
		if($this->input->post('submit')){
			$rs_design_id=$this->input->post('rdid');
			$accounts_remark=addslashes($this->input->post('accounts_remark'));
			$accounts_status=$this->input->post('afor');
			date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
			$accounts_verified_datetime = date('d-m-Y H:i:s');
			$accounts_verified_by=$this->session->userdata('loginid');
			$sql="UPDATE
				rs_design_departments 
			SET 
				accounts_remark='$accounts_remark',
				accounts_status='$accounts_status',
				accounts_verified_by='$accounts_verified_by',
				accounts_verified_datetime='$accounts_verified_datetime'
			WHERE
				rs_design_id='$rs_design_id' ";
			$query = $this->db->query($sql);
			$this->session->set_flashdata('success','Successfull updated the order status.');	
		}
	}
	
	public function approve_denay(){
		//rdid
		$data['schedule_data']=$this->accounts_model->get_final_qc_data_for_accounts($_POST['rdid']);
		$this->load->view('accounts/approve_denay',$data);
	}
	public function view($uuid,$rdid){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
			if($accessArray==""){
				redirect('access/not_found');
			}
			if($accessArray==""){
				redirect('access/not_found');
			}else{
				if($accessArray){if(!in_array("view",$accessArray)){
				redirect('access/access_denied');
				}}
			}
			
			$data['title']=$accessArray['module_parent']." |  Order View";
		$data['title_head']=$accessArray['menu_name'];
		$data['row']=$this->accounts_model->get_scheduled_data_by_uuid($uuid);
		$data['rowResponse']=$this->accounts_model->get_final_qc_data_for_accounts($rdid);
		$data['view']='accounts/view';
		$this->load->view('layout',$data);
	}
	public function orders_list(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->auth_model->get_staff_profile_data($loginid);
		if($this->session->userdata('role_id')=="1"){ // is admin
			$unit_managed="admin";
		}else{
			$unit_managed=$staffRow['unit_managed'];
		}
		$records = $this->accounts_model->get_all_completed_work_orders($unit_managed);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$wo_ref_numbers="";
			if($row['wo_ref_numbers']!=""){
				//$wo_ref_numbers="<br/>Ref: No: ".$row['wo_ref_numbers'];
			}
			$dispatchDates= $this->accounts_model->final_dispatch_dates($row['schedule_id'],8);
			$option='<td style="text-align:center;">';
			if($accessArray){if(in_array("approve_deny",$accessArray)){
				
				if($row['accounts_status']==0){
				$option.='&nbsp;<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-sid="'.$row['schedule_id'].'" data-smid="'.$row['summary_item_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>';
				
				//$option.='&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-sid="'.$row['schedule_id'].'"  data-smid="'.$row['summary_item_id'].'"  data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>';
				
				
				}else if($row['accounts_status']==1){
					$option.='<label class="badge badge-success" style="cursor: pointer;">Approved <i class="fa fa-thumbs-up" ></i></label>';
				}else{
					$option.='<label class="badge badge-danger" style="cursor: pointer;">Rejected <i class="fa fa-thumbs-down" ></i></label>';
				}
				
			}}
			
			if($accessArray){if(in_array("view",$accessArray)){
				$option.='&nbsp;<a href="'.base_url('accounts/view/'.$row['schedule_uuid'],'').'/'.$row['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			}}
			$option.='</td>'; 
			$status="<td>";
			$status.='<span class="badge badge-outline-success" >Submitted On :'.$row['verify_datetime'].'<br> By:'.$row['submitted_person'].'</br>'.$row['staff_role'].'</span>';
			$status.="</td>";
			$data[]= array(
					$row['orderform_number'].$wo_ref_numbers,
					date("d-m-Y", strtotime($row['schedule_c_date'])),
					//$row['schedule_c_date'],
					$row['production_unit_name'],
					date("d-m-Y", strtotime($row['schedule_date'])),
					//$dispatchDates['dates'],
					date("d-m-Y", strtotime($dispatchDates['dates'])),
					$status,
					//$row['schedule_end_date'],
					$option
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function index(){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		$data['view']='accounts/index';
		$this->load->view('layout',$data);
	}
	
	//________________________________________________________________________________________________________________________________________

}
