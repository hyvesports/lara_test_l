<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Leads extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('leads_model', 'leads_model');
		$this->load->model('settings_model', 'settings_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('staff_model', 'staff_model');
		$this->load->model('log_model', 'log_model');
		$this->load->model('task_model', 'task_model');
		$this->load->model('notification_model', 'notification_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	function task_edit($uuid=0){
		$row_task= $this->task_model->get_my_task_by_uuid($uuid);
		if($row_task==""){
			redirect('leads/index');
			exit;
		}
		if($this->input->post('submitData')){
			//echo 'fff';exit;
			$this->form_validation->set_rules('reminder_date', 'Reminder date', 'trim|required');
			$this->form_validation->set_rules('reminder_time', 'Reminder time', 'trim|required');
			$this->form_validation->set_rules('task_desc', 'Task', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg=validation_errors();
			}else{
				//insert_task_data
				date_default_timezone_set('Asia/kolkata'); 
				$now = date('d-m-Y H:i:s');
				$reminder_date=date("Y-m-d",strtotime($this->input->post('reminder_date')));
				$task_data = array(
					'lead_id'=>$this->input->post('lead_id'),
					'task_owner_id'=>$this->session->userdata('loginid'),
					'task_desc' =>$this->input->post('task_desc'),
					'reminder_date' =>$reminder_date,
					'reminder_time' =>$this->input->post('reminder_time'),
					'task_u_date' => $now,
					'task_status' => 0
				);
				$this->task_model->update_task_data($task_data,$this->input->post('task_id'));
				$this->session->set_flashdata('success','Task updated successfully');
				redirect('leads/task_edit/'.$uuid);
			}
		}
		$lead_id=$row_task['lead_id'];
		$row_lead=$this->leads_model->get_leads_data_by_id($lead_id);
		$data['task_info']=$row_task;
		$data['lead_info']=$row_lead;
		$data['all_tasks'] = $this->task_model->get_my_tasks($row_lead['lead_id'],$this->session->userdata('loginid'));
		$data['title']="Task | Edit Task";
		$data['view']='task/all_tasks_edit';
		$this->load->view('layout',$data);
	}
	function task_remove($uuid=0){
		$row_task= $this->task_model->get_my_task_by_uuid($uuid);
		$lead_id=$row_task['lead_id'];
		$row_lead=$this->leads_model->get_leads_data_by_id($lead_id);
		$this->task_model->delete_task_data($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('leads/task/'.$row_lead['lead_uuid']);
	}
	function task($uuid=''){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("task",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		if($this->input->post('submitData')){
			//echo 'fff';exit;
			$this->form_validation->set_rules('reminder_date', 'Reminder date', 'trim|required');
			$this->form_validation->set_rules('reminder_time', 'Reminder time', 'trim|required');
			$this->form_validation->set_rules('task_desc', 'Task', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg=validation_errors();
			}else{
			//insert_task_data
				date_default_timezone_set('Asia/kolkata');
				$now = date('d-m-Y H:i:s');
				$reminder_date=date("Y-m-d",strtotime($this->input->post('reminder_date')));
				$sql="SELECT 
					leads_master.lead_code,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email 
				FROM 
					leads_master 
					LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id
				WHERE
					leads_master.lead_id='".$this->input->post('lead_id')."' ";
				$query = $this->db->query($sql);					 
        		$rsRow=$query->row_array();
				$cinfo=$rsRow['lead_code'];
				$cinfo.=",".$rsRow['customer_name'];
				$cinfo.=",".$rsRow['customer_mobile_no'];
				$cinfo.=",".$rsRow['customer_email'];
				$task_data = array(
					'lead_id'=>$this->input->post('lead_id'),
					'task_owner_id'=>$this->session->userdata('loginid'),
					'task_desc' =>$this->input->post('task_desc'),
					'reminder_date' =>$reminder_date,
					'reminder_time' =>$this->input->post('reminder_time'),
					'task_c_date' => $now,
					'task_u_date' => $now,
					'task_status' => 0,
					'customer_info'=>$cinfo
				);
				$this->task_model->insert_task_data($task_data);
				$this->session->set_flashdata('success','Task created successfully');
				redirect('leads/task/'.$uuid);
			}
		}
		$row= $this->leads_model->get_leads_data($uuid);
		if($row==""){
			redirect('leads/index');
			exit;
		}
		$data['lead_info']=$row;
		$data['all_tasks'] = $this->task_model->get_my_tasks($row['lead_id'],$this->session->userdata('loginid'));
		$data['title']="Task | Manage Task";
		$data['view']='task/all_tasks';
		$this->load->view('layout',$data);
	}
	function approve_edit_permission($uuid='')
	{   
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("edit_permission",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$lead_data = array(
			'lead_edit' =>0,
			'lead_edit_approved_by'=>$this->session->userdata('loginid')
		);
		$this->leads_model->update_leads_data_by_uuid($lead_data,$uuid);
		$rowLead= $this->leads_model->get_leads_data($uuid);
		$loginid=$this->session->userdata('loginid');
		date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
		$now = date('d-m-Y H:i:s');
		if($loginid!=1){
			$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
			$luser=$staffRow['staff_name'];
		}else{
			$luser="admin";
		}
		$log_desc="Lead (".$rowLead['lead_code'].") edit request approved by ".$luser." on ".$now;
		$log_data = array(
			'log_title' => 'Lead edit approved ['.$rowLead['lead_code'].']',				  
			'log_timestamp'=>$now,
			'log_controller' => 'lead',
			'log_function' => 'edit_permission',
			'log_module' => 'Lead',
			'log_desc' => $log_desc,
			'log_updated_by' => $this->session->userdata('loginid')
		);
		$this->log_model->insert_log_data($log_data);
		$this->session->set_flashdata('success','Edit request successfully approved.');	
		redirect('leads/index');
	}
	function edit_permission($uuid='')
	{   
		$lead_data = array(
			'lead_edit' =>1,
		);
		$this->leads_model->update_leads_data_by_uuid($lead_data,$uuid);
		$rowLead= $this->leads_model->get_leads_data($uuid);
		$loginid=$this->session->userdata('loginid');
		date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
		$now = date('d-m-Y H:i:s');
		if($loginid!=1){
			$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
			$luser=$staffRow['staff_name'];
		}else{
			$luser="admin";
		}
		$log_desc="Lead (".$rowLead['lead_code'].") edit requested by ".$luser." on ".$now;
		$log_data = array(
			'log_title' =>'Lead edit requested ['.$rowLead['lead_code'].']',					  
			'log_timestamp'=>$now,
			'log_controller' => 'lead',
			'log_function' => 'edit_permission',
			'log_module' => 'Lead',
			'log_desc' => $log_desc,
			'log_updated_by' => $this->session->userdata('loginid')
		);
		$this->log_model->insert_log_data($log_data);
		$this->session->set_flashdata('success','Edit request successfully submitted.');	
		redirect('leads/index');
	}
	public function customer_mob_ajax($pno = "",$cid=""){
		$this->load->model('customer_model', 'customer_model');
		if($cid==0){
			$custid="";
		}else{
			$custid=$cid;
		}
		$datachk = array(
			'customer_mobile_no' => $pno
		);
		$row = $this->customer_model->check_customer_mobileno_exist($datachk,$custid);
		if($row){
			echo json_encode(array('responseCode' =>"notavailable",'responseMsg'=>'Phone number already registered'));
		}else{
			echo json_encode(array('responseCode' =>"available",'responseMsg'=>'Phone number available'));
		}
	}
	public function customer_ajax($id = ""){
		$this->load->model('customer_model', 'customer_model');
		//$row = $this->customer_model->get_customer_data_by_id($id);
		//$data['row']=$row;
		if($id=="0"){
		$this->load->view('leads/customer_form');
		}
	}
	function filter()
	{
		$this->session->set_userdata('lead_stage_id',$this->input->post('lead_stage_id'));
		$this->session->set_userdata('lead_search_date',$this->input->post('search_date'));
		$this->session->set_userdata('lead_source_id',$this->input->post('lead_source_id'));
		$this->session->set_userdata('lead_type_id',$this->input->post('lead_type_id'));
		$this->session->set_userdata('lead_sports_type_id',$this->input->post('sports_type_id'));
		$this->session->set_userdata('lead_search_key',$this->input->post('lead_search_key'));
	}
	public function advance_datatable_json(){	
		//echo $loginid=$this->session->userdata('role_id');
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		//print_r($accessArray);
		if($accessArray==""){
			redirect('access/not_found');
		}
			if($accessArray){
				if(in_array("list_all",$accessArray)){
				$records = $this->leads_model->get_all_leads();
				}else{
				$loginid=$this->session->userdata('loginid');
					$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
					$records = $this->leads_model->get_all_leads_by_owner($staffRow['staff_id']);
				}
			}
			$data = array();
			$i=0;
			foreach ($records['data']  as $row) 

			{  
				//$status = ($row['is_active'] == 1)? 'checked': '';
				if($row['cust_info']==""){
					$cust_info=$row['customer_name'].",".$row['customer_email'].",".$row['customer_mobile_no']; 
					$up="UPDATE leads_master SET  cust_info='".$cust_info."' WHERE lead_id='". $row['lead_id']."'  ";
					$query = $this->db->query($up);
				}
				$option='<td>';
				if($accessArray){if(in_array("task",$accessArray)){
				$option.='<a title="Tasks" href="'.base_url('leads/task/'.$row['lead_uuid']).'"><label class="badge badge-primary" title="Task" style="cursor: pointer;"><i class="fa fa-tasks"></i></label></a>';
				}}
				if($row['generate_wo']==0){
					if($accessArray){if(in_array("view",$accessArray)){
					$option.='<a title="View" href="'.base_url('leads/view/'.$row['lead_uuid']).'"><label class="badge badge-success ml-1" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					}}

					

					if($accessArray){if(in_array("edit",$accessArray)){

					$option.='&nbsp;<a title="Edit" href="'.base_url('leads/edit/'.$row['lead_uuid']).'"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';

					}}

					

					if($accessArray){if(in_array("delete",$accessArray)){

					$option.='&nbsp;<a title="Delete"  onclick="return  deleteRow();" href="'.base_url('leads/delete/'.$row['lead_uuid']).'" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';

					}}

					

					if($accessArray){if(in_array("generate",$accessArray)){

					$option.='&nbsp;<a title="Generate" href="'.base_url('workorder/add/'.$row['lead_uuid']).'"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-mail-forward" ></i></label></a>';

					}}



					

				}else{

					

					

					if($accessArray){if(in_array("delete__",$accessArray)){

					$option.='&nbsp;<a title="Delete"  onclick="return  deleteRow();" href="'.base_url('leads/delete/'.$row['lead_uuid']).'" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';

					}}

					

					

					if($accessArray){if(in_array("view",$accessArray)){

					$option.='&nbsp;<a title="View" href="'.base_url('leads/view/'.$row['lead_uuid']).'"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';

					}}

					

					if($accessArray){if(in_array("edit",$accessArray)){

					$option.='&nbsp;<a title="Edit" href="'.base_url('leads/edit/'.$row['lead_uuid']).'"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';

					}}

					

					/*if($row['lead_edit']==0){

						if($row['lead_edit_approved_by']==0){

					$option.='&nbsp;<a title="Edit Request"  onclick="return  editRow();" href="'.base_url('leads/edit_permission/'.$row['lead_uuid']).'" ><label class="badge badge-outline-warning" title="Edit Request" ><i class="fa fa-edit" ></i></label></a>';

						}else{

							if($accessArray){if(in_array("edit",$accessArray)){

					$option.='&nbsp;<a title="Edit" href="'.base_url('leads/edit/'.$row['lead_uuid']).'"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';

					}}

						}

					}else{

						if($accessArray){

							if(in_array("edit_permission",$accessArray)){

								$option.='<a title="Approve Edit Request"  onclick="return  approveEditRow();" href="'.base_url('leads/approve_edit_permission/'.$row['lead_uuid']).'" ><label class="badge badge-outline-warning ml-1" title="Approve Edit Request" ><i class="fa fa-refresh" ></i> Edit Request</label></a>';

							}else{

								$option.='<label class="badge badge-outline-warning ml-1" title="Waiting" ><i class="fa fa-eye-slash" ></i></label></a>';

							}

						}

					}*/

					//add|edit|view|delete|generate|list_all||notification

					$option.='&nbsp;<label class="badge badge-outline-success" title="Work Order Generated" ><i class="fa fa-check-circle" ></i></label>';

					$option.="</td>";

				}

				

				$data[]= array(

					++$i,

					$row['lead_code']." <br/> ".$row['lead_date'],

					$row['staff_name'],

					$row['customer_name'],

					$row['lead_source_name']."<br/>".$row['lead_stage_name'],

					'<td ><label class="'.$row['color_code'].'">'.$row['lead_type_name'].' / '.$row['lead_cat_name'].'</label></td>',

					$option

				);

			}

			$records['data']=$data;

			echo json_encode($records);						   

	}

	

	public function index(){

		$accessArray=$this->rbac->check_operation_access(); // check opration permission

		if($accessArray==""){

			redirect('access/not_found');

		}

		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];

		$data['title_head']=$accessArray['menu_name'];

		$this->session->unset_userdata('lead_search_date');

		$this->session->unset_userdata('lead_source_id');

		$this->session->unset_userdata('lead_type_id');

		$this->session->unset_userdata('lead_sports_type_id');

		$this->session->unset_userdata('lead_search_key');

		$this->session->unset_userdata('lead_stage_id');

		

		$data['lead_sources'] = $this->settings_model->get_lead_sources();

		$data['lead_types'] = $this->settings_model->get_lead_types();

		$data['sports_types'] = $this->settings_model->get_sports_types();

		$data['lead_stages'] = $this->settings_model->get_all_lead_stages();

		$data['accessArray']=$accessArray;	

		$data['view']='leads/index';

		$this->load->view('layout',$data);

	}

	

	public function add(){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("add",$accessArray)){
			redirect('access/access_denied');
			}}
		}

		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		if($this->input->post('submit')){
			$log_desc='';
			if($this->input->post('customer_id')==0){
				$this->form_validation->set_rules('from_name', 'Cient/company name', 'trim|required');
				$this->form_validation->set_rules('from_phone', 'Phone', 'trim|required');
			}

			$this->form_validation->set_rules('lead_owner_id', 'Staff code', 'trim|required');
			$this->form_validation->set_rules('customer_id', 'Client / Company', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['lead_stages'] = $this->settings_model->get_active_lead_stages();
				$data['lead_sources'] = $this->settings_model->get_lead_sources();
				$data['lead_types'] = $this->settings_model->get_lead_types();
				$data['sports_types'] = $this->settings_model->get_sports_types();
				$data['categories'] = $this->settings_model->get_lead_categories();
				$this->load->model('customer_model', 'customer_model');
				$data['customers']= $this->customer_model->get_all_customers();
				$data['lead_staffs'] = $this->leads_model->get_all_staffs_sales();
				$data['view']='leads/add';
				$this->load->view('layout', $data);
			}else{
				$this->load->model('staff_model', 'staff_model');
				//$staff_datachk = array(
				//'staff_code' =>$this->input->post('staff_code')
				//);
				//$row2 = $this->staff_model->check_staffcode_exist($staff_datachk,'');
				//echo 'dfgdg';print_r($row2);exit;
				//if(!$row2){
					//$this->session->set_flashdata('error', 'Invalid staff code...!');
					//$data['view']='leads/add';
					//$this->load->view('layout',$data);
					//exit;
				//}
				//$lead_owner_id=$row2['staff_id'];
				$lead_owner_id=$this->input->post('lead_owner_id');
				//staff_model
				$staff_info = $this->staff_model->get_staffdata_by_staff_id($lead_owner_id);
				if($this->input->post('customer_id')==0){
					$cus_datachk = array('customer_mobile_no' => $this->input->post('from_phone'));

					$this->load->model('customer_model', 'customer_model');

					$row = $this->customer_model->check_customer_mobileno_exist($cus_datachk,'');
					if($row['customer_id']!=""){
						$this->session->set_flashdata('error', 'Phone number already registered...!');
						$data['view']='leads/add';
						$this->load->view('layout',$data);
					}else{
						$socialmediaArrayJson="";
						if($_POST['socialmedia']){
							$socialmediaArray=array();
							foreach($_POST['socialmedia'] as $socialmediaItem){
								$platform=trim(addslashes(htmlentities($socialmediaItem['platform'])));
								$link=trim(addslashes(htmlentities($socialmediaItem['link'])));
								if($platform!="" && $link!="" ){
									$socialmediaArray[$platform]=$link;
								}
							}
							$socialmediaArrayJson=json_encode($socialmediaArray); 
						}
						$customer_data = array(
							'customer_name' => $this->input->post('from_name'),
							'customer_email' => $this->input->post('from_email'),
							'customer_mobile_no' => $this->input->post('from_phone'),
							'customer_website' => $this->input->post('from_website'),
							'customer_social_media_links' => $socialmediaArrayJson,
							'country' => $this->input->post('from_country'),
							'state' => $this->input->post('from_state'),
							'city' => $this->input->post('from_city'),
							'customer_c_by' =>$this->session->userdata('loginid'),
							'customer_c_date' =>date('Y-m-d'),
							'customer_status' => '1'
						);
						$cid = $this->customer_model->insert_customer_data_from_lead($customer_data);
						$cust_info=$this->input->post('from_name').",".$this->input->post('from_email').",".$this->input->post('from_phone');
						$log_desc.='New customer record with ';

					}

				}else{

					$cid=$this->input->post('customer_id');
					$this->load->model('customer_model', 'customer_model');
					$cusRow= $this->customer_model->get_customer_data_by_id($cid);
					$cust_info=$cusRow['customer_name'].",".$cusRow['customer_email'].",".$cusRow['customer_mobile_no'];
					$log_desc.='Existing customer record with ';

				}
				if($this->input->post('sports_type_id')){
				$inc=0;
				$sports_type_ids="";
				foreach($this->input->post('sports_type_id') as $ST){
					$inc++;
					if($inc==1){
						$sports_type_ids=$ST;

					}else{

						$sports_type_ids.=",".$ST;
					}
				}
				}
				$attachment="";
				$config = array(
					'upload_path' => "./uploads/leads/",
					'allowed_types' => "*",
					'overwrite' => FALSE,
					'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				);
				$this->load->library('upload', $config);
				if($this->upload->do_upload('lead_attachment')){
					$data_upload =$this->upload->data();
					$attachment=$data_upload['file_name'];
				}
				$lead_data = array(
					'lead_client_id' => $cid,
					'lead_desc' => $this->input->post('lead_desc'),
					'lead_type_id' => $this->input->post('lead_type_id'),
					'lead_sports_types' => $sports_type_ids,
					'lead_remark' => $this->input->post('lead_remark'),
					'lead_attachment' => $attachment,
					'lead_date' => $this->input->post('lead_date'),
					'lead_source_id' => $this->input->post('lead_source_id'),
					'lead_date' => $this->input->post('lead_date'),
					'lead_owner_id' => $lead_owner_id,
					'lead_c_by' =>$this->session->userdata('loginid'),
					'lead_c_date' =>date('Y-m-d'),
					'lead_u_by' =>$this->session->userdata('loginid'),
					'lead_u_date' =>date('Y-m-d'),
					'lead_cat_id' => $this->input->post('lead_cat_id'),
					'lead_stage_id' => $this->input->post('lead_stage_id'),
					'lead_info' => $this->input->post('lead_info'),
					'lead_status' => '1',
					'lead_owner_info'=>$staff_info['staff_name'],
					'cust_info'=>$cust_info
				);
				$lead_code = $this->leads_model->insert_lead_data($lead_data);
				$log_desc.='leads ('.$lead_code.') created  successfully';
				$log_data = array(
					'log_title' => 'Lead created ['.$lead_code.']',				  
					'log_controller' => 'lead',
					'log_function' => 'add',
					'log_module' => 'Lead',
					'log_desc' => $log_desc,
					'log_updated_by' =>$this->session->userdata('loginid')
				);
				$this->log_model->insert_log_data($log_data);

				//------------------------------------------------
					
					if($lead_owner_id!=$this->session->userdata('loginid')){ // staff id
						$notification_recipients=$lead_owner_id;
						$created_by=$this->session->userdata('loginid');
						if($created_by==1){
							$owner='Admin';
							$notification_from="Admin";
						}else{ 
							$owner=$this->session->userdata('username');
							$notification_from=$created_by;
						}
						$notification_content='New lead '.$lead_code.' is assigned to you';
						$notification_title="Lead assigned";
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
				$this->session->set_flashdata('success','Leads ('.$lead_code.') created  successfully');
				redirect('leads/index');
			}
		}else{
			$data['lead_stages'] = $this->settings_model->get_active_lead_stages();
			$data['lead_sources'] = $this->settings_model->get_lead_sources();
			$data['lead_types'] = $this->settings_model->get_lead_types();
			$data['sports_types'] = $this->settings_model->get_sports_types();
			$data['categories'] = $this->settings_model->get_lead_categories();
			$this->load->model('customer_model', 'customer_model');
			$data['customers']= $this->customer_model->get_all_customers();
			$data['lead_staffs'] = $this->leads_model->get_all_staffs_sales();
			$data['view']='leads/add';
			$this->load->view('layout',$data);
		}
	}
	public function edit($id = 0){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("edit",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']="Work Order | Leads";
		$data['title_head']="Manage Leads";
		if($this->input->post('submit')){

			$log_desc="Lead updated  ";
			$this->form_validation->set_rules('from_name', 'Cient/company name', 'trim|required');
			$this->form_validation->set_rules('from_phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('lead_owner_id', 'Staff code', 'trim|required');
			$this->form_validation->set_rules('lead_owner_id', 'Staff code', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$row = $this->leads_model->get_leads_data($id);
				$data['lead_stages'] = $this->settings_model->get_active_lead_stages();
				$data['lead_sources'] = $this->settings_model->get_lead_sources();
				$data['lead_types'] = $this->settings_model->get_lead_types();
				$data['sports_types'] = $this->settings_model->get_sports_types();
				$data['lead_staffs'] = $this->leads_model->get_all_staffs_sales();
				$data['categories'] = $this->settings_model->get_lead_categories();
				$data['row']=$row;
				$data['view']='leads/edit';
				$this->load->view('layout', $data);
			}else{
				//_________________ start of custome data_______________________
				$cus_datachk = array('customer_mobile_no' => $this->input->post('from_phone'));
				$this->load->model('customer_model', 'customer_model');
				$row = $this->customer_model->check_customer_mobileno_exist($cus_datachk,$this->input->post('customer_id'));
				if($row['customer_id']!=""){
					$row = $this->leads_model->get_leads_data($id);
					$data['lead_stages'] = $this->settings_model->get_active_lead_stages();
					$data['lead_sources'] = $this->settings_model->get_lead_sources();
					$data['lead_types'] = $this->settings_model->get_lead_types();
					$data['sports_types'] = $this->settings_model->get_sports_types();
					$data['row']=$row;
					$data['view']='leads/edit';
					$this->load->view('layout', $data);
				}else{

						$socialmediaArrayJson="";
						if($_POST['socialmedia']){
							$socialmediaArray=array();
							foreach($_POST['socialmedia'] as $socialmediaItem){
								$platform=trim(addslashes(htmlentities($socialmediaItem['platform'])));
								$link=trim(addslashes(htmlentities($socialmediaItem['link'])));
								if($platform!="" && $link!="" ){
									$socialmediaArray[$platform]=$link;
								}
							}
							$socialmediaArrayJson=json_encode($socialmediaArray); 
						}
						$customer_data = array(
							'customer_name' => $this->input->post('from_name'),
							'customer_email' => $this->input->post('from_email'),
							'customer_mobile_no' => $this->input->post('from_phone'),
							'customer_website' => $this->input->post('from_website'),
							'customer_social_media_links' => $socialmediaArrayJson,
							'country' => $this->input->post('from_country'),
							'state' => $this->input->post('from_state'),
							'city' => $this->input->post('from_city')
						);
						$custData=$this->customer_model->get_customer_data_by_id($this->input->post('customer_id'));
						if($this->input->post('from_name')!=$custData['customer_name']){ $log_desc.='customer name,'; }
						if($this->input->post('from_email')!=$custData['customer_email']){ $log_desc.='email,'; }
						if($this->input->post('from_phone')!=$custData['customer_mobile_no']){ $log_desc.='mobile number,'; }
						if($this->input->post('from_website')!=$custData['customer_website']){ $log_desc.='website,'; }
						//if($socialmediaArrayJson!=$custData['customer_social_media_links']){ $log_desc.='social media,'; }
						if($this->input->post('from_country')!=$custData['country']){ $log_desc.='country'; }
						if($this->input->post('from_state')!=$custData['state']){ $log_desc.='state,'; }
						if($this->input->post('from_city')!=$custData['city']){ $log_desc.='city,'; }
						
						$cid = $this->customer_model->update_customer_data($customer_data,$this->input->post('customer_id'));


				}
				//_________________end of custome data_______________________
				$this->load->model('staff_model', 'staff_model');
				//$staff_datachk = array(
				//'staff_code' =>$this->input->post('staff_code')
				//);
				//$row2 = $this->staff_model->check_staffcode_exist($staff_datachk,'');
				//echo 'dfgdg';print_r($row2);exit;
				//if(!$row2){
					//$this->session->set_flashdata('error', 'Invalid staff code...!');
					//$data['view']='leads/edit';
					//$this->load->view('layout',$data);
					//exit;
				//}
				//$lead_owner_id=$row2['staff_id'];
				$lead_owner_id=$this->input->post('lead_owner_id');
				$staff_info = $this->staff_model->get_staffdata_by_staff_id($lead_owner_id);
				$leadRow = $this->leads_model->get_leads_data_by_id($this->input->post('lead_id'));
				if($this->input->post('sports_type_id')){
				$inc=0; 
				$sports_type_ids="";
				foreach($this->input->post('sports_type_id') as $ST){
					$inc++;
					if($inc==1){
						$sports_type_ids=$ST;
					}else{
						$sports_type_ids.=",".$ST;
					}
				}
				}

				$attachment="";
				$config = array(
					'upload_path' => "./uploads/leads/",
					'overwrite' => FALSE,
					'allowed_types' => "*",
					'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				);
				$this->load->library('upload', $config);
				$new_upload=0;

				if($this->upload->do_upload('lead_attachment')){
					$data_upload =$this->upload->data();
					$attachment=$data_upload['file_name'];
					$new_upload=1;
					unlink('./uploads/leads/'.$this->input->post('lead_attachment_old')); 
				}else{
					$attachment=$this->input->post('lead_attachment_old');
				}

				$cusRow= $this->customer_model->get_customer_data_by_id($this->input->post('customer_id'));
				$cust_info=$cusRow['customer_name'].",".$cusRow['customer_email'].",".$cusRow['customer_mobile_no'];
				$lead_data = array(
					'lead_client_id' => $this->input->post('customer_id'),
					'lead_desc' => $this->input->post('lead_desc'),
					'lead_type_id' => $this->input->post('lead_type_id'),
					'lead_cat_id' => $this->input->post('lead_cat_id'),
					'lead_sports_types' => $sports_type_ids,
					'lead_remark' => $this->input->post('lead_remark'),
					'lead_attachment' => $attachment,
					'lead_date' => $this->input->post('lead_date'),
					'lead_source_id' => $this->input->post('lead_source_id'),
					'lead_date' => $this->input->post('lead_date'),
					'lead_owner_id' => $lead_owner_id,
					'lead_c_by' =>$this->session->userdata('loginid'),
					'lead_c_date' =>date('Y-m-d'),
					'lead_u_by' => $this->session->userdata('loginid'),
					'lead_u_date' =>date('Y-m-d'),
					'lead_stage_id' => $this->input->post('lead_stage_id'),
					'lead_info' => $this->input->post('lead_info'),
					'lead_status' => '1',
					'lead_edit_approved_by'=>0,
					'lead_owner_info'=>$staff_info['staff_name'],
					'cust_info'=>$cust_info

				);
				//print_r($lead_data);exit;
				if($this->input->post('lead_desc')!=$leadRow['lead_desc']){ $log_desc.='lead description,'; }
				if($this->input->post('lead_type_id')!=$leadRow['lead_type_id']){ $log_desc.='lead type,'; }
				if($sports_type_ids!=$leadRow['lead_sports_types']){ $log_desc.='lead sports type,'; }
				if($this->input->post('lead_remark')!=$leadRow['lead_remark']){ $log_desc.='lead remark,'; }
				if($attachment!=$leadRow['lead_attachment']){ $log_desc.='lead attachment,'; }
				if($this->input->post('lead_source_id')!=$leadRow['lead_source_id']){ $log_desc.='lead source,'; }
				if($lead_owner_id!=$leadRow['lead_owner_id']){ $log_desc.='lead owner,'; }
				$lead_code = $this->leads_model->update_leads_data($lead_data,$this->input->post('lead_id'));
				$log_desc.=' successfully';
				$log_data = array(
					'log_title' => 'Lead updated ['.$leadRow['lead_code'].']',			  
					'log_controller' => 'lead',
					'log_function' => 'edit',
					'log_module' => 'Lead',
					'log_desc' => $log_desc,
					'log_updated_by' => $this->session->userdata('loginid')
				);
				$this->log_model->insert_log_data($log_data);
				$this->session->set_flashdata('success','Lead updated successfully');
				redirect('leads/index');
			}
		}else{
			$row = $this->leads_model->get_leads_data($id);
			//print_r($row);
			if($row==""){
				redirect('leads/index');
				exit;
			}
			$data['lead_stages'] = $this->settings_model->get_active_lead_stages();
			$data['lead_sources'] = $this->settings_model->get_lead_sources();
			$data['lead_types'] = $this->settings_model->get_lead_types();
			$data['sports_types'] = $this->settings_model->get_sports_types();
			$data['lead_staffs'] = $this->leads_model->get_all_staffs_sales();
			$data['categories'] = $this->settings_model->get_lead_categories();
			$data['row']=$row;
			$data['view']='leads/edit';
			$this->load->view('layout',$data);
		}
	}
	public function view($id = 0){
			$accessArray=$this->rbac->check_operation_access(); // check opration permission
			if($accessArray==""){
				redirect('access/not_found');
			}
			if($accessArray==""){
				redirect('access/not_found');
			}else{
				if($accessArray){if(!in_array("view",$accessArray)){
				redirect('access/access_denied');
				}}
			}
			$row = $this->leads_model->get_leads_data($id);
			//print_r($row);
			if($row==""){
			redirect('leads/index');
				exit;
			}
			$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
			$data['title_head']=$accessArray['menu_name'];
			$data['lead_sports_types'] = $this->leads_model->get_lead_sports_types($row['lead_sports_types']);
			$data['row']=$row;
			$data['view']='leads/view';
			$this->load->view('layout',$data);
	}
	function delete($uuid='')
	{   
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
			if($accessArray==""){
				redirect('access/not_found');
			}
			if($accessArray==""){
				redirect('access/not_found');
			}else{
				if($accessArray){if(!in_array("delete",$accessArray)){
				redirect('access/access_denied');
				}}
			}
		$this->leads_model->delete_lead_data($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('leads/index');
	}
}