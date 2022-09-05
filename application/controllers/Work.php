<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work extends CI_Controller {
	
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
	public function details($id = 0){
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('order_id', 'Order data', 'trim|required');
			$this->form_validation->set_rules('shipping_address', 'Shipping address', 'trim|required');
			$this->form_validation->set_rules('billing_address', 'Billing address', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				
				//echo $this->input->post('customer_shipping_id');
				
				if($this->input->post('customer_shipping_id')!=""){
					 $this->workorder_model->remove_shipping_data_new($this->input->post('order_id'),$this->input->post('shipping_customer_id'));
				}
				//echo $this->input->post('wo_client_id');
			
				$shipping_data = array(
					'shipping_address' => $this->input->post('shipping_address'),
					'shipping_customer_id' => $this->input->post('wo_client_id'),
					'wo_order_id' => $this->input->post('order_id'),
				);
				$rs = $this->workorder_model->insert_shipping_data($shipping_data);
				//exit;
				
				
				if($this->input->post('customer_billing_id')!=""){
					 $this->workorder_model->remove_billing_data_new($this->input->post('order_id'),$this->input->post('billing_customer_id'));
				}
				$billing_data = array(
					'billing_address' => $this->input->post('billing_address'),
					'billing_customer_id' => $this->input->post('wo_client_id'),
					'wo_order_id' => $this->input->post('order_id'),
				);
				$rs = $this->workorder_model->insert_billing_data($billing_data);
				//exit;
				$wo_data = array( 
					'wo_special_requirement' => $this->input->post('wo_special_requirement'),
					'wo_shipping_mode_id' => $this->input->post('wo_shipping_mode_id'),
					'wo_work_priority_id' => $this->input->post('wo_work_priority_id'),
					'wo_u_by' => $this->session->userdata('loginid'),
					'wo_u_date' =>date('Y-m-d'),
				);
				$rs = $this->workorder_model->update_wo_data($wo_data,$this->input->post('order_id'));
				//$this->session->set_flashdata('success','Work order saved successfully');
				redirect('workorder/attachments/'.$id);
				//print_r($files);
			}
			
		}
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		$row= $this->workorder_model->get_order_data_by_uuid($id);
		//print_r($row);
		if($row==""){
			$this->session->set_flashdata('success','Invalid work order.');
			redirect('workorder/index');
		}
		$data['row']=$row;
		$data['priority']= $this->workorder_model->get_all_active_priority();
		$data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
		$data['view']='workorder/details';
		$this->load->view('layout',$data);
	}
	public function production_edit_details($id = 0){
		//$accessArray=$this->rbac->check_operation_access_my_account('workorder');
		$moduleData=$this->rbac->check_operation_access_my_account('workorder'); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		$row= $this->workorder_model->get_order_data_by_uuid($id);
		//print_r($row);
		if($row==""){
			$this->session->set_flashdata('error','Invalid work order.');
			redirect('workorder/index');
		}
		$data['row']=$row;
		$data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
		$data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
		$data['priority']= $this->workorder_model->get_all_active_priority();
		$data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
		$data['view']='workorder/production_edit_details';
		$this->load->view('layout',$data);
	}
	
	function production_edit($id=0){
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('lead_id', 'Lead data', 'trim|required');
			$this->form_validation->set_rules('orderform_type_id', 'Order type', 'trim|required');
			$this->form_validation->set_rules('orderform_number', 'Order number', 'trim|required');
			if(!isset($_POST['wo'])){
				//$this->form_validation->set_rules('summary_count', 'Order summary item', 'trim|required');
			}
			if ($this->form_validation->run() == TRUE) {
				$dataLead = array(
					'lead_id' => $this->input->post('lead_id'),
					'orderform_number' => $this->input->post('orderform_number')
				);
				$leadExist = $this->workorder_model->check_lead_saved($dataLead,$this->input->post('order_id'));
				if($leadExist['lead_id']==""){
					$orderExist = $this->workorder_model->check_order_no_exist($dataLead,$this->input->post('order_id'));
					if($leadExist['orderform_number']==""){
						date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
						//$now = date('d-m-Y H:i:s');
						//$wo_date = date('Y-m-d');
						//echo $this->input->post('wo_dispatch_date');
						$wo_dispatch_date = $this->input->post('wo_dispatch_date');
						//die($wo_dispatch_date);
						$taxDataRow=$this->workorder_model->get_txa_info_data($this->input->post('wo_tax_id'));
						//print_r($taxDataRow);exit;
						$orderData = array(
							'wo_customer_name' => $this->input->post('wo_customer_name'),
							'wo_staff_name' => $this->input->post('wo_staff_name'),
							'orderform_type_id' => $this->input->post('orderform_type_id'),
							'wo_order_nature_id' => $this->input->post('wo_order_nature_id'),
							'wo_owner_id' => $this->input->post('wo_owner_id'),
							'wo_dispatch_date' =>$wo_dispatch_date ,
							'wo_product_info' => $this->input->post('wo_product_info'),
							'wo_shipping_cost' => $this->input->post('wo_shipping_cost'),
							'wo_additional_cost' => $this->input->post('wo_additional_cost'),
							'wo_additional_cost_desc' => $this->input->post('wo_additional_cost_desc'),
							'wo_tax_id' => $this->input->post('wo_tax_id'),
							'wo_tax_name' => $taxDataRow['taxclass_name'],
							'wo_tax_value' =>$taxDataRow['taxclass_value'],
							'wo_adjustment' => $this->input->post('wo_adjustment'),
							'wo_gross_cost' => $this->input->post('wo_gross_cost'),
							'wo_advance' => $this->input->post('wo_advance'),
							'wo_balance' => $this->input->post('wo_balance'),
							'wo_u_by' => $this->session->userdata('loginid'),
							'wo_u_date' =>date('Y-m-d'),
							'wo_edit_request_status'=>0,
							'wo_edit_request_approved_by'=>0
						);
						$orderRow= $this->workorder_model->get_work_order($this->input->post('order_id'));
						$log_desc="Work order updated [".$orderRow['orderform_number']."] : Fields are  ";
						if($this->input->post('wo_customer_name')!=$orderRow['wo_customer_name']){ $log_desc.='customer,'; }
						if($this->input->post('wo_order_nature_id')!=$orderRow['wo_order_nature_id']){ $log_desc.='order nature,'; }
						if($wo_dispatch_date!=$orderRow['wo_dispatch_date']){ $log_desc.='dispatch date,'; }
						if($this->input->post('wo_shipping_cost')!=$orderRow['wo_shipping_cost']){ $log_desc.='shipping cost,'; }
						if($this->input->post('wo_additional_cost')!=$orderRow['wo_additional_cost']){ $log_desc.='additional cost,'; }
						if($this->input->post('wo_additional_cost_desc')!=$orderRow['wo_additional_cost_desc']){ $log_desc.='additional cost description,'; }
						if($this->input->post('wo_tax_id')!=$orderRow['wo_tax_id']){ $log_desc.='tax,'; }
						if($this->input->post('wo_adjustment')!=$orderRow['wo_adjustment']){ $log_desc.='adjustment,'; }
						if($this->input->post('wo_advance')!=$orderRow['wo_advance']){ $log_desc.='advance,'; }
						
						$log_data = array(
							'log_title'=>'Offline work order updated ['.$orderRow['orderform_number'].']',			  
							'log_controller' => 'work',
							'log_function' => 'production_edit',
							'log_module' => 'Work Order Offline',
							'log_desc' => $log_desc,
							'log_updated_by' => $this->session->userdata('loginid')
						);
						$this->log_model->insert_log_data($log_data);
						$result = $this->workorder_model->update_wo_data($orderData,$this->input->post('order_id'));
						$wo_order_id=$this->input->post('order_id');
						$wo_item_query="";
						redirect('work/production_edit_details/'.$orderRow['order_uuid']);
					}else{
						$this->session->set_flashdata('error','Work order number already taken');
					}
				}else{
					$this->session->set_flashdata('error','Work order already created with this lead');	
				}
			}
		}
		
		$accessArray=$this->rbac->check_operation_access_my_account('workorder');
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("edit_request",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		$row= $this->workorder_model->get_order_data_by_uuid($id);
		//print_r($row);
		if($row==""){
			$this->session->set_flashdata('error','Invalid work order.');
			redirect('workorder/index');
		}else{
			if($row['wo_status_value']==1 && $row['wo_edit_request_approved_by']==0 ){ 
				$this->session->set_flashdata('error','Work order already submitted to production department.');
				redirect('workorder/index');
			}
		}
		$data['woRow']=$row;
		//$data['priority']= $this->workorder_model->get_all_active_priority();
		//$data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
		$leadData= $this->leads_model->get_leads_data_by_id($row['lead_id']);
		$data['lead_info']=$leadData;
		$data['summary'] = $this->workorder_model->get_order_summary($row['order_id']);
		$data['order_types'] = $this->workorder_model->get_order_types();
		$data['fabric_types'] = $this->workorder_model->get_fabric_types();
		$data['collar_types'] = $this->workorder_model->get_collar_types();
		$data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
		$data['product_types'] = $this->workorder_model->get_product_types();
		$data['order_nature'] = $this->workorder_model->get_order_nature();
		$data['addons'] = $this->workorder_model->get_addons();
		$data['taxclass'] = $this->workorder_model->get_taxclass();
		$data['view']='workorder/production_edit_offline';
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
		$log_desc="Offline work order (".$row['orderform_number'].") approved by ".$luser." on ".$now;
		$log_data = array(
			'log_title'=>'Offline work edit approved ['.$row['orderform_number'].']',	  			  
			'log_timestamp'=>$now,
			'log_controller' => 'work',
			'log_function' => 'approve_request',
			'log_module' => 'Work order',
			'log_desc' => $log_desc,
			'log_updated_by' => $this->session->userdata('loginid')
		);
		$this->log_model->insert_log_data($log_data);
		$this->session->set_flashdata('success','Edit request approved successfully.');	
		redirect('workorder/index');
		 
	}

	function approve_request_dashboard($id=0){
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
		$log_desc="Offline work order (".$row['orderform_number'].") approved by ".$luser." on ".$now;
		$log_data = array(
			'log_title'=>'Offline work edit approved ['.$row['orderform_number'].']',	  			  
			'log_timestamp'=>$now,
			'log_controller' => 'work',
			'log_function' => 'approve_request',
			'log_module' => 'Work order',
			'log_desc' => $log_desc,
			'log_updated_by' => $this->session->userdata('loginid')
		);
		$this->log_model->insert_log_data($log_data);
		$this->session->set_flashdata('success','Edit request approved successfully.');	
		redirect('myaccount/index');
		 
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
		$log_desc="Offline work order (".$row['orderform_number'].") edit requested by ".$luser." on ".$now;
		$log_data = array(
			'log_title'=>'Offline work edit requested ['.$row['orderform_number'].']',	  
			'log_timestamp'=>$now,
			'log_controller' => 'work',
			'log_function' => 'edit_request',
			'log_module' => 'Work order',
			'log_desc' => $log_desc,
			'log_updated_by' => $this->session->userdata('loginid')
		);
		$this->log_model->insert_log_data($log_data);
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

		$this->session->set_flashdata('success','Edit request successfully submitted.');	
		redirect('workorder/index');
		 
	}
	public function wo_json_list(){
			$accessArray=$this->rbac->check_operation_access_my_account('workorder'); 

			$order_type=1;
			$records = $this->workorder_model->get_all_work_orders_json($order_type);
			$data = array();
			$i=0;
			foreach ($records['data']  as $row) 
			{  
				if($row['wo_row_status']==1 && $row['submited_to_production']=='no'){
					$option='<td> ';
					
					if($accessArray){if(in_array("view",$accessArray)){
					$option.='
<a href="'.base_url('workorder/view/'.$row['order_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					}}
					
					if($accessArray){if(in_array("edit",$accessArray)){
$option.='&nbsp;<a href="'.base_url('workorder/edit/'.$row['order_uuid']).'" title="Edit" style="cursor: pointer;"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';
					}}

					if($accessArray){if(in_array("delete",$accessArray)){
$option.='&nbsp;<a title="Delete" onclick="return  deleteRow();" href="'.base_url('workorder/delete/'.$row['order_uuid']).'" style="cursor: pointer;" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';
					}}

					if($accessArray){if(in_array("production",$accessArray)){
$option.='&nbsp;<a title="Submit To Production"  href="'.base_url('workorder/production/'.$row['order_uuid']).'" ><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-mail-forward" ></i></label></a>';
					}}
					
					$option.='</td>';
					
					
				}else{
					$option='<td> ';
					if($accessArray){if(in_array("view",$accessArray)){
					$option.='<a href="'.base_url('workorder/view/'.$row['order_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					}}
					
					if($row['wo_edit_request_status']==0){
						if($row['wo_edit_request_approved_by']==0){
							if($accessArray){if(in_array("edit_request",$accessArray)){
							$option.='&nbsp;<a title="Edit Request"  onclick="return  editRow();" href="'.base_url('work/edit_request/'.$row['order_uuid']).'" ><label class="badge badge-outline-warning" title="Edit Request" ><i class="fa fa-edit" ></i></label></a>';
							}}
						}else{
							if($accessArray){if(in_array("edit",$accessArray)){
$option.='&nbsp;<a href="'.base_url('work/production_edit/'.$row['order_uuid']).'" title="Edit" style="cursor: pointer;"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';
							}}
							
						}
					}else{
						if(in_array("edit_approval",$accessArray)){
											$option.='<a title="Approve Edit Request"  onclick="return  approveEditRow();" href="'.base_url('work/approve_request/'.$row['order_uuid']).'" ><label class="badge badge-outline-warning ml-1" title="Approve Edit Request" >Approve</label></a>';
						}else{
							$option.='<label class="badge badge-outline-warning ml-1" title="Waiting" ><i class="fa fa-eye-slash" ></i></label></a>';
						}
					}
					
					if($accessArray){if(in_array("delete",$accessArray)){
$option.='&nbsp;<a title="Delete" onclick="return  deleteRow();" href="'.base_url('workorder/delete/'.$row['order_uuid']).'" style="cursor: pointer;" ><label class="badge badge-danger mr-1" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';
					}}
					
					
					
					$option.='</td>';
				}
				
		
				
				$data[]= array(
					
					$row['orderform_number'],
					$row['customer_name']."<br/>".$row['customer_email']."<br/>".$row['customer_mobile_no'],
					$row['staff_code']." : ".$row['staff_name'],
					substr($row['wo_date_time'],0,10),
					
					date("d-m-Y", strtotime($row['wo_dispatch_date'])),
					
					'<td ><label class="'.$row['style_class'].'">'.$row['wo_status_title'].'</label></td>',
					$option
				);
			}
			$records['data']=$data;
			echo json_encode($records);						   
	}
	
}
