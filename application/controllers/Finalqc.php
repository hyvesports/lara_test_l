<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Finalqc extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('notification_model', 'notification_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	public function list_works_finalqc($type){

		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data_by_fields($loginid);
		$records = $this->qc_model->get_works_finalqc($staffRow['department_id'],$staffRow['unit_managed'],$type);
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
			$st='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#statusInfo"  data-sid="'.$row['schedule_department_id'].'" data-fd="finalqc" data-did="'.$staffRow['department_id'].'">View Status</a>';
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
//##########################################################################################
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
			$batch_number=$this->input->post('batch_number');
			$hidden_order_id=$this->input->post('hidden_order_id');
			$hidden_schedule_id=$this->input->post('hidden_schedule_id');
			$hidden_summary_id=$this->input->post('hidden_summary_id');
			$hidden_rs_design_id=$this->input->post('hidden_rs_design_id');
			$hidden_schedule_department_id=$this->input->post('hidden_schedule_department_id');
			$item_unit_qty_input=$this->input->post('item_unit_qty_input');
			$rej_qty_notification=$this->input->post('rej_qty');

			if($verify_status==-1){
				$rej_qty=$this->input->post('rej_qty');
				$approvedQty=$item_unit_qty_input-$rej_qty;
				$sqlSel="Select * from rs_design_departments where rs_design_id='$rs_design_id'"; 
				$query = $this->db->query($sqlSel);					 
				$rsRowData=$query->row_array();
				$submitted_item=$rsRowData['submitted_item'];
				$item_unit_qty_input=0;
				$submitted_item_array=json_decode($submitted_item,true);
				foreach($submitted_item_array as $postkey=>$postvalue){
					if($rsRowData['summary_item_id']==$submitted_item_array[$postkey]['summary_id']){
						$submitted_item_array[$postkey]['item_rejected_qty']=$rej_qty;
						$submitted_item_array[$postkey]['item_unit_qty_input']=$approvedQty;

						$summary_id=$submitted_item_array[$postkey]['summary_id'];
						$product_type=$submitted_item_array[$postkey]['product_type'];
						$collar_type=$submitted_item_array[$postkey]['collar_type'];
						$sleeve_type=$submitted_item_array[$postkey]['sleeve_type'];
						$fabric_type=$submitted_item_array[$postkey]['fabric_type'];
						$addon_name=$submitted_item_array[$postkey]['addon_name'];
						$img_back=$submitted_item_array[$postkey]['img_back'];
						$img_front=$submitted_item_array[$postkey]['img_front'];
						$remark =$submitted_item_array[$postkey]['remark'];
						$orderno=$submitted_item_array[$postkey]['orderno'];
						$priority_name=$submitted_item_array[$postkey]['priority_name'];
						$priority_color_code=$submitted_item_array[$postkey]['priority_color_code'];
						$item_order_sec=$submitted_item_array[$postkey]['item_order_sec'];
						$item_order_total_sec =$submitted_item_array[$postkey]['item_order_total_sec'];
						$item_order_capacity =$submitted_item_array[$postkey]['item_order_capacity'];
						$item_order_qty =$submitted_item_array[$postkey]['item_order_qty'];
						$online_ref_number =$submitted_item_array[$postkey]['online_ref_number'];
						$item_position =$submitted_item_array[$postkey]['item_position'];
						$item_rejected_qty =0;
						$item_re_schedule_id =1;
						$item_unit_qty_input =$rej_qty;
					}
				}
				$new_item_array=array(array('summary_id' =>$summary_id,'product_type' =>$product_type,'collar_type' =>$collar_type,'sleeve_type' =>$sleeve_type,'fabric_type' =>$fabric_type,'addon_name' =>$addon_name,'img_back' =>$img_back,'img_front' =>$img_front,'remark' =>$remark,'orderno' =>$orderno,'priority_name' =>$priority_name,'priority_color_code' =>$priority_color_code,'item_order_sec' =>$item_order_sec,'item_order_total_sec' =>$item_order_total_sec,'item_order_capacity' =>$item_order_capacity,'item_order_qty' =>$item_order_qty,
'online_ref_number' =>$online_ref_number,'item_position' =>$item_position,'item_rejected_qty' =>$item_rejected_qty,'item_re_schedule_id' =>$item_re_schedule_id,'item_unit_qty_input' =>$item_unit_qty_input));
				$submitted_item_updated=json_encode($new_item_array);
				$orderform_type_id=addslashes($this->input->post('orderform_type_id'));

				if($approvedQty!=0){ // partial approval &rejection
					if($orderform_type_id==1){
						$submitted_to_accounts=0;
						$accounts_status=0;
						$accounts_verified_by=0;
						$production_completed_status=1;
						$accounts_completed_status=0;
					}else{
						$submitted_to_accounts=1;
						$accounts_status=1;
						$accounts_verified_by=1;
						$production_completed_status=1;
						$accounts_completed_status=1;
					}
					$sqlApprove="UPDATE rs_design_departments SET approved_dept_id='13',verify_status='1',verify_remark='$verify_remark',
verify_datetime='$verify_datetime',approved_by='$approved_by',approved_dep_name='Final QC',
submitted_to_accounts='$submitted_to_accounts',accounts_status='$accounts_status',accounts_verified_by='$accounts_verified_by',row_status='approved'
 WHERE rs_design_id='$rs_design_id' ";
					$query = $this->db->query($sqlApprove);

					$completed_data = array('order_id'=>$hidden_order_id,'schedule_id'=>$hidden_schedule_id,'schedule_dept_id'=>$hidden_schedule_department_id,'response_id'=>$hidden_rs_design_id,'summary_id'=>$hidden_summary_id,'qc_approved_qty'=>$approvedQty,'qc_approved_date'=>$verify_datetime);
					$completedWoRow=$this->common_model->check_wo_is_completed($hidden_order_id);
					if(!$completedWoRow){
						$odata=array('production_completed_status'=>$production_completed_status,'accounts_completed_status'=>$accounts_completed_status);
						$this->common_model->update_wo_completion_status($odata,$hidden_order_id);

						//------------------------------------------------
						$hidden_order_id=$this->input->post('hidden_order_id');
						$hidden_order_item_name=$this->input->post('hidden_order_item_name');
						//$approved_qty=$this->input->post('item_unit_qty_input');
						$order_row=$this->notification_model->get_wo_info($hidden_order_id);
						//$recipient=$this->notification_model->get_users_form_production();
						if($order_row['lead_id']!=0){ // staff id
							$notification_recipients=$order_row['wo_owner_id'];
							$created_by=$this->session->userdata('loginid');
							if($created_by==0){
								$owner='Admin';
								$notification_from="Admin";
							}else{ 
								$owner=$this->session->userdata('log_full_name');
								$notification_from=$this->session->userdata('loginid');
							}
							$notification_content="Your order no ".$order_row['orderform_number']."  reached dispatch";
							$notification_title="Order reaches accounts ";
							date_default_timezone_set('Asia/kolkata');
							$notification_time_stamp = date('d-m-Y H:i:s');
							$notificationData=array('notification_title'=>$notification_title,
							'notification_content'=>$notification_content,
							'notification_date'=>date('Y-m-d'),
							'notification_time_stamp'=>$notification_time_stamp,
							'notification_from'=>$notification_from,
							'notification_recipients'=>$notification_recipients,
							'created_by'=>$created_by
							);
							$this->notification_model->insert_notification($notificationData);
						}
						//------------------------------------------------
					}else{
						///if($orderform_type_id==2){
							$submitted_to_accounts=1;
							$accounts_status=1;
							$accounts_verified_by=1;
							$sqlApprove2="UPDATE rs_design_departments SET approved_dept_id='13',verify_status='1',verify_remark='$verify_remark',
verify_datetime='$verify_datetime',approved_by='$approved_by',approved_dep_name='Final QC',submitted_to_accounts='$submitted_to_accounts',accounts_status='$accounts_status',
accounts_verified_by='$accounts_verified_by',row_status='approved'  WHERE rs_design_id='$rs_design_id' ";
							$query = $this->db->query($sqlApprove2);
						//}
					}
					$this->common_model->insert_completion_data($completed_data);
					
				}else{ // fully rejected
					$sqlRejection="UPDATE rs_design_departments SET approved_dept_id='13',verify_status='-1',verify_remark='$verify_remark',verify_datetime='$verify_datetime',
rejected_department='final qc',rejected_by='$approved_by',row_status='rejected' WHERE rs_design_id='$rs_design_id' ";
					$query = $this->db->query($sqlRejection);
				}
				
				//------------------------------------------------
				$hidden_order_id=$this->input->post('hidden_order_id');
				$hidden_order_item_name=$this->input->post('hidden_order_item_name');
				//$approved_qty=$this->input->post('item_unit_qty_input');
				$order_row=$this->notification_model->get_wo_info($hidden_order_id);
				$recipient=$this->notification_model->get_users_form_production();
				if($recipient['ph_users']!=""){ // staff id
					$notification_recipients=$recipient['ph_users'];
					$created_by=$this->session->userdata('loginid');
					if($created_by==0){
						$owner='Admin';
						$notification_from="Admin";
					}else{ 
						$owner=$this->session->userdata('log_full_name');
						$notification_from=$this->session->userdata('loginid');
					}
					$notification_content=$rej_qty_notification." items ".$hidden_order_item_name." in  ".$order_row['orderform_number']." has been rejected ";
					$notification_title="Rejection in orders [Final QC]";
					date_default_timezone_set('Asia/kolkata');
					$notification_time_stamp = date('d-m-Y H:i:s');
					$notificationData=array('notification_title'=>$notification_title,
					'notification_content'=>$notification_content,
					'notification_date'=>date('Y-m-d'),
					'notification_time_stamp'=>$notification_time_stamp,
					'notification_from'=>$notification_from,
					'notification_recipients'=>$notification_recipients,
					'created_by'=>$created_by
					);
					$this->notification_model->insert_notification($notificationData);
				}
				//------------------------------------------------				
				
				$uuid=$this->schedule_model->get_schedule_uuid();
				$now = date('d-m-Y H:i:s');
				$schedule_is_completed=1;
				$schedule_id=$rsRowData['schedule_id'];
				$sqlSel2="SELECT * FROM `sh_schedules` WHERE schedule_id='$schedule_id' "; 
				$query2= $this->db->query($sqlSel2);					 
				$shRowData=$query2->row_array();
				
				$order_id=$shRowData['order_id'];
				$sqlSel3="SELECT * FROM `wo_work_orders` WHERE order_id='$order_id' "; 
				$query3= $this->db->query($sqlSel3);					 
				$orRowData=$query3->row_array();
				$save_data1 = array(
					'schedule_uuid' => $uuid['uid'],
					'parent_schedule_id' =>$shRowData['schedule_id'],
					'order_id' =>$shRowData['order_id'],
					'schedule_code' => 'RSH'.date('Ymdhis'),
					'schedule_unit_id' =>$shRowData['schedule_unit_id'],
					'schedule_c_by' => $this->session->userdata('loginid'),
					'schedule_c_date' =>date('Y-m-d'),
					'schedule_date' =>date('Y-m-d'),
					'schedule_end_date' =>date('Y-m-d'),
					'schedule_u_by' => $this->session->userdata('loginid'),
					'schedule_u_date' =>date('Y-m-d'),
					'schedule_time_stamp' => $now,
					'schedule_is_completed' =>$schedule_is_completed,
					'order_total_qty' =>1,
					'order_total_submitted_qty' =>$rej_qty,
					'order_balance_qty' => 0,
					'sh_order_json' => json_encode($new_item_array),
					'schedule_status' =>$schedule_is_completed,
					'schedule_order_info'=>$orRowData['orderform_number']
				);

				$sqlSel4="SELECT my_child_departments,my_child_departments2 FROM `department_master` WHERE department_id=13 "; 
				$query4= $this->db->query($sqlSel4);					 
				$deptRowData=$query4->row_array();
				$new_schedule_id=$this->schedule_model->save_schedule_data($save_data1);
				//echo $new_schedule_id;exit;
				
				$new_batch_number= date('YmdHis');
				if($reject_dep_id==4){
					$deptments=explode('-',$deptRowData['my_child_departments']);
					foreach($deptments as $DP){
						$insert= array('schedule_id'=>$new_schedule_id,'department_ids'=>$DP,'department_schedule_date' =>date('Y-m-d'),'department_schedule_status' => 0,'scheduled_order_info' => json_encode($new_item_array),'unit_id'=>$shRowData['schedule_unit_id'],'order_id'=>$shRowData['order_id'],'batch_number'=>$new_batch_number,'is_re_scheduled'=>$rsRowData['schedule_id'],'total_order_items'=>1);

						$this->schedule_model->save_reschedule_data($insert);
					}
					$ins_rej=array('schedule_id'=>$shRowData['schedule_id'],'order_id'=>$shRowData['order_id'],'batch_number'=>$batch_number,'schedule_department_id'=>$rsRowData['schedule_department_id'],'approved_to_departments'=>'0','rejected_to_departments'=>'4,5,6,11,12,7,8,9,10,13','summary_id'=>$summary_id,'rejected_qty'=>$rej_qty,
'approved_qty'=>$approvedQty,'rejected_remark'=>$verify_remark,'rejected_from_departments'=>'Final QC','rejected_by'=>$this->session->userdata('loginid'),'rejected_datetime'=>$verify_datetime);
					//print_r($ins_rej);
					$this->schedule_model->save_rejection_data($ins_rej);
				}
				//exit;
				if($reject_dep_id==8){
					$deptments=explode('-',$deptRowData['my_child_departments2']);
						foreach($deptments as $DP){
							$insert= array('schedule_id'=>$new_schedule_id,'department_ids'=>$DP,'department_schedule_date' =>date('Y-m-d'),'department_schedule_status' => 0,'scheduled_order_info' => json_encode($new_item_array),'unit_id'=>$shRowData['schedule_unit_id'],'order_id'=>$shRowData['order_id'],'batch_number'=>$new_batch_number,'is_re_scheduled'=>$rsRowData['schedule_id'],'total_order_items'=>1);
							$this->schedule_model->save_reschedule_data($insert);
						}
						$ins_rej=array('schedule_id'=>$shRowData['schedule_id'],'order_id'=>$shRowData['order_id'],'batch_number'=>$batch_number,'schedule_department_id'=>$rsRowData['schedule_department_id'],'approved_to_departments'=>'','rejected_to_departments'=>'8,9,10,13','summary_id'=>$summary_id,'rejected_qty'=>$rej_qty,
'approved_qty'=>$approvedQty,'rejected_remark'=>$verify_remark,'rejected_from_departments'=>'Final QC','rejected_by'=>$this->session->userdata('loginid'),'rejected_datetime'=>$verify_datetime);
						$this->schedule_model->save_rejection_data($ins_rej);
				}
				$this->session->set_flashdata('success','Successfully updated the order status.');
				exit;

			}
			if($verify_status==1){
				
				$orderform_type_id=addslashes($this->input->post('orderform_type_id'));


				if($orderform_type_id==1){
					//die("ooooff");
					$production_completed_status=1;
					$accounts_completed_status=0;
					$sql321="UPDATE rs_design_departments SET approved_dept_id='13',verify_status='$verify_status',verify_remark='$verify_remark',verify_datetime='$verify_datetime',
approved_by='$approved_by',approved_dep_name='Final QC',submitted_to_accounts='1',accounts_status='0',accounts_verified_by='0',row_status='approved' WHERE rs_design_id='$rs_design_id' ";
					//die("ooooff");
					$query = $this->db->query($sql321);
				}else{
					//die("oooonnn");
					$production_completed_status=1;
					$accounts_completed_status=1;
					$sql4321="UPDATE rs_design_departments SET approved_dept_id='13',verify_status='$verify_status',verify_remark='$verify_remark',verify_datetime='$verify_datetime',
approved_by='$approved_by',approved_dep_name='Final QC',submitted_to_accounts='1',accounts_status='1',accounts_verified_by='1',row_status='approved' WHERE rs_design_id='$rs_design_id' ";
					$query = $this->db->query($sql4321);
				}
				
				$completed_data = array('order_id'=>$hidden_order_id,'schedule_id'=>$hidden_schedule_id,'schedule_dept_id'=>$hidden_schedule_department_id,'response_id'=>$hidden_rs_design_id,'summary_id'=>$hidden_summary_id,'qc_approved_qty'=>$item_unit_qty_input,'qc_approved_date'=>$verify_datetime);
				$completedWoRow=$this->common_model->check_wo_is_completed($hidden_order_id);



				if($completedWoRow==""){
					$odata=array('production_completed_status'=>$production_completed_status,'accounts_completed_status'=>$accounts_completed_status,'last_rs_design_id'=>$hidden_rs_design_id);
					$this->common_model->update_wo_completion_status($odata,$hidden_order_id);
					//------------------------------------------------
					$hidden_order_id=$this->input->post('hidden_order_id');
					$hidden_order_item_name=$this->input->post('hidden_order_item_name');
					//$approved_qty=$this->input->post('item_unit_qty_input');
					$order_row=$this->notification_model->get_wo_info($hidden_order_id);
					//$recipient=$this->notification_model->get_users_form_production();

					/* Orginal commented by vivek */
					/*
					if($order_row['lead_id']!=0){ // staff id
						$notification_recipients=$order_row['wo_owner_id'];
						$created_by=$this->session->userdata('loginid');
						if($created_by==0){
							$owner='Admin';
							$notification_from="Admin";
						}else{ 
							$owner=$this->session->userdata('log_full_name');
							$notification_from=$this->session->userdata('loginid');
						}
						$notification_content="Your order no ".$order_row['orderform_number']."  reached dispatch";
						$notification_title="Order reaches accounts ";
						date_default_timezone_set('Asia/kolkata');
						$notification_time_stamp = date('d-m-Y H:i:s');
						$notificationData=array('notification_title'=>$notification_title,
						'notification_content'=>$notification_content,
						'notification_date'=>date('Y-m-d'),
						'notification_time_stamp'=>$notification_time_stamp,
						'notification_from'=>$notification_from,
						'notification_recipients'=>$notification_recipients,
						'created_by'=>$created_by
						);
						$this->notification_model->insert_notification($notificationData);
						}  
					*/

						/* End of vivek */

					if($order_row['lead_id']!=0){ // staff id
						$notification_recipients=$order_row['wo_owner_id'];
						$created_by=$this->session->userdata('loginid');
						if($created_by==0){
							$owner='Admin';
							$notification_from="Admin";
						}else{ 
							$owner=$this->session->userdata('log_full_name');
							$notification_from=$this->session->userdata('loginid');
						}
						$notification_content="Your order no ".$order_row['orderform_number']."  reached Accounts";
						$notification_title="Order reaches accounts ";
						date_default_timezone_set('Asia/kolkata');
						$notification_time_stamp = date('d-m-Y H:i:s');
						$notificationData=array('notification_title'=>$notification_title,
						'notification_content'=>$notification_content,
						'notification_date'=>date('Y-m-d'),
						'notification_time_stamp'=>$notification_time_stamp,
						'notification_from'=>$notification_from,
						'notification_recipients'=>$notification_recipients,
						'created_by'=>$created_by
						);
						$this->notification_model->insert_notification($notificationData);
						}  



					//------------------------------------------------

					
				}else{
					$odata=array('last_rs_design_id'=>$hidden_rs_design_id);
					$this->common_model->update_wo_completion_status($odata,$hidden_order_id);
					//if($orderform_type_id==2){
						$sql321="UPDATE rs_design_departments SET approved_dept_id='13',verify_status='$verify_status',verify_remark='$verify_remark',
verify_datetime='$verify_datetime',approved_by='$approved_by',approved_dep_name='Final QC',submitted_to_accounts='1',accounts_status='1',accounts_verified_by='1',
row_status='approved' WHERE rs_design_id='$rs_design_id' ";
						$query = $this->db->query($sql321);
					//}
					
				}
				$this->common_model->insert_completion_data($completed_data);
				$this->session->set_flashdata('success','Successfully updated the order status.');
				exit;
			}

		}
	}

	public function final_qc_list_completed(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_final_qc_works_completed($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$recordsListCount=0;
		foreach ($records['data']  as $row) 
		{
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
					$i++;
					$up="";
					$mup="";
					$acc="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']; }
					$re="";
					if($row['is_re_scheduled']>0){
						$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
					}else{
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					}
					if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
					//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
					//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],13);
					if(isset($any_rejection)){
						$rejection_count++;
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved<br/>Submitted To Accounts</span>';
								if($lastUpdateRow['accounts_status']==1){
									//$acc='<br><span class="badge badge-outline-success mt-1" >Account Dept:<br>Approved </span>';
								}else{
									//$acc='<br><span class="badge badge-outline-danger mt-1" >Account Dept:<br>Not Approved</span>';
								}
							}
							if($lastUpdateRow['verify_status']==-1){
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
								$rejection_count++;
							}
							if($lastUpdateRow['verify_status']==0){
								$not_submitted_count++;
								//$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$not_submitted_count++;
							//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
						}
					}
					//$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					//--------------------------------------------------
					
					}
				}
				//-------------------------------------------------------
					if($approved_count>0){
					$recordsListCount++;
					$st='<td>
					<div class="badge  badge-primary" title="Orders Not Submitted To Dispatch/Accounts"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Orders Submitted To  To Dispatch/Accounts"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
					<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
					</td>';
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success w-100 text-info">'.$wo_product_info.'</label>',
						$st,
						$option
					);
					}
				//-------------------------------------------------------
			}
		}
		$records['data']=$data;
		//$records['recordsTotal']=$recordsListCount;
		//$records['recordsFiltered']=$recordsListCount;
		echo json_encode($records);	

	}
	public function final_qc_list_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_final_qc_works_pending($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$recordsListCount=0;
		foreach ($records['data']  as $row) 
		{
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
					$i++;
					$up="";
					$mup="";
					$acc="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']; }
					$re="";
					if($row['is_re_scheduled']>0){
						$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
					}else{
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					}
					if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
					//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
					//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],13);
					if(isset($any_rejection)){
						$rejection_count++;
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved<br/>Submitted To Accounts</span>';
								if($lastUpdateRow['accounts_status']==1){
									//$acc='<br><span class="badge badge-outline-success mt-1" >Account Dept:<br>Approved </span>';
								}else{
									//$acc='<br><span class="badge badge-outline-danger mt-1" >Account Dept:<br>Not Approved</span>';
								}
							}
							if($lastUpdateRow['verify_status']==-1){
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
								$rejection_count++;
							}
							if($lastUpdateRow['verify_status']==0){
								$not_submitted_count++;
								//$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$not_submitted_count++;
							//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
						}
					}
					//$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					//--------------------------------------------------
					
					}
				}
				//-------------------------------------------------------
					if($not_submitted_count>0){
					$recordsListCount++;
					$st='<td>
					<div class="badge  badge-primary" title="Orders Not Submitted To Dispatch/Accounts"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Orders Submitted To  To Dispatch/Accounts"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
					<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
					</td>';
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success w-100 text-info">'.$wo_product_info.'</label>',
						$st,
						$option
					);
					}
				//-------------------------------------------------------
			}
		}
		$records['data']=$data;
		//$records['recordsTotal']=$recordsListCount;
		//$records['recordsFiltered']=$recordsListCount;
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
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
					$i++;
					$up="";
					$mup="";
					$acc="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']; }
					$re="";
					if($row['is_re_scheduled']>0){
						$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
					}else{
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					}
					if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
					//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
					//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],13);
					if(isset($any_rejection)){
						$rejection_count++;
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved<br/>Submitted To Accounts</span>';
								if($lastUpdateRow['accounts_status']==1){
									//$acc='<br><span class="badge badge-outline-success mt-1" >Account Dept:<br>Approved </span>';
								}else{
									//$acc='<br><span class="badge badge-outline-danger mt-1" >Account Dept:<br>Not Approved</span>';
								}
							}
							if($lastUpdateRow['verify_status']==-1){
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
								$rejection_count++;
							}
							if($lastUpdateRow['verify_status']==0){
								$not_submitted_count++;
								//$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$not_submitted_count++;
							//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
						}
					}
					//$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					//--------------------------------------------------
					
					}
				}
				//-------------------------------------------------------
					$st='<td>
					<div class="badge  badge-primary" title="Orders Not Submitted To Dispatch/Accounts"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Orders Submitted To  To Dispatch/Accounts"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
					<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
					</td>';
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success w-100 text-info">'.$wo_product_info.'</label>',
						$st,
						$option
					);
				//-------------------------------------------------------
			}
		}
		$records['data']=$data;
		echo json_encode($records);	

	}
	public function final_qc_list_all(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->qc_model->get_design_final_qc_works_all($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$rejection_count=0;
				$approved_count=0;
				$submitted_count=0;
				$not_submitted_count=0;
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
					$i++;
					$up="";
					$mup="";
					$acc="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']; }
					$re="";
					if($row['is_re_scheduled']>0){
						$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
					}else{
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					}
					if($row['lead_id']==0){$sales_handler='Admin';}else{$sales_handler=$row['sales_handler'];}
					//$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
					//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],13);
					if(isset($any_rejection)){
						$rejection_count++;
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved<br/>Submitted To Accounts</span>';
								if($lastUpdateRow['accounts_status']==1){
									//$acc='<br><span class="badge badge-outline-success mt-1" >Account Dept:<br>Approved </span>';
								}else{
									//$acc='<br><span class="badge badge-outline-danger mt-1" >Account Dept:<br>Not Approved</span>';
								}
							}
							if($lastUpdateRow['verify_status']==-1){
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
								$rejection_count++;
							}
							if($lastUpdateRow['verify_status']==0){
								$not_submitted_count++;
								//$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}
						}else{
							$not_submitted_count++;
							//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
						}
					}
					//$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					//--------------------------------------------------
					
					}
				}
				//-------------------------------------------------------
					$st='<td>
					<div class="badge  badge-primary" title="Orders Not Submitted To Dispatch/Accounts"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Orders Submitted To  To Dispatch/Accounts"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
					<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>
					</td>';
					$data[]= array(
						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span>'.$re.'</td>',
						'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
						$sales_handler,
						'<label class="badge badge-outline-success w-100 text-info">'.$wo_product_info.'</label>',
						$st,
						$option
					);
				//-------------------------------------------------------
			}
		}
		$records['data']=$data;
		echo json_encode($records);	

	}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------	
	public function removeupload(){
		$qc_image_id=$_POST['id'];
		$sel="SELECT image_name FROM sh_qc_images WHERE qc_image_id='$qc_image_id' ";
		$query2 = $this->db->query($sel);					 
		$imgRow=$query2->row_array();
		$image_name=$imgRow['image_name'];
		$DE="DELETE FROM sh_qc_images WHERE qc_image_id='$qc_image_id' ";
		$query= $this->db->query($DE);
		$path= $_SERVER['DOCUMENT_ROOT'].'/uploads/finalqc/'.$image_name;
		if(is_file($path)){
			unlink($path);
			//echo 'File '.$filename.' has been deleted';
		}
		$msg='<div class="alert alert-danger mt-2" style="width:100%;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			Images removed successfully!!!
			</div>';
			echo 1;
	}
	public function upload(){
		$output = '';  
		$order_id=$_POST['order_id'];
		$order_item_id=$_POST['order_item_id'];
		if(is_array($_FILES))  {  
			foreach($_FILES['images']['name'] as $name => $value){  
					$file_name = explode(".", $_FILES['images']['name'][$name]);  
					$allowed_extension = array("jpg", "jpeg", "png", "gif");  
					//if(in_array($file_name[1], $allowed_extension))  {  
						//$new_name =$order_item_id."_".rand() . '.'. $file_name[1];  
						$new_name =$order_item_id."_".rand(). '_'.$_FILES['images']['name'][$name]; 
						$sourcePath = $_FILES["images"]["tmp_name"][$name];  
						$targetPath = "uploads/finalqc/".$new_name;  

						move_uploaded_file($sourcePath, $targetPath); 
						date_default_timezone_set('Asia/kolkata');
						$added_date = date('d-m-Y H:i:s');
						$data = array(
							'order_id' => $order_id,
							'order_item_id'=>$order_item_id,
							'image_name'=> $new_name,
							'added_by'=>$this->session->userdata('loginid'),
							'added_date'=>$added_date
						);
						$rs = $this->qc_model->save_qc_images($data); 
					//} 
			} 
			$images = $this->qc_model->get_qc_images($order_id,$order_item_id);  
			//$images = glob("uploads/finalqc/*.*");  
			foreach($images as $image)  
			{  
				$output .= '<a href="'.base_url()."uploads/finalqc/".$image['image_name'].'" target="_blank" class="m-1"><img  src="' .base_url()."uploads/finalqc/".$image['image_name'].'"  width="100px" height="100px" style="margin-top:15px; padding:8px; border:1px solid #ccc;" /></a>';  
			}  
			$msg='<div class="alert alert-success mt-2" style="width:100%;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			Images saved successfully!!!
			</div>';
			echo $msg; 
		}  
	}
	public function upload_image(){
		$this->load->view('qc/upload_image');
	}
	

	public function final_qc_list_completed___(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		//echo $staffRow['department_id'];

		$records = $this->qc_model->get_design_final_qc_works_completed($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		

		foreach ($records['data']  as $row) 

		{

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				$comp=0;

				foreach($array1 as $key1 => $value1){

					if($value1['item_unit_qty_input']!=0){

					$i++;

					$up="";

					$mup="";

					$acc="";
					$uploadImg="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					

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

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected : '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';

					}else{

						if(isset($lastUpdateRow)){

							$comp=1;

							if($lastUpdateRow['verify_status']==1){
								
								$uploadImg='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#fqcImage"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-primary m-1" style="cursor: pointer;"><i class="fa fa-image" ></i></label></a>';

								//$st='<span class="badge badge-outline-success w-100" >Approved<br/>Submitted To Accounts</span>';
								if($lastUpdateRow['accounts_status']==1){
									$acc='<br><span class="badge badge-outline-success mt-1 w-100" >Account Dept:<br>Approved </span>';
								}else{
									$acc='<br><span class="badge badge-outline-danger mt-1 w-100" >Account Dept:<br>Not Approved</span>';
								}

							}

							if($lastUpdateRow['verify_status']==-1){
								$comp=0;
								$st='<span class="badge badge-outline-danger" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
								$comp=0;
							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';
							}

						}else{

							$comp=0;

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

						}

					}

					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';

					//--------------------------------------------------

					if($comp==1){

					$data[]= array(

						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st.$mup.$acc,

						$uploadImg.$info.$up.$option

					);

					}

					}

				}

			}

			

		}

		$records['data']=$data;

		echo json_encode($records);	

	}
	public function final_qc_list_pending___(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		//echo $staffRow['department_id'];

		$records = $this->qc_model->get_design_final_qc_works_pending($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		

		foreach ($records['data']  as $row) 

		{

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				$pend=0;

				foreach($array1 as $key1 => $value1){

					if($value1['item_unit_qty_input']!=0){

					$i++;

					$up="";

					$mup="";

					$acc="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					

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

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected : '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

								$st='<span class="badge badge-outline-success" >Approved<br/>Submitted To Accounts</span>';

								if($lastUpdateRow['accounts_status']==1){

									$acc='<br><span class="badge badge-outline-success mt-1" >Account Dept:<br>Approved </span>';

								}else{

									$acc='<br><span class="badge badge-outline-danger mt-1" >Account Dept:<br>Not Approved</span>';

								}

							}

							if($lastUpdateRow['verify_status']==-1){

							$st='<span class="badge badge-outline-danger" >Rejected</span>';

							}

							if($lastUpdateRow['verify_status']==0){

								$pend=1;

							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';

							}

						}else{

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

						}

					}

					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';

					//--------------------------------------------------

					if($pend==1){

					$data[]= array(

						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st.$mup.$acc,

						$info.$up.$option

					);

					}

					}

				}

			}

			

		}

		$records['data']=$data;

		echo json_encode($records);	

	}
	public function final_qc_list_active____(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		//echo $staffRow['department_id'];

		$records = $this->qc_model->get_design_final_qc_works($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		

		foreach ($records['data']  as $row) 

		{

			

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				foreach($array1 as $key1 => $value1){

					if($value1['item_unit_qty_input']!=0){

					$i++;

					$up="";

					$mup="";

					$acc="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					

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

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){


						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected : '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

								$st='<span class="badge badge-outline-success" >Approved<br/>Submitted To Accounts</span>';

								if($lastUpdateRow['accounts_status']==1){

									$acc='<br><span class="badge badge-outline-success mt-1" >Account Dept:<br>Approved </span>';

								}else{

									$acc='<br><span class="badge badge-outline-danger mt-1" >Account Dept:<br>Not Approved</span>';

								}

							}

							if($lastUpdateRow['verify_status']==-1){

							$st='<span class="badge badge-outline-danger" >Rejected</span>';

							}

							if($lastUpdateRow['verify_status']==0){

							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';

							}

						}else{

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

						}

					}

					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';

					//--------------------------------------------------

					

					$data[]= array(

						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st.$mup.$acc,

						$info.$up.$option

					);

					}

				}

			}

			

		}

		$records['data']=$data;

		echo json_encode($records);	

	}
	public function final_qc_approve_denay(){

		$this->load->view('qc/final_qc_approve_denay');

	}
	
}
