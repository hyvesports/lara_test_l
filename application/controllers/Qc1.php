<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qc extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('log_model', 'log_model');  
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	
	
	public function list_design_qc_completed(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_qc_works_completed($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			
			
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			if(isset($value1['online_ref_number'])){
			$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
			}else{
			$ref="";
			}
			
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){$i++;
					 if($row['summary_item_id']==$value1['summary_id']){
				if($value1['item_unit_qty_input']!=0){
					
					
					$completed=0;
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row($row['schedule_department_id'],$value1['summary_id'],'design','design_qc');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected :<br/> '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$completed=1;
							$st='<span class="badge badge-outline-success" >Approved</span>';
							}
							if($lastUpdateRow['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($lastUpdateRow['verify_status']==0){
								
							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
						}
					}
					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					if($completed==1){
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$option
					);
					}
					$completed="";
				 }
			 }
			 }
			 }
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
			
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			if(isset($value1['online_ref_number'])){
			$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
			}else{
			$ref="";
			}
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $total_items=count($array1);
				 $pending=1;
				 foreach($array1 as $key1 => $value1){$i++;
					 if($row['summary_item_id']==$value1['summary_id']){
				if($value1['item_unit_qty_input']!=0){
					$pending=0;
					
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row($row['schedule_department_id'],$value1['summary_id'],'design','design_qc');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected </span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved</span>';
							}
							if($lastUpdateRow['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($lastUpdateRow['verify_status']==0){
							$pending=1;
							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
						}
					}
					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					if($pending==1){
						$data[]= array(
							'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
							'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
							'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
							date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
							$sales_handler,
							'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
							$st,
							$info.$option
						);
					}
				 }
					 }
				 }
			 }
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function list_design_qc_all(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_qc_works_all($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			
			
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			if(isset($value1['online_ref_number'])){
			$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
			}else{
			$ref="";
			}
			
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){
					 if($value1['item_unit_qty_input']!=0){
					$i++;
					
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row($row['schedule_department_id'],$value1['summary_id'],'design','design_qc');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected :<br/> '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved</span>';
							}
							if($lastUpdateRow['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($lastUpdateRow['verify_status']==0){
							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success m-1 w-100" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a><br/><a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger m-1 w-100" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
						}
					}
					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$option
					);
				 }
				 }
			 }
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function list_design_qc_active(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_qc_works_active($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			
			
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			if(isset($value1['online_ref_number'])){
			$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
			}else{
			$ref="";
			}
			
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){
				 if($value1['item_unit_qty_input']!=0){
					$i++;
					
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row($row['schedule_department_id'],$value1['summary_id'],'design','design_qc');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected :<br/> '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved</span>';
							}
							if($lastUpdateRow['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($lastUpdateRow['verify_status']==0){
							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
						}
					}
					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$option
					);
				 }
				 }
			 }
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
//__________________________________________________________________________________________________________________________________________________________________	
	
	
	public function list_design_qc(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_qc_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			
			//$option='<td style="text-align:center;">';
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			$wo_product_info='<td>'.$row['wo_product_info'].'</td>';
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			if(isset($value1['online_ref_number'])){
			$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
			}else{
			$ref="";
			}
			
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 foreach($array1 as $key1 => $value1){
					$i++;
					
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row($row['schedule_department_id'],$value1['summary_id'],'design','design_qc');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected :<br/> '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved : '.$lastUpdateRow['verify_remark'].'<br>'.$lastUpdateRow['verify_datetime'].'</span>';
							}
							if($lastUpdateRow['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd : '.$lastUpdateRow['verify_remark'].'<br>'.$lastUpdateRow['verify_datetime'].'</span>';
							}
							if($lastUpdateRow['verify_status']==0){
							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
						}
					}
					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span></td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.'<br>'.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$option
					);
				 }
			 }
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	//_______________________________up
	
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
				
			if($verify_status==-1){
				$sql="UPDATE
					rs_design_departments 
				SET 
					approved_dept_id='12',
					verify_status='$verify_status',
					verify_remark='$verify_remark',
					verify_datetime='$verify_datetime',
					rejected_department='final qc',
					rejected_by='$approved_by',
					row_status='rejected'
				WHERE
					rs_design_id='$rs_design_id' ";
				$query = $this->db->query($sql);
				if($reject_dep_id==4){
					
					$deptmts=$this->qc_model->get_all_department_for_rejection($rej_schedule_id,$rej_unit_id);
					if($deptmts){
						foreach($deptmts as $DP){
							$schedule_department_id=$DP['schedule_department_id'];
							$order_id=$DP['order_id'];
							$schedule_id=$DP['schedule_id'];
							$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0');";
							$query = $this->db->query($ins);	
							
						}
					}
				}
				if($reject_dep_id==8){
					$sql="SELECT 
						sh_schedule_departments.*,wo_work_orders.orderform_type_id
					FROM
						sh_schedule_departments
						LEFT JOIN wo_work_orders ON wo_work_orders.order_id=sh_schedule_departments.order_id
					WHERE
						sh_schedule_departments.schedule_id='$rej_schedule_id' AND
						sh_schedule_departments.unit_id='$rej_unit_id' AND FIND_IN_SET(8,sh_schedule_departments.department_ids)"; 
					//echo $sql;
					$query = $this->db->query($sql);					 
    				$rsRow=$query->row_array();
					
					
					if($rsRow['orderform_type_id']=="2"){ //online order
						$schedule_department_id=$rsRow['schedule_department_id'];
						$order_id=$rsRow['order_id'];
						$schedule_id=$rsRow['schedule_id'];
						$unit_id=$rsRow['unit_id'];
					
						$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
						$query = $this->db->query($ins);
					}
					if($rsRow['orderform_type_id']=="1"){ //offline order
						
						$s_deptmts=$this->qc_model->get_all_schedule_departments_for_offline_rejection($rej_schedule_id,$rej_unit_id,'8'); //stitching
						if($s_deptmts){
							foreach($s_deptmts as $SDP){
								$schedule_department_id=$SDP['schedule_department_id'];
								$order_id=$SDP['order_id'];
								$schedule_id=$SDP['schedule_id'];
								$unit_id=$SDP['unit_id'];
								
								$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
								$query = $this->db->query($ins);	
								
							}
						}
						
						$f_deptmts=$this->qc_model->get_all_schedule_departments_for_offline_rejection($rej_schedule_id,$rej_unit_id,'13'); //Packing,Final QC
						if($f_deptmts){
							foreach($f_deptmts as $FDP){
								$schedule_department_id=$FDP['schedule_department_id'];
								$order_id=$FDP['order_id'];
								$schedule_id=$FDP['schedule_id'];
								$unit_id=$FDP['unit_id'];
								
								$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
								$query = $this->db->query($ins);	
								
							}
						}
						
						$d_deptmts=$this->qc_model->get_all_schedule_departments_for_offline_rejection($rej_schedule_id,$rej_unit_id,'10'); //Dispatch
						if($d_deptmts){
							foreach($d_deptmts as $DDP){
								$schedule_department_id=$DDP['schedule_department_id'];
								$order_id=$DDP['order_id'];
								$schedule_id=$DDP['schedule_id'];
								$unit_id=$DDP['unit_id'];
								$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
								$query = $this->db->query($ins);	
								
							}
						}
						
						
						
					}
					
				}
			}else{
								
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
					accounts_verified_by='0',
					row_status='approved'
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
			$itemRefNo="";
			$itemArray = json_decode($row['submitted_item']);
			if($itemArray) {
				foreach($itemArray as  $value1){
					if($value1->summary_id==$row['summary_item_id']){
						if(isset($value1->online_ref_number)){
						$itemRefNo=$value1->online_ref_number;
						}
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
	
	
	public function list_design_qc_pending_old(){
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
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			$option.='</td>';
			
			//$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			$wo_product_info='<td>'.$row['wo_product_info'].'</td>';
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$data[]= array(
				date("d-m-Y", strtotime($row['department_schedule_date'])),
				'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.$row['orderform_number'].'</span></td>',
				'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
				date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
				$sales_handler,
				$wo_product_info,
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
			$log_info=$this->input->post('log_info');
			
			//
			$loginid=$this->session->userdata('loginid');
			 if($verify_status==1){
				 $qc_name='design';
				 $rejected_department='';
				 $rejected_by='';
				 $approved_dep_name='design_qc';
				 $approved_by=$loginid;
				 $row_status='approved';
				 
				 
				 		$loginid=$this->session->userdata('loginid');
						date_default_timezone_set('Asia/kolkata');
						$now = date('d-m-Y H:i:s');
						if($loginid!=1){
							$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
							$luser=$staffRow['staff_name'];
						}else{
							$luser="admin";
						}
						$log_desc="Work order (".$log_info.") approved by ".$luser." on ".$now;
						$log_data = array(
							'log_title' => 'Work order approved ['.$log_info.'] by design qc.',				  
							'log_timestamp'=>$now,
							'log_controller' => 'qc',
							'log_function' => 'save_status',
							'log_module' => 'Design Approve/Reject',
							'log_desc' => $log_desc,
							'access_module_code'=>'design_approval_rejection',
							'log_updated_by' => $this->session->userdata('loginid')
						);
						$this->log_model->insert_log_data($log_data);
				 
			 }else{
				  $qc_name='design';
				  $rejected_department='Design QC';
				  $rejected_by=$loginid;
				  $row_status='rejected';
				  		$loginid=$this->session->userdata('loginid');
						date_default_timezone_set('Asia/kolkata');
						$now = date('d-m-Y H:i:s');
						if($loginid!=1){
							$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
							$luser=$staffRow['staff_name'];
						}else{
							$luser="admin";
						}
						$log_desc="Work order (".$log_info.") rejected by ".$luser." on ".$now;
						$log_data = array(
							'log_title' => 'Work order rejected ['.$log_info.'] by design qc.',				  
							'log_timestamp'=>$now,
							'log_controller' => 'qc',
							'log_function' => 'save_status',
							'log_module' => 'Design Approve/Reject',
							'log_desc' => $log_desc,
							'access_module_code'=>'design_approval_rejection',
							'log_updated_by' => $this->session->userdata('loginid')
						);
						$this->log_model->insert_log_data($log_data);
			 }
			 
			 
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
				rejected_by='$rejected_by',
				row_status='$row_status'
			WHERE
				rs_design_id='$rs_design_id' ";
			
			$query = $this->db->query($sql);		
			$this->session->set_flashdata('success','Successfull updated the order status.');	
			
		}
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
						$itemRefNo="";
						if(isset($value1->online_ref_number)){
						$itemRefNo=$value1->online_ref_number;
						}
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
 