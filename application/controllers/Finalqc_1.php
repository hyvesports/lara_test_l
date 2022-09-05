<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Finalqc extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('common_model', 'common_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
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
					if(in_array($file_name[1], $allowed_extension))  {  
						$new_name =$order_item_id."_".rand() . '.'. $file_name[1];  
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
					} 
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
			echo $msg.$output; 
		}  
	}
	public function upload_image(){
		$this->load->view('qc/upload_image');
	}
	public function final_qc_list_completed(){

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
	public function final_qc_list_pending(){

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
							$unit_id=$DP['unit_id'];
							//scheduled_order_info
							//$scheduled_order_info=$DP['scheduled_order_info'];
							$arrayJson = json_decode($DP['scheduled_order_info'],true);
							if($arrayJson){
								foreach($arrayJson as $jKey => $jValue){ 
									if($rej_summary_item_id==$jValue['summary_id']){
										$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
										$query = $this->db->query($ins);
									}
								}
							}
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
						$rej_items=$rsRow['rej_items'];
						$new_rej=$rej_items.",".$rej_summary_item_id;
						$up="UPDATE sh_schedule_departments SET rej_items='$new_rej' WHERE schedule_department_id='$schedule_department_id' ";
						$query1= $this->db->query($up);	
						$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
						$query = $this->db->query($ins);
					}
					if($rsRow['orderform_type_id']=="1"){ //offline order
						$batch_number=$rsRow['batch_number'];
						$s_deptmts=$this->qc_model->get_all_schedule_departments_for_offline_rejection_by_batch_no($rej_schedule_id,$rej_unit_id,'8',$batch_number); //stitching
						if($s_deptmts){
							foreach($s_deptmts as $SDP){
								$schedule_department_id=$SDP['schedule_department_id'];
								$order_id=$SDP['order_id'];
								$schedule_id=$SDP['schedule_id'];
								$unit_id=$SDP['unit_id'];
								$sdp_rej_items=$SDP['rej_items'];
								$sdp_new_rej=$sdp_rej_items.",".$rej_summary_item_id;
								$up="UPDATE sh_schedule_departments SET rej_items='$sdp_new_rej' WHERE schedule_department_id='$schedule_department_id' ";
								$query1= $this->db->query($up);
								$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
								$query = $this->db->query($ins);	
							}
						}
						$f_deptmts=$this->qc_model->get_all_schedule_departments_for_offline_rejection_by_batch_no($rej_schedule_id,$rej_unit_id,'13',$batch_number); //Packing,Final QC
						if($f_deptmts){
							foreach($f_deptmts as $FDP){
								$schedule_department_id=$FDP['schedule_department_id'];
								$order_id=$FDP['order_id'];
								$schedule_id=$FDP['schedule_id'];
								$unit_id=$FDP['unit_id'];
								$fdp_rej_items=$FDP['rej_items'];
								$fdp_new_rej=$fdp_rej_items.",".$rej_summary_item_id;
								$up2="UPDATE sh_schedule_departments SET rej_items='$fdp_new_rej' WHERE schedule_department_id='$schedule_department_id' ";
								$query2= $this->db->query($up2);
								$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
								$query = $this->db->query($ins);	
							}
						}

						$d_deptmts=$this->qc_model->get_all_schedule_departments_for_offline_rejection_by_batch_no($rej_schedule_id,$rej_unit_id,'10',$batch_number); //Dispatch
						if($d_deptmts){
							foreach($d_deptmts as $DDP){
								$schedule_department_id=$DDP['schedule_department_id'];
								$order_id=$DDP['order_id'];
								$schedule_id=$DDP['schedule_id'];
								$unit_id=$DDP['unit_id'];
								$ddp_rej_items=$DDP['rej_items'];
								$ddp_new_rej=$ddp_rej_items.",".$rej_summary_item_id;
								$up22="UPDATE sh_schedule_departments SET rej_items='$ddp_new_rej' WHERE schedule_department_id='$schedule_department_id' ";
								$query22= $this->db->query($up22);

								$ins="INSERT INTO `rj_scheduled_orders` (`rej_order_id`,schedule_id,order_id,`schedule_department_id`, `rs_design_id`, `rej_summary_item_id`,rejected_by,rejected_dept_id,rejected_timestamp,re_schedule_status,unit_id) VALUES (NULL,'$schedule_id','$order_id','$schedule_department_id', '$rs_design_id', '$rej_summary_item_id','$approved_by','13','$verify_datetime','0','$unit_id');";
								$query = $this->db->query($ins);	
							}
						}
					}
				}
			}else{
				$orderform_type_id=addslashes($this->input->post('orderform_type_id'));
				if($orderform_type_id==1){
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
						accounts_status='1',
						accounts_verified_by='1',
						row_status='approved'
					WHERE
						rs_design_id='$rs_design_id' ";
				}
				//echo $sql;
				//exit;
				$query = $this->db->query($sql);
			}
			$this->session->set_flashdata('success','Successfull updated the order status.');	
		}

	}
}
