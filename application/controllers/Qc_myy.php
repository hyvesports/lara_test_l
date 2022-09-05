<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qc extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	public function final_qc_save_status(){
	
		if($this->input->post('submit')){
			$rs_design_id=$this->input->post('rdid');
			$verify_remark=addslashes($this->input->post('Remark'));
			$verify_status=$this->input->post('afor');
			date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
			$verify_datetime = date('d-m-Y H:i:s');
			$rej_schedule_id=$this->input->post('rej_schedule_id');
			$rej_unit_id=$this->input->post('rej_unit_id');
			$rej_summary_item_id=$this->input->post('rej_summary_item_id');
			$reject_dep_id=$this->input->post('reject_dep_id');
			
			
			$approved_by=$this->session->userdata('loginid');
				
			if($verify_status==-1){ // qc rejected
				$sql="UPDATE
					rs_design_departments 
				SET 
					approved_dept_id='12',
					verify_status='$verify_status',
					verify_remark='$verify_remark',
					verify_datetime='$verify_datetime',
					rejected_department='final qc',
					rejected_by='$approved_by'
				WHERE
					rs_design_id='$rs_design_id' ";
				$query = $this->db->query($sql);
				if($reject_dep_id==4){
					
					$deptmts=$this->qc_model->get_all_department_for_rejection($rej_schedule_id,$rej_unit_id);
					if($deptmts){
						foreach($deptmts as $DP){
							$schedule_department_id=$DP['schedule_department_id'];
							$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`, `schedule_department_id`, `rs_design_id`, `rej_summary_item_id`) VALUES (NULL, '$schedule_department_id', '$rs_design_id', '$rej_summary_item_id');";
							$query = $this->db->query($ins);	
							
						}
					}
				}
				if($reject_dep_id==8){
					
					$sql="Select * from sh_schedule_departments where schedule_id='$rej_schedule_id' AND unit_id='$rej_unit_id' and FIND_IN_SET(8,sh_schedule_departments.department_ids)"; 
					//echo $sql;
					$query = $this->db->query($sql);					 
    				$rsRow=$query->row_array();
					$schedule_department_id=$rsRow['schedule_department_id'];
					$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`, `schedule_department_id`, `rs_design_id`, `rej_summary_item_id`) VALUES (NULL, '$schedule_department_id', '$rs_design_id', '$rej_summary_item_id');";
					$query = $this->db->query($ins);
				}
			}else{ //qc approved
								
				$sql="UPDATE
					rs_design_departments 
				SET 
					approved_dept_id='12',
					verify_status='$verify_status',
					verify_remark='$verify_remark',
					verify_datetime='$verify_datetime',
					approved_by='$approved_by',
					approved_dep_name='Final QC',
					submitted_to_accounts='1',
					accounts_status='0',
					accounts_verified_by='0'
				WHERE
					rs_design_id='$rs_design_id' ";
				$query = $this->db->query($sql);
			}
			$this->session->set_flashdata('success','Successfull updated the order status.');	
		}
	}
	
	public function order($uuid,$sdid,$rs_design_id){
		//echo $rs_design_id;
		$data['title']="Order Request | Order View";
		$data['title_head']="Order Request | Order View";
		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$data['staffRow']=$staffRow;
		
		if($staffRow['department_id']==13){
			$data['request_row']=$this->qc_model->get_design_request_row($rs_design_id);
			$data['view']='qc/order_view_final_qc_single';
			$this->load->view('layout',$data);
		}
		
	}
	
	public function final_qc_order_request(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->qc_model->get_design_works_reuested($staffRow['department_id'],$staffRow['unit_managed']);
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
			$option.='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;';
			$option.='<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
			
			$option.='<a href="'.base_url('qc/order/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/'.$row['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View</label></a>';
			$option.='</td>';
			
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			
			$data[]= array(
				$row['orderform_number'],
				$itemRefNo,
				$itemDetails,
				$option1,
				$row['response_remark'],
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function final_qc_list_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_final_qc_works_pending($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			if($order_count==0){
			$status='<td><span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Approved</strong></span></td>';
			}else{
				$status='<td><span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Not approved ('.$order_count.')</strong></span></td>';
			}
			
			$data[]= array(
				$row['orderform_number'],
				date("d-m-Y", strtotime($row['department_schedule_date'])),
				$wo_product_info,
				$option1,
				$row['production_unit_name'],
				
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function final_qc_list_active(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_final_qc_works($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			if($row['APP_COUNT']==0){
				$status.='<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Pending ('.$order_count.')</strong></span>';
			}else{
				if($order_count==0){
						$status.='&nbsp;<span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Approved ('.$temCount.')</strong></span>';
				}else{
					$status.='&nbsp;<span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Approved ('.$row['APP_COUNT'].')</strong></span>';
					$status.='&nbsp;<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Pending ('.$order_count.')</strong></span>';
			}
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
	
	public function list_design_qc_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_qc_works_pending($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			if($order_count==0){
			$status='<td><span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Approved</strong></span></td>';
			}else{
				$status='<td><span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Not approved ('.$order_count.')</strong></span></td>';
			}
			
			$data[]= array(
				$row['orderform_number'],
				date("d-m-Y", strtotime($row['department_schedule_date'])),
				$wo_product_info,
				$option1,
				$row['production_unit_name'],
				
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function save_status(){
		if($this->input->post('submit')){
			$rs_design_id=$this->input->post('rdid');
			$verify_remark=addslashes($this->input->post('Remark'));
			$verify_status=$this->input->post('afor');
			date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
			$verify_datetime = date('d-m-Y H:i:s');
			
			$loginid=$this->session->userdata('loginid');
			 if($verify_status==1){
				 $qc_name='design';
				 $rejected_department='';
				 $rejected_by='';
			 }else{
				  $qc_name='design';
				  $rejected_department='Design QC';
				  $rejected_by=$loginid;
			 }
			 $approved_by=$loginid;
			 
			$sql="UPDATE
				rs_design_departments 
			SET 
				approved_dept_id='11',
				verify_status='$verify_status',
				verify_remark='$verify_remark',
				verify_datetime='$verify_datetime',
				qc_name='$qc_name',
				approved_dep_name='design_qc',
				approved_by='$approved_by',
				rejected_department='$rejected_department',
				rejected_by='$rejected_by'				
			WHERE
				rs_design_id='$rs_design_id' ";
			
			$query = $this->db->query($sql);		
			$this->session->set_flashdata('success','Successfull updated the order status.');	
			
		}
	}
	
	public function final_qc_approve_denay(){
		$this->load->view('qc/final_qc_approve_denay');
	}
	public function approve_denay(){
		$this->load->view('qc/design_approval_or_deny');
	}
	
	
	public function order_view($uuid,$sdid,$rs_design_id){
		//echo $rs_design_id;
		$data['title']="Order Request | Order View";
		$data['title_head']="Order Request | Order View";
		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$data['staffRow']=$staffRow;
		
		if($staffRow['department_id']==11){
			$data['request_row']=$this->qc_model->get_design_request_row($rs_design_id);
			
			$data['view']='myaccount/order_view_design_qc_single';
			$this->load->view('layout',$data);
		}
		
	}
	
	//
	public function design_qc_request(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->qc_model->get_design_works_reuested($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			$option.='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;';
			
			$option.='<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
			
			
			
			$option.='<a href="'.base_url('qc/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/'.$row['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View</label></a>';
			
			
			
			$option.='</td>';
			
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			
			$data[]= array(
				$row['orderform_number'],
				$itemRefNo,
				$itemDetails,
				$option1,
				$row['response_remark'],
				$option
			);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	//
	public function list_design_qc(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_qc_works($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			if($row['APP_COUNT']==0){
				$status.='<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Pending ('.$order_count.')</strong></span>';
			}else{
				if($order_count==0){
						$status.='&nbsp;<span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Approved ('.$temCount.')</strong></span>';
				}else{
					$status.='&nbsp;<span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Approved ('.$row['APP_COUNT'].')</strong></span>';
					$status.='&nbsp;<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Pending ('.$order_count.')</strong></span>';
			}
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
	
	//___________________________________
	
	public function design_request(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->qc_model->get_my_design_requests($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$option='<td style="text-align:center;">';
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$data[]= array(
					$row['orderform_number'],
					//$row['schedule_c_date'],
					$row['production_unit_name'],
					$row['submitted_item'],
					$option
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
		
		
	}
	public function design(){
		//echo $this->session->userdata('role_name');
		//print_r($results);
		$data['title']="Qc | Design Requests";
		$data['view']='qc/list_request_design';
		$this->load->view('layout',$data);
	}
	
	
}
 