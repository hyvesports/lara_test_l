<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Work_online extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('settings_model', 'settings_model');
		$this->load->model('leads_model', 'leads_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('log_model', 'log_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('notification_model', 'notification_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}

	public function save_order_data(){

		if($this->input->post('submit')){

			$data = array(

				'wo_order_nature_id' => $this->input->post('wo_order_nature_id'),

				'wo_dispatch_date' => $this->input->post('wo_dispatch_date'),

				'wo_owner_id' => $this->session->userdata('loginid'),

				'wo_product_info' => $this->input->post('wo_product_info'),

				'wo_work_priority_id' => $this->input->post('wo_work_priority_id'),

				'wo_u_by' => $this->session->userdata('loginid'),

				'wo_u_date' =>date('Y-m-d'),

				'wo_edit_request_status'=>0,

				'wo_edit_request_approved_by'=>0

			);

			$orderRow= $this->workorder_model->get_order_data_by_uuid($this->input->post('order_uuid'));

			$log_desc="Work order updated [".$orderRow['orderform_number']."] : Fields are  ";

			if($this->input->post('wo_order_nature_id')!=$orderRow['wo_order_nature_id']){ $log_desc.='order nature,'; }

			if($this->input->post('wo_dispatch_date')!=$orderRow['wo_dispatch_date']){ $log_desc.='dispatch date,'; }

			if($this->input->post('wo_product_info')!=$orderRow['wo_product_info']){ $log_desc.='product info,'; }

			if($this->input->post('wo_work_priority_id')!=$orderRow['wo_work_priority_id']){ $log_desc.='priority,'; }

			

			$this->workorder_model->update_wo_data($data,$this->input->post('order_id'));

			$log_data = array(

				'log_title'=>'Online work order updated ['.$orderRow['orderform_number'].']',			  

				'log_controller' => 'work_online',

				'log_function' => 'production_edit',

				'log_module' => 'Work Order Online',

				'log_desc' => $log_desc,

				'log_updated_by' => $this->session->userdata('loginid')

			);

			$this->log_model->insert_log_data($log_data);

			$responseMsg='<div class="alert alert-success" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>

				Order details updated !!!</div>';

			echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));

		}else{

			$responseMsg='<div class="alert alert-danger" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>

				Enter all required inputs!!!</div>';

			echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));

		}

	}

	

	public function production_edit($id=0){

		if($this->input->post('submit')){

		$config = array(

					'upload_path' => "./uploads/orderform/",

					'allowed_types' => "*",

					'overwrite' => FALSE,

					'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)

				);

				$this->load->library('upload', $config);

				$i = 0;

           	 	$files = array();

            	$is_file_error = FALSE;

				if ($_FILES['upload_file1']['size'] > 0) {

					

					foreach ($_FILES as $key => $value) {

						if (!empty($value['name'])) {

							

							if (!$this->upload->do_upload($key)) {

								$this->handle_error($this->upload->display_errors());

								$is_file_error = TRUE;

							} else {

								$up_file = $this->upload->data();

								$file_name=$up_file['file_name'];

								$files[$i]=$up_file;

								$data = array(

								'wo_order_id' => $this->input->post('order_id'),

								'document_type' => 'image',

								'document_name' => $file_name

								);

								$rs = $this->workorder_model->save_order_form_document($data);

								++$i;

							}

						}

               		}

					

					if ($is_file_error && $files) {

					for ($i = 0; $i < count($files); $i++) {

					$file = $dir_path . $files[$i]['file_name'];

					if (file_exists($file)) {

					unlink($file);

					}

					}

					}

					

				}

				if ($_FILES['attachment']['size'] > 0) {

					if($this->upload->do_upload('attachment') ){

					$data_upload2 =$this->upload->data();

					$attachment_file=$data_upload2['file_name'];

					$data = array(

							'wo_order_id' => $this->input->post('order_id'),

							'document_type' => 'document',

							'document_name' => $attachment_file

					);

					$rs = $this->workorder_model->save_order_form_document($data);

					}

				}

				$this->session->set_flashdata('success','Files updated successfully !!!');

		}

		//$moduleData=$this->rbac->check_operation_access(); // check opration permission

		$accessArray=$this->rbac->check_operation_access_my_account('workorder');

		$data['title']=$accessArray['module_parent']." | ONLINE WORK ORDER";

		$data['title_head']='ONLINE WORK ORDER';

		

		if($accessArray==""){

			redirect('access/not_found');

		}else{

			if($accessArray){if(!in_array("edit_request",$accessArray)){

			redirect('access/access_denied');

			}}

		}

		$row= $this->workorder_model->get_order_data_by_uuid($id);

		//print_r($row);

		if($row==""){

			$this->session->set_flashdata('error','Invalid work order.');

			redirect('workorder/wo_online');

		}else{

			if($row['wo_status_value']==1 && $row['wo_edit_request_approved_by']==0 ){ 

				$this->session->set_flashdata('error','Work order already submitted to production department.');

				redirect('workorder/index');

			}

		}

		$data['woRow']=$row;

		$data['summary'] = $this->workorder_model->get_order_summary_in_detail_online($row['order_id']);

		$data['order_nature'] = $this->workorder_model->get_order_nature();

		$data['priority']= $this->workorder_model->get_all_active_priority();

		$data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');

		$data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');

		$data['view']='workorder/production_edit_online';

		$this->load->view('layout',$data);

	}

	

	function approve_request($id=0){

		$accessArray=$this->rbac->check_operation_access_my_account('workorder'); // check opration permission

		if($accessArray==""){

			redirect('access/not_found');

		}else{

			if($accessArray){if(!in_array("edit_approval",$accessArray)){

			redirect('access/access_denied');

			}}

		}

		$loginid=$this->session->userdata('loginid');

		$data = array('wo_edit_request_status' =>0,'wo_edit_request_approved_by'=>$loginid);

		$row= $this->workorder_model->get_order_data_by_uuid($id);

		//print_r($row);

		//exit;

		$this->workorder_model->update_wo_data($data,$row['order_id']);

		

		date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 

		$now = date('d-m-Y H:i:s');

		if($loginid!=1){

			$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);

			$luser=$staffRow['staff_name'];

		}else{

			$luser="admin";

		}

		$log_desc="Online work order (".$row['orderform_number'].") approved by ".$luser." on ".$now;

		$log_data = array(

			'log_title'=>'Online work edit approved ['.$row['orderform_number'].']',	  			  

			'log_timestamp'=>$now,

			'log_controller' => 'work',

			'log_function' => 'approve_request',

			'log_module' => 'Work order',

			'log_desc' => $log_desc,

			'log_updated_by' => $this->session->userdata('loginid')

		);

		$this->log_model->insert_log_data($log_data);

		$this->session->set_flashdata('success','Edit request approved successfully.');	

		redirect('workorder/wo_online');

		 

	}

	function edit_request($id=0){
		$accessArray=$this->rbac->check_operation_access_my_account('workorder'); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("edit_request",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data = array('wo_edit_request_status' =>1);
		$row= $this->workorder_model->get_order_data_by_uuid($id);
		//print_r($row);
		//exit;
		$this->workorder_model->update_wo_data($data,$row['order_id']);
		$loginid=$this->session->userdata('loginid');
		date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
		$now = date('d-m-Y H:i:s');
		if($loginid!=1){
			$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
			$luser=$staffRow['staff_name'];
		}else{
			$luser="admin";
		}
		$log_desc="Online work order (".$row['orderform_number'].") edit requested by ".$luser." on ".$now;
		$log_data = array(
			'log_title'=>'Online work edit requested ['.$row['orderform_number'].']',	  
			'log_timestamp'=>$now,
			'log_controller' => 'work',
			'log_function' => 'edit_request',
			'log_module' => 'Work order',
			'log_desc' => $log_desc,
			'log_updated_by' => $this->session->userdata('loginid')
		);
		//------------------------------------------------
		$recipient=$this->notification_model->get_users_form_production();
		if($recipient['ph_users']!=""){ // staff id
			$notification_recipients=$recipient['ph_users'];
			$created_by=$this->session->userdata('loginid');
			if($row['lead_id']==0){
				$owner='Admin';
				$notification_from="Admin";
			}else{ 
				$owner=$row['staff_name'];
				$notification_from=$row['wo_owner_id'];
			}
			$notification_content=$owner.' requested for edit in order no. '.$row['orderform_number'];
			$notification_title="Edit request after submitted to production";
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
		$this->log_model->insert_log_data($log_data);
		$this->session->set_flashdata('success','Edit request successfully submitted.');	
		redirect('workorder/wo_online');

	}

	

	public function wo_json_list_online(){

			$accessArray=$this->rbac->check_operation_access_my_account('workorder');

			$order_type=2;

			$records = $this->workorder_model->get_all_work_orders_json($order_type);

			$data = array();

			$i=0;



			foreach ($records['data']  as $row) 

			{  

				if($row['wo_row_status']==1 && $row['submited_to_production']=='no'){

					$option='<td>';

					

					if($accessArray){if(in_array("view",$accessArray)){

						$option.='
<br/>
<a href="'.base_url('workorder/view_online/'.$row['order_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-success m-1" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					}}

					

					if($accessArray){if(in_array("edit",$accessArray)){

						$option.='<br/><a href="'.base_url('workorder/edit_online/'.$row['order_uuid']).'" title="Edit" style="cursor: pointer;"><label class="badge badge-warning m-1" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';

					}}

					

					if($accessArray){if(in_array("delete",$accessArray)){

						$option.='<br/><a title="Delete" onclick="return  deleteRow();" href="'.base_url('workorder/delete/'.$row['order_uuid']).'" style="cursor: pointer;" ><label class="badge badge-danger m-1" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';

					}}

					

					if($accessArray){if(in_array("production",$accessArray)){

						$option.='<br/><a title="Submit To Production"  href="'.base_url('workorder/production/'.$row['order_uuid']).'" ><label class="badge badge-info m-1" style="cursor: pointer;"><i class="fa fa-mail-forward" ></i></label></a>';

					}}

					

					$option.='</td>';

					

					

				}else{

					$option='<td>';

					

					if($accessArray){if(in_array("view",$accessArray)){

						$option.='<br/><a href="'.base_url('workorder/view_online/'.$row['order_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-success m-1" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					}}

					

					if($row['wo_edit_request_status']==0){

						if($row['wo_edit_request_approved_by']==0){

							if($accessArray){if(in_array("edit_request",$accessArray)){

								$option.='<br/><a title="Edit Request"  onclick="return  editRow();" href="'.base_url('work_online/edit_request/'.$row['order_uuid']).'" ><label class="badge badge-outline-warning m-1" title="Edit Request" ><i class="fa fa-edit" ></i></label></a>';

							}}

						}else{

							if($accessArray){if(in_array("edit",$accessArray)){

$option.='<br/><a href="'.base_url('work_online/production_edit/'.$row['order_uuid']).'" title="Edit" style="cursor: pointer;"><label class="badge badge-warning m-1" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';

							}}

						}

					}else{

						if(in_array("edit_approval",$accessArray)){

							$option.='<br/><a title="Approve Edit Request"  onclick="return  approveEditRow();" href="'.base_url('work_online/approve_request/'.$row['order_uuid']).'" ><label class="badge badge-outline-warning m-1" title="Approve Edit Request" >Approve</label></a>';

						}else{

							$option.='<br/><label class="badge badge-outline-warning m-1" title="Waiting" ><i class="fa fa-eye-slash" ></i></label></a>';

						}

					}


					

					//if($accessArray){if(in_array("edit",$accessArray)){

						//$option.='<a href="'.base_url('workorder/edit_online/'.$row['order_uuid']).'" title="Edit" style="cursor: pointer;"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';

					//}}

					

					if($accessArray){if(in_array("delete",$accessArray)){

					if($row['wo_edit_request_status']==0){

						if($row['wo_edit_request_approved_by']==0){

							if($accessArray){if(in_array("edit_request",$accessArray)){



							}}

						}else{

							if($accessArray){if(in_array("edit",$accessArray)){
if($row['accounts_completed_status']!=1)
{
	$option.='<br/><a title="Delete" onclick="return  deleteRow();" href="'.base_url('workorder/delete/'.$row['order_uuid']).'" style="cursor: pointer;" ><label class="badge badge-danger m-1" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';
}


							}}

						}

					}else{

						if(in_array("edit_approval",$accessArray)){



						}else{

							$option.='<br/><label class="badge badge-outline-warning m-1" title="Waiting" ><i class="fa fa-eye-slash" ></i></label></a>';

						}

					}

					

					}}

					

					$option.='</td>';

				}

				

				

				$cust=explode('|',$row['wo_customer_name']);

				$c='<ul class="list-ticked">';

					if($cust){

					$cust_names='<br/>';

					foreach($cust as $css){

						//$cust_names.=$css."<br/>";

						$c.='<li>'.$css.'</li>';

					}

				}

                $c.='</ul>';

				$ref=explode(',',$row['wo_ref_numbers']);

				$r='<ul class="list-ticked">';

					if($ref){

					$cust_names='';

					foreach($ref as $rfno){

						//$cust_names.=$css."<br/>";

						$r.='<li>'.$rfno.'</li>';

					}

				}

                $r.='</ul>';

				$data[]= array(

					$row['orderform_number'].$r,

					$c,

					

					substr($row['wo_date_time'],0,10),

					date("d-m-Y", strtotime($row['wo_dispatch_date'])),

					'<td ><label class="'.$row['style_class'].' m-1">'.$row['wo_status_title'].'</label></td>',

					$option

				);

			}

			$records['data']=$data;

			echo json_encode($records);						   

	}

	

}

