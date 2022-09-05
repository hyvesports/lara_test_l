<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Bundling extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('auth_model', 'auth_model');

		$this->load->model('myaccount_model', 'myaccount_model');

		$this->load->model('qc_model', 'qc_model');

		$this->load->model('bundling_model', 'bundling_model');

		$this->load->model('common_model', 'common_model');

		$this->load->library('datatable');

		if(!$this->session->has_userdata('loginid')){

			redirect('auth/login');

		}

		

	}

	//list_competed

	public function list_competed(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$records = $this->bundling_model->get_completed_works($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		foreach ($records['data']  as $row) 

		{

			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				$request=0;

				foreach($array1 as $key1 => $value1){

					if($value1['item_unit_qty_input']!=0){

					$i++;

					$up="";

					$mup="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					$wo_product_info="";

					if($wo_product_info!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }

					$re="";

					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}

					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }

					

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

								$request=1;

							$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';

							}

							if($lastUpdateRow['verify_status']==-1){

								$request=0;

							$st='<span class="badge badge-outline-danger" >Rejected</span>';

							}

							if($lastUpdateRow['verify_status']==0){

								$request=0;

							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';

							}

						}else{

							$request=0;

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

						}

					}

					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';

					//--------------------------------------------------

					if($request==1){

					$data[]= array(

						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st,

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

	public function list_pending(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$records = $this->bundling_model->get_pending_works($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		foreach ($records['data']  as $row) 

		{

			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				$request=0;

				foreach($array1 as $key1 => $value1){
					$i++;
				if($row['summary_item_id']==$value1['summary_id']){
					if($value1['item_unit_qty_input']!=0){

					

					$up="";

					$mup="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					$wo_product_info="";

					if($wo_product_info!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }

					$re="";

					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}

					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }

					

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

							$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';

							}

							if($lastUpdateRow['verify_status']==-1){

							$st='<span class="badge badge-outline-danger" >Rejected</span>';

							}

							if($lastUpdateRow['verify_status']==0){

								$request=1;

							$st='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$lastUpdateRow['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';

							}

						}else{

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

						}

					}

					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';

					//--------------------------------------------------

					if($request==1){

					$data[]= array(

						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st,

						$info.$up.$option

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

	

	

	public function list_all(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$records = $this->bundling_model->get_all_works($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		foreach ($records['data']  as $row) 

		{

			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				foreach($array1 as $key1 => $value1){

					if($value1['item_unit_qty_input']!=0){

					$i++;

					$up="";

					$mup="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					$wo_product_info="";

					if($wo_product_info!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }

					$re="";

					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}

					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }

					

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

							$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';

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

						$st,

						$info.$up.$option

					);

					}

				}

			}

		}

		$records['data']=$data;

		echo json_encode($records);	

	}

	public function list_active(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$records = $this->bundling_model->get_active_works($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		

		foreach ($records['data']  as $row) 

		{

			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				foreach($array1 as $key1 => $value1){

					if($value1['item_unit_qty_input']!=0){

					$i++;

					$up="";

					$mup="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					

					$wo_product_info="";

					if($wo_product_info!=""){ $wo_product_info=$row['wo_product_info']."</br>"; }

					$re="";

					if($row['is_re_scheduled']>0){ $re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';}

					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }

					

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' <br/>Rejected</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

							$st='<span class="badge badge-outline-success" >Approved <br/>Submitted To Stitching </span>';

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

						$st,

						$info.$up.$option

					);

					}

				}

			}

		}

		$records['data']=$data;

		echo json_encode($records);	

	}

	



	

//------------------------------------------------------------------------------------------------------------------------------------//

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

	public function list_active_old(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		

		

		$records = $this->bundling_model->get_active_works($staffRow['department_id'],$staffRow['unit_managed']);

		$data = array();

		

		foreach ($records['data']  as $row) 

		{

			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				foreach($array1 as $key1 => $value1){

					$i++;

					$up="";

					$mup="";

					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					

					if($row['lead_id']==0){

						$sales_handler='Admin';

					}else{

						$sales_handler=$row['sales_handler'];

					}

					

					//-------------------------------------------------

					if(isset($value1['online_ref_number'])){

						$ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';

					}else{

						$ref="";

					}

					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');

					$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);

					if(isset($any_rejection)){

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected : '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

							

							$st='<span class="badge badge-outline-success" >Approved <br/>

							Submitted To Stitching </span>';

							

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

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.')</span></td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$row['wo_product_info'].'<br>'.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st,

						$info.$up.$option

					);

				}

			}

			

			

			

			

			

			

			

		}

		$records['data']=$data;

		echo json_encode($records);	

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

	

	public function order_request(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$records = $this->bundling_model->get_requested_works($staffRow['department_id'],$staffRow['unit_managed']);

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

			if($row['verify_status']=="1"){

			$option.='<a href="#"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approved </label></a>';

			}else if($row['verify_status']=='-1'){

				$option.='<a href="#"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Rejected </label></a>';

			}else{

				$option.='<a href="#"><label class="badge badge-warning" style="cursor: pointer;"> Requested </label></a>';

			}

			

			$option.='</td>';

			$option3='<td style="text-align:center;" class="text-center">';

			$option3.='<a href="#" title="Approve" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-afor="1"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Approve</label></a>&nbsp;';

			$option3.='<a href="#" title="Reject" style="cursor: pointer;" data-toggle="modal" data-target="#approveDeny"  data-rdid="'.$row['rs_design_id'].'" data-afor="-1"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> Reject</label></a>&nbsp';

			$option3.='<a href="'.base_url('bundling/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/'.$row['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View</label></a>';

			$option3.='</td>';

			$option1='<td><span class="badge" style="background-color:#ffe74c;">'.$row['priority_name'].'</span></td>';

			

			$data[]= array(

				$row['orderform_number'],

				$itemRefNo,

				$itemDetails,

				$option1,

				$row['response_remark'],

				$option,

				$option3,

			);

		}

		$records['data']=$data;

		echo json_encode($records);	

	}

	

	public function list_pending_old(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		

		//echo $staffRow['department_id'];

		$records = $this->bundling_model->get_pending_works($staffRow['department_id'],$staffRow['unit_managed']);

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

				$status='<td><span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Not Requested ('.$temCount.')</strong></span></td>';



			}else{

				if($order_count==0){

					$status='<td><span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Requested ('.$row['APP_COUNT'].')</strong></span></td>';

				}else{

					

					$status='<td><span class="badge badge-outline-success" ><i class="fa fa-thumbs-up" ></i> <strong>Requested ('.$row['APP_COUNT'].')</strong></span></td>';

					$status.='&nbsp;<span class="badge badge-outline-danger" ><i class="fa fa-thumbs-down" ></i> <strong>Not Requested ('.$order_count.')</strong></span></td>';

					

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

 