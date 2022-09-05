<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('design_model', 'design_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('log_model', 'log_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	//
	
	public function list_works_designs($type){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data_by_fields($loginid);
		$records = $this->design_model->get_works_design($staffRow['department_id'],$staffRow['unit_managed'],$type);
		$data = array();
		$tschedules=1;
		$thisSchedule=1;
		$wo_product_info="";
		foreach ($records['data']  as $row) 
		{
$appCount=0;
			$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/all" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			$srow=$this->common_model->get_schedule_numbers($staffRow['department_id'],$staffRow['unit_managed'],$row['order_id']);
			if(isset($srow)){
				$TOTAL_SCHEDULES_ARRAY=explode(',',$srow['TOTAL_SCHEDULES']);
				$tschedules=count($TOTAL_SCHEDULES_ARRAY);
				$thisSchedule = array_search($row['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY);
				$thisSchedule+=1;
			}
			
			
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
				$dispatchRow=$this->common_model->get_order_final_dispatch_date_by_field($row['is_re_scheduled']);
			}else{
				$dispatchRow=$this->common_model->get_order_final_dispatch_date_by_field($row['schedule_id']);
			}
			if($row['lead_id']==0){ $sales_handler='Admin';}else{ $sales_handler=$row['sales_handler'];}

			$ref="";
			$st='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#statusInfo"  data-sid="'.$row['schedule_department_id'].'" data-fd="design" data-did="'.$staffRow['department_id'].'">View Status</a>';
			
			if($row['wo_product_info']!=""){
				$quicInfo='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#scheduleInfo"  data-sid="'.$row['schedule_department_id'].'" title="'.$row['wo_product_info'].'" >'.substr($row['wo_product_info'],0,30).'..</a>';
			}else{
				$quicInfo='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#scheduleInfo"  data-sid="'.$row['schedule_department_id'].'" >Nil</a>';
			}
			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$thisSchedule.'/'.$tschedules.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).$row['schedule_department_id'].'</span></td>',
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
//---------------------------------------------------------------------------------------------------
	public function design_orders_competed(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_competed($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$val=0;
			//$option='<td style="text-align:center;">';
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['priority_name'].'</span></td>';
			$wo_product_info="";
			if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $upSatatus="";
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){
				 if($value1['item_unit_qty_input']!=0){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						
						if(isset($rsRow2)){
							
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
							
							
								
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
							
						}
						if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					 if(isset($rsRow2)){
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$us.$option
					); 
					 }
					$upSatatus="";
					 
				 }
			 }
			 }
			 
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function design_orders_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_pending($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$val=0;
			//$option='<td style="text-align:center;">';
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['priority_name'].'</span></td>';
			$wo_product_info="";
			if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $upSatatus="";
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){
				 if($value1['item_unit_qty_input']!=0){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						
						if(isset($rsRow2)){
							
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
							
							
								
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
							
						}
						if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					 if(!isset($rsRow2)){
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$us.$option
					); 
					 }
					$upSatatus="";
					//$total_items="";
				 }
			 }
			 }
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function design_orders_all(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_all($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$val=0;
			
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			$wo_product_info="";
			if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			
			 $i=0;if($array1) {
				 $total_items=count($array1);
				 $upSatatus="";
				 foreach($array1 as $key1 => $value1){
				 if($value1['item_unit_qty_input']!=0){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						if(isset($rsRow2)){
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Not<br/> Submitted</span>';
						}
						//if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						if( $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$us.$option
					); 
					$upSatatus="";
					//$total_items=="";
					 
				 }
			 }
			 }
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	public function design_orders_active(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_active($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$val=0;
			//$option='<td style="text-align:center;">';
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['priority_name'].'</span></td>';
			$wo_product_info="";
			if($row['wo_product_info']!=""){$wo_product_info=$row['wo_product_info'];}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $upSatatus="";
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){
					 if($value1['item_unit_qty_input']!=0){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						
						if(isset($rsRow2)){
							
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
							
							
								
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
							
						}
						if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					
					
					
					
					
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$us.$option
					); 
					$upSatatus="";
					//$total_items="";
				 }
				 }
			 }
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
//________________________________________________________________________________________________________________________________________________________________	
	public function design_orders_pending_olf(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_pending($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$val=0;
			//$option='<td style="text-align:center;">';
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['priority_name'].'</span></td>';
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $upSatatus="";
				 foreach($array1 as $key1 => $value1){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						
						if(isset($rsRow2)){
							
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
							
							
								
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
							
						}
						if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					
					
					
					
					
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$us.$option
					); 
					$upSatatus="";
					 
				 }
			 }
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function design_orders_old(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$val=0;
			//$option='<td style="text-align:center;">';
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['priority_name'].'</span></td>';
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $upSatatus="";
				 foreach($array1 as $key1 => $value1){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						
						if(isset($rsRow2)){
							
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
							
							
								
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
							
						}
						if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					
					
					
					
					
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',
						$st,
						$info.$us.$option
					); 
					$upSatatus="";
					 
				 }
			 }
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	//__________________________ latest update
	
	public function save_updates_design(){
		if($this->input->post('submitData')){
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
				$unit_id=$this->input->post('unit_id');
				$summary_id=$this->input->post('summary_id');
				$schedules_status_id=$this->input->post('schedules_status_id');
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$now = date('d-m-Y H:i:s');
				$response_remark=$this->input->post('schedules_status_remark');
				$response_url=$this->input->post('schedules_status_url');
				$statusRow=$this->myaccount_model->get_status_data_by_id($_POST['schedules_status_id']);
				
				$sDepartmentRow=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['schedule_department_id']);
				$log_info=$this->input->post('log_info');
				
				$insertNew= array(
				'schedule_department_id'=>$schedule_department_id,
				'schedule_id'=>$schedule_id,
				'unit_id'=>$unit_id,
				'summary_item_id'=>$summary_id,
				'status_id'=>$schedules_status_id,
				'status_value'=>$statusRow['status_value'],
				'response_remark'=>$response_remark,
				'response_url'=>$response_url,
				'submitted_by' =>$this->session->userdata('loginid'),
				'submitted_datetime'=>$now,
				'verify_status'=>0,
				'submitted_item'=>$sDepartmentRow['scheduled_order_info'],
				'qc_name'=>'design',
				'from_department'=>'design',
				'to_department'=>'design_qc',
				'row_status'=>'submitted',
				'log_info'=>$log_info
				);
				
				
				
				//print_r($insertNew);exit;
				$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='$schedule_department_id'  AND summary_item_id='$summary_id' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
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
						<h4>Alreay submitted to approval!</h4>
						<p>Cannot update the status!!!</p>
						</div>';
						echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
						exit;
					}else{
						$this->db->insert('rs_design_departments', $insertNew);
						
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
							'log_title' => 'Work order submitted ['.$log_info.'] to design qc.',				  
							'log_timestamp'=>$now,
							'log_controller' => 'design',
							'log_function' => 'save_updates_design',
							'log_module' => 'Design Submit',
							'log_desc' => $log_desc,
							'access_module_code'=>'design_submitted',
							'log_updated_by' => $this->session->userdata('loginid')
						);
						$this->log_model->insert_log_data($log_data);
						
						//UPDATE `History` SET `state`=0 WHERE `idSession`=65 ORDER BY `id` DESC LIMIT 1
						
						$u1="UPDATE rs_design_departments SET is_current=0 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ";
						$this->db->query($u1);
						
						$u2="UPDATE rs_design_departments SET is_current=1 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ORDER BY `rs_design_id` DESC LIMIT 1 ";
						$this->db->query($u2);
						
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
						'log_title' => 'Work order submitted ['.$log_info.'] to design qc.',				  
						'log_timestamp'=>$now,
						'log_controller' => 'design',
						'log_function' => 'save_updates_design',
						'log_module' => 'Design Submit',
						'log_desc' => $log_desc,
						'access_module_code'=>'design_submitted',
						'log_updated_by' => $this->session->userdata('loginid')
					);
					$this->log_model->insert_log_data($log_data);
					
					
					
					$this->db->insert('rs_design_departments', $insertNew);
					$u1="UPDATE rs_design_departments SET is_current=0 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ";
						$this->db->query($u1);
						
						$u2="UPDATE rs_design_departments SET is_current=1 WHERE schedule_department_id='$schedule_department_id' AND schedule_id='$schedule_id' AND unit_id='$unit_id' AND  summary_item_id='$summary_id' ORDER BY `rs_design_id` DESC LIMIT 1 ";
						$this->db->query($u2);
					
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
	
	public function updates_design(){
		$loginid=$this->session->userdata('loginid');
		$data['staffRow']=$this->myaccount_model->get_staff_profile_data($loginid);
		if($_POST['act']=="up"){
		$data['schedule_status']=$this->design_model->get_schedule_status_by_deptmt($_POST['did']);
		$data['schedule_data']=$this->design_model->get_my_order_scheduled_deptmt_data_by_id($_POST['sdid']);
			$this->load->view('design/updates_design',$data);
		}else{
			$this->load->view('design/updates_list_design');
		}
	}
	public function design_orders_approved(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_approved($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			
			//$op='badge badge-outline-danger';
			$status='<td><span class="badge badge-outline-success" >Approved :'.$row['verify_remark'].'<br>'.$row['verify_datetime'].'</span></td>';
			
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
	
	public function design_orders_rejected(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_rejected($staffRow['department_id'],$staffRow['unit_managed']);
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
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
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
	
	
	
	public function design_orders_upcoming(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_upcoming($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		
		foreach ($records['data']  as $row) 
		{
			$itemArray = json_decode($row['scheduled_order_info']);
			$temCount=count($itemArray);
			$option='<td style="text-align:center;">';
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			$option.='</td>';
			$wo_product_info='<td>'.$row['wo_product_info'].'</td>';
			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			$data[]= array(
				date("d-m-Y", strtotime($row['department_schedule_date'])),
				'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['orderform_number'].' ['.$temCount.']</span></td>',
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
	
	
}
 