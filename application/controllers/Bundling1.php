<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bundling extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('bundling_model', 'bundling_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('common_model', 'common_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	public function save_status(){
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
			$rej_qty=$this->input->post('rej_qty');
			$batch_number=$this->input->post('batch_number');
			//echo $rs_design_id;exit;
			$qc_name='bundling';
			$approved_by=$this->session->userdata('loginid');
			$rejected_by=$this->session->userdata('loginid');
			if($verify_status==-1){
				$rej_qty=$this->input->post('rej_qty');
				$item_unit_qty_input=$this->input->post('item_unit_qty_input');
				$approvedQty=$item_unit_qty_input-$rej_qty;
				$sqlSel="Select * from rs_design_departments where rs_design_id='$rs_design_id'"; 
				$query = $this->db->query($sqlSel);					 
				$rsRowData=$query->row_array();
				//echo $rsRowData['summary_item_id'];
				if($approvedQty>0){
					$submitted_item=$rsRowData['submitted_item'];
					$item_unit_qty_input=0;
					$submitted_item_array=json_decode($submitted_item,true); // from db
					$new_item_array=array();
					foreach($submitted_item_array as $postkey=>$postvalue){
						//echo $submitted_item_array[$postkey]['summary_id'];
						if($rsRowData['summary_item_id']==$submitted_item_array[$postkey]['summary_id']){
							//$item_unit_qty_input=$submitted_item_array[$postkey]['item_unit_qty_input'];
							$submitted_item_array[$postkey]['item_unit_qty_input']=$approvedQty;
							$submitted_item_array[$postkey]['item_rejected_qty']=$rej_qty;

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
							$item_re_schedule_id =0;
							$item_unit_qty_input =$rej_qty;
						}
					}
					$new_item_array= array(
					'summary_id' =>$summary_id,
					'product_type' =>$product_type,
					'collar_type' =>$collar_type,
					'sleeve_type' =>$sleeve_type,
					'fabric_type' =>$fabric_type,
					'addon_name' =>$addon_name,
					'img_back' =>$img_back,
					'img_front' =>$img_front,
					'img_front' =>$img_front,
					'orderno' =>$orderno,
					'priority_name' =>$priority_name,
					'priority_color_code' =>$priority_color_code,
					'item_order_sec' =>$item_order_sec,
					'item_order_total_sec' =>$item_order_total_sec,
					'item_order_capacity' =>$item_order_capacity,
					'item_order_qty' =>$item_order_qty,
					'online_ref_number' =>$online_ref_number,
					'item_position' =>$item_position,
					'item_rejected_qty' =>0,
					'item_re_schedule_id' =>1,
					'item_unit_qty_input' =>$item_unit_qty_input,
					);
					//json_encode($new_item_array));
				}
				$submitted_item_updated=json_encode($submitted_item_array);
				$sqlApproved="UPDATE rs_design_departments SET approved_dept_id='12',verify_status='$verify_status',verify_remark='$verify_remark',verify_datetime='$verify_datetime',approved_dep_name='$qc_name',approved_by='$approved_by',row_status='approved',submitted_item='$submitted_item_updated' WHERE rs_design_id='$rs_design_id' ";
				$query = $this->db->query($sqlApproved);
				//-------------------- new schedule---------
					$uuid=$this->schedule_model->get_schedule_uuid();
					$now = date('d-m-Y H:i:s');
					$schedule_is_completed=1;
					$schedule_id=$rsRowData['schedule_id'];
					$sqlSel2="SELECT * FROM `sh_schedules` WHERE schedule_id='$schedule_id' "; 
					$query2= $this->db->query($sqlSel2);					 
					$shRowData=$query2->row_array();
					//print_r($shRowData);
					
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
						//print_r($orRowData);
						$sqlSel4="SELECT my_child_departments FROM `department_master` WHERE department_id=12 "; 
						$query4= $this->db->query($sqlSel4);					 
						$deptRowData=$query4->row_array();
						//print_r($deptRowData);
						$new_schedule_id=$this->schedule_model->save_schedule_data($save_data1);
						$new_batch_number= date('YmdHis');
						$deptments=explode('-',$deptRowData['my_child_departments']);
						foreach($deptments as $DP){
							//echo $DP."<br/>";
							$insert= array(
								'schedule_id'=>$new_schedule_id,
								'department_ids'=>$DP,
								'department_schedule_date' =>date('Y-m-d'),
								'department_schedule_status' => 0,
								'scheduled_order_info' => json_encode($new_item_array),
								'unit_id'=>$shRowData['schedule_unit_id'],
								'order_id'=>$shRowData['order_id'],
								'batch_number'=>$new_batch_number,
								'is_re_scheduled'=>$rsRowData['schedule_department_id']

							);
							$this->schedule_model->save_reschedule_data($insert);
							//print_r($insert);
						}
					
						$up2="UPDATE sh_schedule_departments SET is_re_scheduled='-1' WHERE schedule_department_id='$schedule_department_id' ";
						$query = $this->db->query($up2);
				//------------------------------------------

			}else{
				$sql="UPDATE
					rs_design_departments 
				SET 
					approved_dept_id='12',
					verify_status='$verify_status',
					verify_remark='$verify_remark',
					verify_datetime='$verify_datetime',
					approved_dep_name='$qc_name',
					approved_by='$approved_by',
					row_status='approved'
				WHERE
					rs_design_id='$rs_design_id' ";
				$query = $this->db->query($sql);
			}
			$this->session->set_flashdata('success','Successfull updated the order status.');	
		}

	}
	public function list_competed(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->bundling_model->get_completed_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$recordsListCount=0;
		$scode="";
		foreach ($records['data']  as $row) 
		{
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
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
					//$scode=" S[".$i."/1]";
					$up="";
					$mup="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/completed" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }
					$re="";
					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}
					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
						$rejection_count++;
						//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';
							}
							if($lastUpdateRow['verify_status']==-1){
								$rejection_count++;
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
								$submitted_count++;
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
			}
			
			//------------------------------------------------------------------------------
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Submitted To Bundling QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted To Bundling QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Approved By Bundling QC"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>'.$re.'
			</td>';
			$approved=$i-$approved_count;
			if($approved==0){
			$recordsListCount++;
				$data[]= array(
				'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
				'<td><span class="badge badge-success" >'.$row['orderform_number'].' ['.$i.']'.$scode.'</span></td>',
				'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
				date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
				$sales_handler,
				'<label class="badge badge-outline-success">'.$wo_product_info.'</label>',
				$st,
				$option
				);
			}
			//------------------------------------------------------------------------------
		}
		$records['data']=$data;
		$records['recordsTotal']=$recordsListCount;
		$records['recordsFiltered']=$recordsListCount;
		echo json_encode($records);	

	}
	public function list_pending(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->bundling_model->get_pending_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$recordsListCount=0;
		$scode="";
		foreach ($records['data']  as $row) 
		{
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
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
					//$scode=" S[".$i."/1]";
					$up="";
					$mup="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/pending" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }
					$re="";
					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}
					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
						$rejection_count++;
						//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';
							}
							if($lastUpdateRow['verify_status']==-1){
								$rejection_count++;
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
								$submitted_count++;
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
			}
			
			//------------------------------------------------------------------------------
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Submitted To Bundling QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted To Bundling QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Approved By Bundling QC"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>'.$re.'
			</td>';
			if($not_submitted_count>0 || $submitted_count>=0){
			$recordsListCount++;
				$data[]= array(
				'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
				'<td><span class="badge badge-success" >'.$row['orderform_number'].' ['.$i.']'.$scode.'</span></td>',
				'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
				date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
				$sales_handler,
				'<label class="badge badge-outline-success">'.$wo_product_info.'</label>',
				$st,
				$option
				);
			}
			//------------------------------------------------------------------------------
		}
		$records['data']=$data;
		$records['recordsTotal']=$recordsListCount;
		$records['recordsFiltered']=$recordsListCount;
		echo json_encode($records);	

	}
	public function list_active(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->bundling_model->get_active_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$recordsListCount=0;
		$scode="";
		foreach ($records['data']  as $row) 
		{
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
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
					//$scode=" S[".$i."/1]";
					$up="";
					$mup="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/active" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }
					$re="";
					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}
					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
						$rejection_count++;
						//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';
							}
							if($lastUpdateRow['verify_status']==-1){
								$rejection_count++;
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
								$submitted_count++;
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
			}
			
			//------------------------------------------------------------------------------
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Submitted To Bundling QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted To Bundling QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Approved By Bundling QC"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>'.$re.'
			</td>';
			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ['.$i.']'.$scode.'</span></td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			'<label class="badge badge-outline-success">'.$wo_product_info.'</label>',
			$st,
			$option
			);
			//------------------------------------------------------------------------------
		}
		$records['data']=$data;
		echo json_encode($records);	

	}
	public function list_all(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->bundling_model->get_all_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		$recordsListCount=0;
		$scode="";
		foreach ($records['data']  as $row) 
		{
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
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
					//$scode=" S[".$i."/1]";
					$up="";
					$mup="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/all" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }
					$re="";
					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}
					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }
					//-------------------------------------------------
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');
					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					if(isset($any_rejection)){
						$rejection_count++;
						//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$approved_count++;
								//$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';
							}
							if($lastUpdateRow['verify_status']==-1){
								$rejection_count++;
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
								$submitted_count++;
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
			}
			
			//------------------------------------------------------------------------------
			$st='<td>
			<div class="badge  badge-primary" title="Order Not Submitted To Bundling QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
			<div class="badge  badge-warning" title="Order Submitted To Bundling QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
			<div class="badge  badge-success mt-1" title="Order Approved By Bundling QC"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> '.$rejection_count.'</div>'.$re.'
			</td>';
			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' ['.$i.']'.$scode.'</span></td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			'<label class="badge badge-outline-success">'.$wo_product_info.'</label>',
			$st,
			$option
			);
			//------------------------------------------------------------------------------
		}
		$records['data']=$data;
		echo json_encode($records);	

	}
//**************************************************************************************************************************************************************************************
	
	
//------------------------------------------------------------------------------------------------------------------------------------//

	public function save_status123(){
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
			$batch_number=$this->input->post('batch_number');
			//echo $rs_design_id;exit;
			$qc_name='bundling';
			$approved_by=$this->session->userdata('loginid');
			$rejected_by=$this->session->userdata('loginid');
			if($verify_status==-1){
				if($reject_dep_id==4){
					$deptmts=$this->bundling_model->get_all_department_for_rejection_by_batch_no($rej_schedule_id,$rej_unit_id,$batch_number);
					//$deptmts=$this->bundling_model->get_all_department_for_rejection_by_batch_no($rej_schedule_id,$rej_unit_id,$batch_number);
					if($deptmts){
						foreach($deptmts as $DP){
							$schedule_department_id=$DP['schedule_department_id'];
							$order_id=$DP['order_id'];
							$schedule_id=$DP['schedule_id'];
							$unit_id=$DP['unit_id'];
							$rej_items=$DP['rej_items'];
							$new_rej=$rej_items.",".$rej_summary_item_id;
							$up="UPDATE sh_schedule_departments SET rej_items='$new_rej' WHERE schedule_department_id='$schedule_department_id' ";
							//echo $up;
							$query1= $this->db->query($up);	
					$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id, `schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$rejected_by','12','$verify_datetime','0','$unit_id');";
							$query = $this->db->query($ins);	
						}
						$sql="UPDATE
							rs_design_departments 
						SET 
							approved_dept_id='12',
							verify_status='$verify_status',
							verify_remark='$verify_remark',
							verify_datetime='$verify_datetime',
							rejected_department='Bundling QC',
							rejected_by='$approved_by',
							row_status='rejected'
						WHERE
							rs_design_id='$rs_design_id' ";
						$query = $this->db->query($sql);
					}
			//die("Okkk");
				}
			}else{
				$sql="UPDATE
					rs_design_departments 
				SET 
					approved_dept_id='12',
					verify_status='$verify_status',
					verify_remark='$verify_remark',
					verify_datetime='$verify_datetime',
					approved_dep_name='$qc_name',
					approved_by='$approved_by',
					row_status='approved'
				WHERE
					rs_design_id='$rs_design_id' ";
				$query = $this->db->query($sql);
			}
			$this->session->set_flashdata('success','Successfull updated the order status.');	
		}

	}
	//________________
	public function approve_denay(){
		$this->load->view('bundling/bundling_approval_or_deny');
	}
	public function order_view($uuid,$sdid,$rs_design_id){
	//echo $sdid;
		$data['title']="Order Submitted | View";
		$data['title_head']="Order Submitted | View";
		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$data['staffRow']=$staffRow;
		if($staffRow['department_id']==12){
			$data['request_row']=$this->bundling_model->get_bundling_request_row($rs_design_id);
			$data['view']='bundling/bundling_order_view_single';
			$this->load->view('layout',$data);
		}
	}
	public function updates_order_status(){
		$loginid=$this->session->userdata('loginid');
		$data['staffRow']=$this->myaccount_model->get_staff_profile_data($loginid);
		if($_POST['act']=="up"){
			$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);
			$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['sdid']);
			$this->load->view('fusing/fusing_order_updates',$data);
		}else{
			$this->load->view('fusing/fusing_order_updates_list');
		}
	}
}