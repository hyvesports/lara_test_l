<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stitching extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('stitching_model', 'stitching_model');
		$this->load->model('common_model', 'common_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	public function list_completed(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->stitching_model->get_completed_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 

		{

			

			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);

			$array1 = json_decode($row['scheduled_order_info'],true);

			$i=0;

			if($array1){

				$total_items=count($array1);

				$subm=1;

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

						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/>  Rejected</span>';

					}else{

						if(isset($lastUpdateRow)){

							if($lastUpdateRow['verify_status']==1){

								$subm=0;

								$st='';

							

								$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');

								if($myUpdation){

									if($myUpdation['verify_status']==1){

									$mup='<span class="badge badge-outline-warning mt-1" >Final QC :<br/>'.ucwords($myUpdation['row_status']).'</span>';

									}

									if($myUpdation['verify_status']==0){

									$mup='<span class="badge badge-outline-warning mt-1" >'.ucwords($myUpdation['row_status']).'<br/> To Final QC :</span>';

									}

								}else{

									$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';

								}

							}

							if($lastUpdateRow['verify_status']==-1){

								$subm=1;

							$st='<span class="badge badge-outline-danger" >Rejected</span>';

							}

							if($lastUpdateRow['verify_status']==0){

								$subm=1;

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

							}

						}else{

							$subm=1;

							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';

						}

					}

					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';

					//--------------------------------------------------

					if($subm==0){

					$data[]= array(

						'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',

						'<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>',

						'<td><span class="badge" >'.$row['wo_date_time'].'</span></td>',

						date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),

						$sales_handler,

						'<label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label>',

						$st.$mup,

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
		//echo $staffRow['department_id'];
		$records = $this->stitching_model->get_pending_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			$array1 = json_decode($row['scheduled_order_info'],true);
			$i=0;
			if($array1){
				$total_items=count($array1);
				$subm=1;
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
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/>  Rejected</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								$subm=0;
							$st='<span class="badge badge-outline-success" >Bundling QC <br/>Approved</span>';
								$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
								if($myUpdation){
									if($myUpdation['verify_status']==1){
									$mup='<br/><span class="badge badge-outline-warning mt-1" >Final QC :<br/>'.ucwords($myUpdation['row_status']).'</span>';
									}
									if($myUpdation['verify_status']==0){
									$mup='<br/><span class="badge badge-outline-warning mt-1" >'.ucwords($myUpdation['row_status']).'<br/> To Final QC :</span>';
									}
								}else{
									$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
								}
							}
							if($lastUpdateRow['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
							}
						}else{
							$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
						}
					}
					//$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					//--------------------------------------------------
					}
				}

			}
			//----------------------
				$st='<td>
					<div class="badge  badge-primary" title="Order Not Submitted To Final QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Order Submitted To Final QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved By Bundling Final"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
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

		$records['data']=$data;

		echo json_encode($records);	

	}
	
	public function list_active(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->stitching_model->get_active_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
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
					$i++;
					$up="";
					$mup="";
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
					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }
					//-------------------------------------------------
					$ref="";
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');
					//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],8);
					if(isset($any_rejection)){
						//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/>  Rejected</span>';
						$rejection_count++;
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
							//$st='<span class="badge badge-outline-success" >Bundling QC <br/>Approved</span>';
							//$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
								$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
								if($myUpdation){
									if($myUpdation['verify_status']==1){
										//$mup='<br/><span class="badge badge-outline-warning mt-1" >Final QC :<br/>'.ucwords($myUpdation['row_status']).'</span>';
										$approved_count++;
									}
									if($myUpdation['verify_status']==0){
										//$mup='<br/><span class="badge badge-outline-warning mt-1" >'.ucwords($myUpdation['row_status']).'<br/> To Final QC :</span>';
										$submitted_count++;
									}
								}else{
									$not_submitted_count++;
								}
							}
							if($lastUpdateRow['verify_status']==-1){
								//$st='<span class="badge badge-outline-danger" >Not Submitted</span>';
								$rejection_count++;
							}
							if($lastUpdateRow['verify_status']==0){
								$not_submitted_count++;
								//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
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
			//---------------------------
					$st='<td>
					<div class="badge  badge-primary" title="Order Not Submitted To Final QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Order Submitted To Final QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved By Bundling Final"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
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
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function list_all(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['department_id'];
		$records = $this->stitching_model->get_all_works($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
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
					if($value1['item_unit_qty_input']!=0){
					$i++;
					$up="";
					$mup="";
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					$wo_product_info="";
					if($row['wo_product_info']!=""){ $wo_product_info=$row['wo_product_info']; }
					$re="";
					$re="";
					if($row['is_re_scheduled']>0){
						$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['is_re_scheduled']);
					}else{
						$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
					}
					if($row['lead_id']==0){ $sales_handler='Admin'; }else{ $sales_handler=$row['sales_handler']; }
					//-------------------------------------------------
					
					$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'fusing','bundling');
					//$any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
					$any_rejection=$this->myaccount_model->check_any_rejection_by_qty($row['batch_number'],$row['schedule_id'],$value1['summary_id'],8);
					if(isset($any_rejection)){
						//$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/>  Rejected</span>';
						$rejection_count++;
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								//$approved_count++;
								//$st='<span class="badge badge-outline-success" >Bundling QC <br/>Approved</span>';
								//$up='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
								$myUpdation=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
								if($myUpdation){
									if($myUpdation['verify_status']==1){
										$approved_count++;
									//$mup='<br/><span class="badge badge-outline-warning mt-1" >Final QC :<br/>'.ucwords($myUpdation['row_status']).'</span>';
									}
									if($myUpdation['verify_status']==0){
										$submitted_count++;
									//$mup='<br/><span class="badge badge-outline-warning mt-1" >'.ucwords($myUpdation['row_status']).'<br/> To Final QC :</span>';
									}
								}else{
									$not_submitted_count++;
								}
							}
							if($lastUpdateRow['verify_status']==-1){
								//$st='<span class="badge badge-outline-danger" >Rejected</span>';
								$rejection_count++;
							}
							if($lastUpdateRow['verify_status']==0){
								//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
								$not_submitted_count++;
							}
						}else{
							//$st='<span class="badge badge-outline-warning" >Not Submitted</span>';
							$not_submitted_count++;
						}
					}
					$info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					//--------------------------------------------------
					
					}
				}
				//________________________________________________
					$st='<td>
					<div class="badge  badge-primary" title="Order Not Submitted To Final QC"><i class="fa fa-exclamation-circle"></i> '.$not_submitted_count.'</div>
					<div class="badge  badge-warning" title="Order Submitted To Final QC"><i class="fa fa-exchange"></i> '.$submitted_count.'</div><br/>
					<div class="badge  badge-success mt-1" title="Order Approved By Bundling Final"><i class="fa fa-thumbs-up"></i> '.$approved_count.'</div>
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
				//------------------------------------------------
			}
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
//=======================================================================================================================================================================================

//-----------------------------------------------------------------------------------------------------------------------------------------------------------//
	public function order_view($uuid,$sdid,$rs_design_id){

		//echo $rs_design_id;

		$data['title']="Order Submitted | View";

		$data['title_head']="Order Submitted | View";

		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);

		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$data['staffRow']=$staffRow;

		

		if($staffRow['department_id']==8){

			$data['request_row']=$this->stitching_model->get_fusing_request_row($rs_design_id);

			$data['view']='stitching/stitching_order_view_single';

			$this->load->view('layout',$data);

		}

		

	}
	public function order_submitted(){

		$accessArray=$this->rbac->check_operation_access(); 

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

		$records = $this->stitching_model->get_submitted_works($staffRow['department_id'],$staffRow['unit_managed']);

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

				$option.='<a href="#"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-thumbs-up" ></i> Submitted </label></a>';

			}

			

			$option.='</td>';

			$option3='<td style="text-align:center;">';

			$option3.='<a href="'.base_url('stitching/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/'.$row['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View</label></a>';

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
	public function save_updates(){

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

				

				$selPre="SELECT * FROM rs_design_departments WHERE schedule_id='$schedule_id' AND summary_item_id='$summary_id' and unit_id='$unit_id' and submitted_to_stitching=0 and row_status='approved' and to_department='bundling' ORDER BY rs_design_id DESC LIMIT 1 ";

				$queryPre = $this->db->query($selPre);			 

    			$rsRowPre=$queryPre->row_array();

				if($rsRowPre){

					$rs_design_id=$rsRowPre['rs_design_id'];

					$upPre="UPDATE rs_design_departments SET submitted_to_stitching='1' WHERE rs_design_id='$rs_design_id' ";

					$this->db->query($upPre);

				}

				

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

				'verify_status'=>0,

				'submitted_item'=>$sDepartmentRow['scheduled_order_info'],

				'qc_name'=>'stitching',

				'from_department'=>'stitching',

				'to_department'=>'final_qc',

				'row_status'=>'submitted',

				

				);

				//print_r($insertNew);exit;

				$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='$schedule_department_id'  AND summary_item_id='$summary_id' and qc_name='stitching' ORDER BY rs_design_id DESC LIMIT 1 ";

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

						$this->db->insert('rs_design_departments', $insertNew);

						

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
	public function updates_order_status(){

		$loginid=$this->session->userdata('loginid');

		$data['staffRow']=$this->myaccount_model->get_staff_profile_data($loginid);

		if($_POST['act']=="up"){

			$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);

			$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['sdid']);

			$this->load->view('stitching/stitching_order_updates',$data);

		}else{

			$this->load->view('stitching/stitching_order_updates_list');

		}

	}
}

 