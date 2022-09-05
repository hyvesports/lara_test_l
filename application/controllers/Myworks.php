<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myworks extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myworks_model', 'myworks_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		
		
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	
	
	public function design_orders_rejected(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->myworks_model->get_design_works_rejected($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			
			$itemArray = json_decode($row['submitted_item']);
			if($itemArray) {
				foreach($itemArray as  $value1){
					if($value1->summary_id==$row['summary_item_id']){
						$itemRefNo=$value1->online_ref_number;
						$itemDetails=$value1->product_type;
					}
				}
			}
			
			
			
			$option='<td style="text-align:center;">';
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			
			//$op='badge badge-outline-danger';
			$status='<td><span class="badge badge-outline-danger" >Rejected By: '.$row['rejected_department'].'<br>'.$row['verify_datetime'].'</span></td>';
			
			$data[]= array(
				$row['orderform_number'],
				$itemRefNo,
				$itemDetails,
				$option1,
				$status,
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function design_orders_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->myworks_model->get_design_works_pending($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$option='<td style="text-align:center;">';
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			
			$data[]= array(
				$row['orderform_number'],
				date("d-m-Y", strtotime($row['department_schedule_date'])),
				$row['wo_product_info'],
				$option1,
				$row['production_unit_name'],
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function design_orders(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->myworks_model->get_design_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$option='<td style="text-align:center;">';
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			$wo_product_info='<td>'.$row['wo_product_info'].'</td>';
			
			$order_count=$temCount-$row['APP_COUNT'];
			$status='<td>';
			if($order_count==0){
			$status.='<span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>QC Approved ('.$temCount.')</strong></span>';
			}else{
				$status.='<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>QC Not approved ('.$order_count.')</strong></span>';
			}
			
			if($row['is_rejected']!=""){
				$status.='&nbsp;<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Rejected</strong></span>';
			}
			
			if($row['is_re_scheduled']!=0){
				$status.='&nbsp;<span class="badge badge-outline-warning" ><strong>Re-Scheduled</strong></span>';
			}
			
			$status.='<td>';
			
			$data[]= array(
				$row['orderform_number'],
				date("d-m-Y", strtotime($row['department_schedule_date'])),
				$wo_product_info,
				$option1,
				$row['production_unit_name'],
				$status,
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
}
 