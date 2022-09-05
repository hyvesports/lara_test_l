<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printing extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('printing_model', 'printing_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('log_model', 'log_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->library('datatable');
		$this->load->library('msg91');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	public function list_works_printing($type){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data_by_fields($loginid);
		$records = $this->printing_model->get_works_printing($staffRow['department_id'],$staffRow['unit_managed'],$type);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/all" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			
			
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
				$dispatchRow=$this->common_model->get_order_final_dispatch_date_by_field($row['is_re_scheduled']);
			}else{
				$dispatchRow=$this->common_model->get_order_final_dispatch_date_by_field($row['schedule_id']);
			}
			
			if($row['lead_id']==0){ $sales_handler='Admin';}else{ $sales_handler=$row['sales_handler'];}
			$ref="";
			$srow=$this->common_model->get_schedule_numbers($staffRow['department_id'],$staffRow['unit_managed'],$row['order_id']);
			if(isset($srow)){
				$TOTAL_SCHEDULES_ARRAY=explode(',',$srow['TOTAL_SCHEDULES']);
				$tschedules=count($TOTAL_SCHEDULES_ARRAY);
				$thisSchedule = array_search($row['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY);
				$thisSchedule+=1;
			}
			if($row['BUNDLING_REJECTED_COUNT']!=""){ 
				$rejCount=$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
			}else{
				$rejCount=$row['REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			};
			$appCount=$row['APPROVED_COUNT'];
			$st='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#statusInfo"  data-sid="'.$row['schedule_department_id'].'" data-fd="printing" data-did="'.$staffRow['department_id'].'">View Status</a>';
			
			if($row['wo_product_info']!=""){
				$quicInfo='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#scheduleInfo"  data-sid="'.$row['schedule_department_id'].'" title="'.$row['wo_product_info'].'" >'.substr($row['wo_product_info'],0,30).'..</a>';
			}else{
				$quicInfo='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#scheduleInfo"  data-sid="'.$row['schedule_department_id'].'" >Nil</a>';
			}

			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$thisSchedule.'/'.$tschedules.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			$quicInfo,
			$st,
			$option
			);
			
			}
		$records['data']=$data;
		//print_r($records['data']);
		echo json_encode($records);	
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function printing_list_competed(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->printing_model->get_printing_completed_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$arrayItemCount=0;
		$recordsListCount=0;
		foreach ($records['data']  as $row) 
		{
		
			//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					$arrayItemCount++;
					if($value1['item_unit_qty_input']!=0){
						$i++;
						$up="";
						$mup="";
						$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/pending" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
						$wo_product_info="";
						if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
						$re="";
						if($row['is_re_scheduled']>0){
							$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
						}else{
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
						}
						if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
						$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'design','design_qc');
						//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
						$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],5);
						if(isset($any_rejection)){
							//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
							$rejection_count++;
						}else{
							if(isset($lastUpdateRow)){
								if($lastUpdateRow['verify_status']==1){
									//$st='<span class="badge badge-outline-success w-100" > QC Approved</span>';
									$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'printing','fusing');
									if($myUpdation){
										//$mup='<br/><span class="badge badge-outline-danger mt-1 w-100" >'.ucwords($myUpdation['row_status']).'</span>';
										$approved_count++;
									}else{
										//$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
										$submitted_count++;
									}
								}
								if($lastUpdateRow['verify_status']==-1){
									$rejection_count++;
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
								}
								if($lastUpdateRow['verify_status']==0){
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
									$not_submitted_count++;
								}
							}else{
							 	//$st='<span class="badge badge-outline-warning w-100" >QC Not Approved</span>';	
								$not_submitted_count++;
							}
						}
				
					}
				}

			}
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Approved/Submitted"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted by  Design QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Completed & Submitted To Fusing"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
			</td>';
			$approved=$i-$approved_count;
			if($approved_count>0){
			$recordsListCount++;
			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			'<label class="badge badge-outline-success text-info w-100">'.$wo_product_info.'</label>',
			$st,
			$option
			);
			}
		
		
		
		}
		$records['data']=$data;
		//$records['recordsTotal']=$recordsListCount;
		//$records['recordsFiltered']=$recordsListCount;
		echo json_encode($records);	
	}
	public function printing_list_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->printing_model->get_printing_pending_works_latest($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$itemNo=0;
		$arrayItemCount=0;
		$recordsListCount=0;
		foreach ($records['data']  as $row) 
		{
			//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					$arrayItemCount++;
					if($value1['item_unit_qty_input']!=0){
						$i++;
						$up="";
						$mup="";
						$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/pending" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
						$wo_product_info="";
						if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
						$re="";
						if($row['is_re_scheduled']>0){
							$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
						}else{
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
						}
						if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
						$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'design','design_qc');
						//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
						$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],5);
						if(isset($any_rejection)){
							//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
							$rejection_count++;
						}else{
							if(isset($lastUpdateRow)){
								if($lastUpdateRow['verify_status']==1){
									//$st='<span class="badge badge-outline-success w-100" > QC Approved</span>';
									$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'printing','fusing');
									if($myUpdation){
										//$mup='<br/><span class="badge badge-outline-danger mt-1 w-100" >'.ucwords($myUpdation['row_status']).'</span>';
										$approved_count++;
									}else{
										//$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
										$submitted_count++;
									}
								}
								if($lastUpdateRow['verify_status']==-1){
									$rejection_count++;
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
								}
								if($lastUpdateRow['verify_status']==0){
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
									$not_submitted_count++;
								}
							}else{
							 	//$st='<span class="badge badge-outline-warning w-100" >QC Not Approved</span>';	
								$not_submitted_count++;
							}
						}
				
					}
				}

			}
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Approved/Submitted"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted by  Design QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Completed & Submitted To Fusing"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
			</td>';
			if($not_submitted_count>0 || $submitted_count>0 ){
			$recordsListCount++;
			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			'<label class="badge badge-outline-success text-info w-100">'.$wo_product_info.'</label>',
			$st,
			$option
			);
			}
		
		
		}
		//echo $arryItemCount;
		$records['data']=$data;
		//$records['recordsTotal']=$recordsListCount;
		//$records['recordsFiltered']=$recordsListCount;
		echo json_encode($records);	
	}
	public function printing_list_active(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->printing_model->get_printing_active_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$arrayItemCount=0;
		foreach ($records['data']  as $row) 
		{
			//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					$arrayItemCount++;
					if($value1['item_unit_qty_input']!=0){
						$i++;
						$up="";
						$mup="";
						$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/active" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
						$wo_product_info="";
						if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
						$re="";
						if($row['is_re_scheduled']>0){
							$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
						}else{
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
						}
						if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
						$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'design','design_qc');
						//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
						$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],5);
						if(isset($any_rejection)){
							//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
							$rejection_count++;
						}else{
							if(isset($lastUpdateRow)){
								if($lastUpdateRow['verify_status']==1){
									//$st='<span class="badge badge-outline-success w-100" > QC Approved</span>';
									$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'printing','fusing');
									if($myUpdation){
										//$mup='<br/><span class="badge badge-outline-danger mt-1 w-100" >'.ucwords($myUpdation['row_status']).'</span>';
										$approved_count++;
									}else{
										//$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
										$submitted_count++;
									}
								}
								if($lastUpdateRow['verify_status']==-1){
									$rejection_count++;
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
								}
								if($lastUpdateRow['verify_status']==0){
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
									$not_submitted_count++;
								}
							}else{
							 	//$st='<span class="badge badge-outline-warning w-100" >QC Not Approved</span>';	
								$not_submitted_count++;
								
							}
						}
				
					}
				}

			}
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Approved/Submitted"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted by  Design QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Completed & Submitted To Fusing"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
			</td>';

			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			'<label class="badge badge-outline-success text-info w-100">'.$wo_product_info.'</label>',
			$st,
			$option
			);
		
		
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function printing_list_all(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->printing_model->get_printing_all_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$arrayItemCount=0;
		foreach ($records['data']  as $row) 
		{
			//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					$arrayItemCount++;
					if($value1['item_unit_qty_input']!=0){
						$i++;
						$up="";
						$mup="";
						$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/all" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
						$wo_product_info="";
						if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
						$re="";
						if($row['is_re_scheduled']>0){
							$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
						}else{
							$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
						}
						if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
						$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'design','design_qc');
						//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
						$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],5);
						if(isset($any_rejection)){
							//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
							$rejection_count++;
						}else{
							if(isset($lastUpdateRow)){
								if($lastUpdateRow['verify_status']==1){
									//$st='<span class="badge badge-outline-success w-100" > QC Approved</span>';
									$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'printing','fusing');
									if($myUpdation){
										//$mup='<br/><span class="badge badge-outline-danger mt-1 w-100" >'.ucwords($myUpdation['row_status']).'</span>';
										$approved_count++;
									}else{
										//$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
										$submitted_count++;
									}
								}
								if($lastUpdateRow['verify_status']==-1){
									$rejection_count++;
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
								}
								if($lastUpdateRow['verify_status']==0){
									//$st='<span class="badge badge-outline-danger w-100" >QC Not Approved</span>';
									$not_submitted_count++;
								}
							}else{
							 	//$st='<span class="badge badge-outline-warning w-100" >QC Not Approved</span>';	
								$not_submitted_count++;
								
							}
						}
				
					}
				}

			}
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Approved/Submitted"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted by  Design QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Completed & Submitted To Fusing"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
			</td>';

			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			'<label class="badge badge-outline-success text-info w-100">'.$wo_product_info.'</label>',
			$st,
			$option
			);
		
		}
		$records['data']=$data;
		echo json_encode($records);	
	} 
//_______________________________________________________________________________________________________________________________________________________________________________________	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------	
	//_________________________________________________________
	
	public function order_view($uuid,$sdid,$rs_design_id){
		//echo $rs_design_id;
		$data['title']="Order Submitted | View";
		$data['title_head']="Order Submitted | View";
		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$data['staffRow']=$staffRow;
		
		if($staffRow['department_id']==5){
			$data['request_row']=$this->printing_model->get_design_request_row($rs_design_id);
			
			$data['view']='printing/printing_order_view_single';
			$this->load->view('layout',$data);
		}
		
	}
	
	public function printing_order_submitted(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->printing_model->get_printing_submitted_works($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			$option.='<a href="#"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Submitted </label></a>&nbsp;';
			
			
			
			
			
			$option.='<a href="'.base_url('printing/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/'.$row['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View</label></a>';
			
			
			
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
	
	public function printing_list_pending_old(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		
		//echo $staffRow['department_id'];
		$records = $this->printing_model->get_printing_pending_works($staffRow['department_id'],$staffRow['unit_managed']);
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
			if($row['APP_COUNT']==0){
				$status='<td><span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>QC Not approved ('.$temCount.')</strong></span></td>';

			}else{
				if($order_count==0){
					$status='<td><span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>QC Approved ('.$row['APP_COUNT'].')</strong></span></td>';
				}else{
					
					$status='<td><span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>QC Approved ('.$row['APP_COUNT'].')</strong></span></td>';
					$status.='&nbsp;<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>QC Not approved ('.$order_count.')</strong></span></td>';
					
				}
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
	
	
	public function save_updates(){
		if($this->input->post('submitData')){
//error_log("Same printing",0);
			$this->form_validation->set_rules('schedules_status_id', 'Status', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<h4><i class="icon fa fa-warning"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
				exit;
			}else{
				//echo $scheduled_order_info=$this->input->post('scheduled_order_info');
				//exit;
				$schedule_department_id=$this->input->post('schedule_department_id');
				$schedule_id=$this->input->post('schedule_id');
				$order_id=$this->input->post('order_id');
				$unit_id=$this->input->post('unit_id');
				$summary_id=$this->input->post('summary_id');
				$schedules_status_id=$this->input->post('schedules_status_id');
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$now = date('d-m-Y H:i:s');
				$response_remark=$this->input->post('schedules_status_remark');
				$response_url=$this->input->post('schedules_status_url');
				$statusRow=$this->myaccount_model->get_status_data_by_id($_POST['schedules_status_id']);
				$sDepartmentRow=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['schedule_department_id']);
				
				
				$selPre="SELECT * FROM rs_design_departments WHERE schedule_id='$schedule_id' AND summary_item_id='$summary_id' and unit_id='$unit_id' and printing_submitted=0 and row_status='approved' and to_department='design_qc' ORDER BY rs_design_id DESC LIMIT 1 ";
				$queryPre = $this->db->query($selPre);			 
    			$rsRowPre=$queryPre->row_array();
				if($rsRowPre){
					$rs_design_id=$rsRowPre['rs_design_id'];
					$upPre="UPDATE rs_design_departments SET printing_submitted='1' WHERE rs_design_id='$rs_design_id' ";
					$this->db->query($upPre);
				}
				$log_info=$this->input->post('log_info');
				$insertNew= array(
				'schedule_department_id'=>$schedule_department_id,
				'schedule_id'=>$schedule_id,
				'unit_id'=>$unit_id,
				'summary_item_id'=>$summary_id,
				'status_id'=>$schedules_status_id,
				'status_value'=>$statusRow['status_value'],
				'response_remark'=>$response_remark,
				'submitted_by' =>$this->session->userdata('loginid'),
				'submitted_datetime'=>$now,
				'verify_status'=>1,
				'submitted_item'=>$sDepartmentRow['scheduled_order_info'],
				'verify_datetime'=>$now,
				'approved_dept_id'=>5,
				'qc_name'=>'printing',
				'approved_by'=>$this->session->userdata('loginid'),
				'from_department'=>'printing',
				'to_department'=>'fusing',
				'row_status'=>'submitted',
				'log_info'=>$log_info
				);
				
				
				//print_r($insertNew);exit;
				$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='$schedule_department_id'  AND summary_item_id='$summary_id' and qc_name='printing' ORDER BY rs_design_id DESC LIMIT 1 ";
				//echo $sel;
				$query = $this->db->query($sel);					 
    			$rsRow=$query->row_array();
				if($rsRow['status_value']==1 ){
					if($rsRow['verify_status']==1){
						$message='<div class="alert alert-danger alert-dismissible" style="width:100%;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<h4>Already work approved!</h4>
						<p>Cannot update the status!!!</p>
						</div>';
						echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
						exit;	
					}else if($rsRow['verify_status']==0){
						$message='<div class="alert alert-danger alert-dismissible" style="width:100%;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<h4>Alreay submitted!</h4>
						<p>Cannot update the status!!!</p>
						</div>';
						echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
						exit;
					}else{
						$loginid=$this->session->userdata('loginid');
						date_default_timezone_set('Asia/kolkata');
						$now = date('d-m-Y H:i:s');
						if($loginid!=1){
							$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
							$luser=$staffRow['staff_name'];
						}else{
						    $luser="admin";
						}
						$log_desc="Work order (".$log_info.") re-submitted by ".$luser." on ".$now;
						$log_data = array(
							'log_title' => 'Work order submitted ['.$log_info.'] to fusing.',				  
							'log_timestamp'=>$now,
							'log_controller' => 'printing',
							'log_function' => 'save_updates',
							'log_module' => 'Printing Submit',
							'log_desc' => $log_desc,
							'access_module_code'=>'printing_submitted',
							'log_updated_by' => $this->session->userdata('loginid')
						);
						$this->log_model->insert_log_data($log_data);
						$this->db->insert('rs_design_departments', $insertNew);
						
						//UPDATE `History` SET `state`=0 WHERE `idSession`=65 ORDER BY `id` DESC LIMIT 1
						
						$u1="UPDATE rs_design_departments SET is_current=0 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ";
						$this->db->query($u1);
						
						$u2="UPDATE rs_design_departments SET is_current=1 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ORDER BY `rs_design_id` DESC LIMIT 1 ";
						$this->db->query($u2);
//                        error_log("Same printing 1",0);
						//sms integration
                        $unitTypeArray=$this->workorder_model->get_order_data_unit_type($order_id);
			if($unitTypeArray['orderform_type_id'] ==2)
			    {
				$customerArray=$this->workorder_model->get_order_summary_by_summary_no($order_id,$summary_id);
				$scheduleSmsArray=$this->workorder_model->get_online_order_sms_status($order_id,$summary_id,'printing_sms');
				$chkSmsDataAvailable=$this->workorder_model->get_online_order_sms_completed($order_id,$summary_id);
				
				if($customerArray)
				    {
					if($scheduleSmsArray['cnt'] < 1)
					    {
						$customer_phone_no=$customerArray['summary_client_mobile'];
						$orderform_number=$customerArray['orderform_number'];
						$wo_ref_no=$customerArray['wo_ref_no'];
						
						if($customer_phone_no!='')
						    {
							$sms_status=$this->msg91->send_online_printing_order_sms($customer_phone_no, $wo_ref_no);
							//							$sms_status=$this->msg91->send_schedule_order_sms("8248420402");
							
							if($sms_status==1)
							    {
								if($chkSmsDataAvailable['cnt'] > 0)
								    {
									
									$sdataSms = array(
											  'printing_sms' =>'1'
											  );
									
									$smsCreationStatus=$this->workorder_model->update_sms_wo_data($order_id,$summary_id,$sdataSms);
								    }
								else
								    {
									$sdataSms = array(
											  'wo_order_id' =>$order_id,
											  'wo_order_type' =>'2',
											  'wo_order_summary_id' =>$summary_id,
											  'printing_sms' =>'1',
											  );
									$smsCreationStatus=$this->workorder_model->insert_sms_wo_data($sdataSms);
								    }
//								error_log("Sms Creation Status===".$smsCreationStatus);
							    }
						    }
						
					    }
				    }
			    }

                        
			if($unitTypeArray['orderform_type_id'] ==1)
			    {
				$customerArray=$this->workorder_model->get_order_data_by_order_id($order_id);
				$scheduleSmsArray=$this->workorder_model->get_order_sms_status($order_id,'printing_sms');
				
				if($customerArray)
				    {
					if($scheduleSmsArray['cnt'] < 1)
					    {
						$customer_phone_no=$customerArray['customer_mobile_no'];
						$orderform_number=$customerArray['orderform_number'];
						if($customer_phone_no!='')
						    {
							$sms_status=$this->msg91->send_offline_printing_order_sms($customer_phone_no,$orderform_number);
//							error_log("Sms Status=====". $sms_status,0);
							if($sms_status==1)
							    {
								$sdataSms = array(
										  'wo_order_id' =>$order_id,
										  'wo_order_type' =>'1',
										  'wo_order_summary_id' =>'',
										  'printing_sms' =>'1'
										  );
								$smsCreationStatus=$this->workorder_model->insert_sms_wo_data($sdataSms);
//								error_log("Sms Creation Status===".$smsCreationStatus);
							    }
						    }
						
					    }
				    }
			    }
						


						
						$message='<div class="alert alert-success alert-dismissible" style="width:100%;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<h4>Success!</h4>
						<p>Data saved successfully...!</p>
						</div>';
						echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
						exit;
					}
				}else{
					
						$loginid=$this->session->userdata('loginid');
						date_default_timezone_set('Asia/kolkata');
						$now = date('d-m-Y H:i:s');
						if($loginid!=1){
							$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
							$luser=$staffRow['staff_name'];
						}else{
							$luser="admin";
						}
						$log_desc="Work order (".$log_info.") submitted by ".$luser." on ".$now;
						$log_data = array(
							'log_title' => 'Work order submitted ['.$log_info.'] to fusing.',				  
							'log_timestamp'=>$now,
							'log_controller' => 'printing',
							'log_function' => 'save_updates',
							'log_module' => 'Printing Submit',
							'log_desc' => $log_desc,
							'access_module_code'=>'printing_submitted',
							'log_updated_by' => $this->session->userdata('loginid')
						);
						$this->log_model->insert_log_data($log_data);
					
					$this->db->insert('rs_design_departments', $insertNew);
					$u1="UPDATE rs_design_departments SET is_current=0 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ";
						$this->db->query($u1);
						
						
						$u2="UPDATE rs_design_departments SET is_current=1 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ORDER BY `rs_design_id` DESC LIMIT 1 ";
						$this->db->query($u2);
//                        error_log("Same printing 2",0);
						//sms integration
//						error_log("====Order Id".$order_id,0);
                        $unitTypeArray=$this->workorder_model->get_order_data_unit_type($order_id);
                        
			if($unitTypeArray['orderform_type_id'] ==2)
			    {
				$customerArray=$this->workorder_model->get_order_summary_by_summary_no($order_id,$summary_id);
				$scheduleSmsArray=$this->workorder_model->get_online_order_sms_status($order_id,$summary_id,'printing_sms');
				$chkSmsDataAvailable=$this->workorder_model->get_online_order_sms_completed($order_id,$summary_id);
				
				if($customerArray)
				    {
					if($scheduleSmsArray['cnt'] < 1)
					    {
						$customer_phone_no=$customerArray['summary_client_mobile'];
						$orderform_number=$customerArray['orderform_number'];
$wo_ref_no=$customerArray['wo_ref_no'];

if($customer_phone_no!='')
{
$sms_status=$this->msg91->send_online_printing_order_sms($customer_phone_no, $wo_ref_no);
//							$sms_status=$this->msg91->send_schedule_order_sms("8248420402");

if($sms_status==1)
{
if($chkSmsDataAvailable['cnt'] > 0)
{

$sdataSms = array(
                                                                                  'printing_sms' =>'1'
                                                                                  );

								$smsCreationStatus=$this->workorder_model->update_sms_wo_data($order_id,$summary_id,$sdataSms);
}
else
{
								$sdataSms = array(
										  'wo_order_id' =>$order_id,
										  'wo_order_type' =>'2',
										  'wo_order_summary_id' =>$summary_id,
										  'printing_sms' =>'1',
										  );
								$smsCreationStatus=$this->workorder_model->insert_sms_wo_data($sdataSms);
}
//								error_log("Sms Creation Status===".$smsCreationStatus);
							    }
						    }
						
					    }
				    }
			    }



			if($unitTypeArray['orderform_type_id'] ==1)
			    {
				$customerArray=$this->workorder_model->get_order_data_by_order_id($order_id);
				$scheduleSmsArray=$this->workorder_model->get_order_sms_status($order_id,'printing_sms');
				
				if($customerArray)
				    {
					if($scheduleSmsArray['cnt'] < 1)
					    {
						$customer_phone_no=$customerArray['customer_mobile_no'];
						$orderform_number=$customerArray['orderform_number'];
						
						if($customer_phone_no!='')
						    {
								$sms_status=$this->msg91->send_offline_printing_order_sms($customer_phone_no,$orderform_number);

//							error_log("Sms Status=====". $sms_status,0);
							if($sms_status==1)
							    {
								$sdataSms = array(
										  'wo_order_id' =>$order_id,
										  'wo_order_type' =>'1',
										  'wo_order_summary_id' =>'',
										  'printing_sms' =>'1',
										  );
								$smsCreationStatus=$this->workorder_model->insert_sms_wo_data($sdataSms);
//								error_log("Sms Creation Status===".$smsCreationStatus);
							    }
						    }
						
					    }
				    }
			    }


					
					$message='<div class="alert alert-success alert-dismissible" style="width:100%;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<h4>Success!</h4>
					<p>Data saved successfully...!</p>
					</div>';
					echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
					exit;
				}
				
				
			}
		}
	}
	public function updates_order_status(){
		$loginid=$this->session->userdata('loginid');
		$data['staffRow']=$this->myaccount_model->get_staff_profile_data($loginid);
		if($_POST['act']=="up"){
			$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);
			$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['sdid']);
			$this->load->view('printing/printing_order_updates',$data);
		}else{
			$this->load->view('printing/printing_order_updates_list');
		}
	}
	
}
 
