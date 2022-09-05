<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Workorder extends CI_Controller {
  public function __construct(){ 
	  parent::__construct();
	  $this->load->model('auth_model', 'auth_model');
	  $this->load->model('workorder_model', 'workorder_model');
	  $this->load->model('schedule_model', 'schedule_model');
	  $this->load->model('settings_model', 'settings_model');
	  $this->load->model('leads_model', 'leads_model');
	  $this->load->model('common_model', 'common_model');
	  $this->load->model('formdata_model', 'formdata_model');
	$this->load->model('dispatch_model', 'dispatch_model');
		 $this->load->model('notification_model', 'notification_model');
		 $this->load->library('msg91');
	  $this->load->library('datatable');
	  if(!$this->session->has_userdata('loginid')){
		  redirect('auth/login');
	  }
	/*$summary_addons=$this->formdata_model->get_all_wo_addons();
	foreach($summary_addons as $nwAddon){
		$addon_row=$this->settings_model->get_addons_data($nwAddon['wo_addon_id']);
		$addon_id=$addon_row['addon_id'];
		$wo_addon_name=$addon_row['addon_name'];
		$wo_addon_value=$addon_row['addon_amount'];
		$wo_addon_making_min=$addon_row['addon_making_min'];
		$order_summary_id=$nwAddon['order_summary_id'];
		$up="UPDATE wo_order_summary SET wo_item_addons='$addon_id',wo_item_addons_names='$wo_addon_name',wo_item_addons_mk_time='$wo_addon_making_min',wo_item_addons_mk_amt='$wo_addon_value' WHERE order_summary_id='$order_summary_id' ";
		$query = $this->db->query($up);	
	}*/
		
  }
	public function edit($id=0){
	 
	  $accessArray=$this->rbac->check_operation_access(); // check opration permission
	  if($accessArray==""){
		  redirect('access/not_found');
	  }else{
		  if($accessArray){if(!in_array("edit",$accessArray)){
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
		  if($row['wo_status_value']==1){
			  $this->session->set_flashdata('error','Work order alredy submitted to production department.');
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
	  $data['view']='workorder/edit_new';
	  $this->load->view('layout',$data);
  }
	public function update_order_summary_in_detail_online(){
	  if($this->input->post('summary_parent')==0){
		  $this->form_validation->set_rules('customer_mobile_no','Mobile Number', 'trim|required');
		  $this->form_validation->set_rules('customer_name', 'Name', 'trim|required');
		  $this->form_validation->set_rules('customer_email', 'Email', 'trim|required');
		  $this->form_validation->set_rules('wo_ref_no','Reference Number', 'trim|required');
		  $this->form_validation->set_rules('wo_shipping_address', 'Shipping Address', 'trim|required');
	  }
	  $this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
	  if ($this->form_validation->run() == TRUE) {
				$item_addons="";
				$item_addons_names="";
				$item_addons_mk_time=0;
				$item_addons_mk_amt=0;
				if($_POST['addons_ids']){
				$aInc=0;
				  foreach($_POST['addons_ids'] as $addons){
					$addon_row=$this->settings_model->get_addons_data($addons);
					$wo_addon_name=$addon_row['addon_name'];
					$wo_addon_value=$addon_row['addon_amount'];
					$wo_addon_making_min=$addon_row['addon_making_min'];

					$item_addons_mk_time=$item_addons_mk_time+$wo_addon_making_min;
					$item_addons_mk_amt=$item_addons_mk_amt+$wo_addon_value;
		
				 	if($aInc==0){
					$item_addons=$addons;
					$item_addons_names=$wo_addon_name;
					 }else{
					$item_addons.=",".$addons;
					$item_addons_names.=",".$wo_addon_name;
					}
					$aInc++;
					}
				}
		      $option_session_id=$this->input->post('wo_option_session_id');
			  $option_login_id=$this->session->userdata('loginid');;
			  $Option_qty=0;
			  if($_POST['options']){
				  
				  $sizerow=$this->workorder_model->remove_order_option_item_by_summary_id($this->input->post('order_summary_id'));
				  
				  $option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id) VALUES ";
				  $option_count=0;
				  foreach($_POST['options'] as $options_item){
					  $option_name=trim(addslashes(htmlentities($options_item['option_name'])));
					  $option_number=trim(addslashes(htmlentities($options_item['option_number'])));
					  $option_size_id=trim(addslashes(htmlentities($options_item['option_size'])));
					  $option_size_id=trim(addslashes(htmlentities($options_item['option_size'])));
					  $option_fit=trim(addslashes(htmlentities($options_item['option_fit'])));
					  $option_info=trim(addslashes(htmlentities($options_item['option_info'])));
					  $size_row=$this->workorder_model->get_product_size_data($option_size_id);
					  $option_size_value=$size_row['product_size_name'];
					  $option_qty=trim(addslashes(htmlentities($options_item['option_qty'])));
					  $Option_qty=$Option_qty+$option_qty;
					  
					  if($option_count==0){
						  $option_query.=" (NULL, '".$this->input->post('order_summary_id')."', '0', '".$this->input->post('wo_order_id')."', '0', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id')";
					  }else{
						  $option_query.=",(NULL,'".$this->input->post('order_summary_id')."', '0', '".$this->input->post('wo_order_id')."','0', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id')";
					  }
					  $option_count++;
				  }
				  if($option_query!=""){
					  $summary = $this->workorder_model->insert_wo_options($option_query);
				  }
			  }
		  
			  $wo_product_type_id=$this->input->post('wo_product_type_id');
			  $product_type_row=$this->settings_model->get_producttype_data($wo_product_type_id);
			  $wo_product_type_name=$product_type_row['product_type_name'];
			  $wo_product_type_value=$product_type_row['product_type_amount'];
			  $wo_product_making_time=$product_type_row['product_making_time'];
			  
			  $wo_collar_type_id=$this->input->post('wo_collar_type_id');
			  $collar_type_row=$this->settings_model->get_collartype_data($wo_collar_type_id);
			  $wo_collar_type_name=$collar_type_row['collar_type_name'];
			  $wo_collar_type_value=$collar_type_row['collar_amount'];
			  $wo_collar_making_min=$collar_type_row['collar_making_min'];
			  
			  $wo_sleeve_type_id=$this->input->post('wo_sleeve_type_id');
			  $sleeve_type_row=$this->settings_model->get_sleevetype_data($wo_sleeve_type_id);
			  $wo_sleeve_type_name=$sleeve_type_row['sleeve_type_name'];
			  $wo_sleeve_type_value=$sleeve_type_row['sleeve_type_amount'];
			  $wo_sleeve_making_time=$sleeve_type_row['sleeve_making_time'];
			  
			  $wo_fabric_type_id=$this->input->post('wo_fabric_type_id');
			  $fabric_type_row=$this->settings_model->get_fabrictype_data($wo_fabric_type_id);
			  $wo_fabric_type_name=$fabric_type_row['fabric_type_name'];
			  $wo_fabric_type_value=$fabric_type_row['fabric_amount'];
			  $wo_fabric_making_min=$fabric_type_row['fabric_making_min'];
			  
			  $wo_addon_id=$this->input->post('wo_addon_id');
			  $addon_row=$this->settings_model->get_addons_data($wo_addon_id);
			  $wo_addon_name=$addon_row['addon_name'];
			  $wo_addon_value=$addon_row['addon_amount'];
			  $wo_addon_making_min=$addon_row['addon_making_min'];
			  $summary_client_name=$this->input->post('customer_name').",".$this->input->post('customer_mobile_no');				
			  $draft_data = array(
				  'summary_client_id' => $this->input->post('summary_client_id'),
				  'summary_client_mobile' => $this->input->post('customer_mobile_no'),
				  'summary_client_name_only' => $this->input->post('customer_name'),
				  'summary_client_email' => $this->input->post('customer_email'),
				  'summary_client_name' => $summary_client_name,
				  'wo_ref_no' => $this->input->post('wo_ref_no'),
				  'wo_product_type_id' => $wo_product_type_id,
				  'wo_product_type_name' => $wo_product_type_name,
				  'wo_product_type_value' => $wo_product_type_value,
				  'wo_product_making_time' => $wo_product_making_time,
				  
				  'wo_collar_type_id' => $wo_collar_type_id,
				  'wo_collar_type_name' => $wo_collar_type_name,
				  'wo_collar_type_value' => $wo_collar_type_value,
				  'wo_collar_making_min' => $wo_collar_making_min,
				  
				  'wo_sleeve_type_id' => $wo_sleeve_type_id,
				  'wo_sleeve_type_name' => $wo_sleeve_type_name,
				  'wo_sleeve_type_value' => $wo_sleeve_type_value,
				  'wo_sleeve_making_time' => $wo_sleeve_making_time,
				  
				  'wo_fabric_type_id' => $wo_fabric_type_id,
				  'wo_fabric_type_name' => $wo_fabric_type_name,
				  'wo_fabric_type_value' => $wo_fabric_type_value,
				  'wo_fabric_making_min' => $wo_fabric_making_min,
				  
				  'wo_addon_id' => $wo_addon_id,
				  'wo_addon_name' => $wo_addon_name,
				  'wo_addon_value' => $wo_addon_value,
				  'wo_addon_making_min' => $wo_addon_making_min,
				  
				  'wo_qty' => $Option_qty,
				  'wo_shipping_type_id' => $this->input->post('wo_shipping_type_id'),
				  'wo_img_back' => $this->input->post('wo_img_back'),
				  'wo_img_front' => $this->input->post('wo_img_front'),
				  'wo_remark' => $this->input->post('wo_remark'),
				  'wo_shipping_address' => $this->input->post('wo_shipping_address'),
				  'wo_item_addons' => $item_addons,
				  'wo_item_addons_names'=>$item_addons_names,
				  'wo_item_addons_mk_time'=>$item_addons_mk_time,
				  'wo_item_addons_mk_amt'=>$item_addons_mk_amt,
			  );
			  $rs = $this->workorder_model->update_online_summary_item_data($draft_data,$this->input->post('order_summary_id'));
			  //if($this->input->post('online_draft_parent_id')==0){
				  //$draft_data1 = array(
				  //'wo_ref_no' => $this->input->post('wo_ref_no'),
				  //);
				  //$this->workorder_model->update_summary_child_parent($draft_data1,$this->input->post('online_draft_id'));
			  //}
			  //$this->session->set_flashdata('success_draft','Order summary updated successfully');
			  $responseMsg='<div class="alert alert-success" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			  Order summary updated!!!</div>';
			  echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
		  
	  }else{
			  //echo $this->session->flashdata('error');
		  $responseMsg='<div class="alert alert-danger" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			  Enter all required inputs!!!</div>';
		  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
	  }
  }
  function edit_summary_item($order_summary_id=0){
	  //$data['view']='workorder/onlinemodel';
	  $data['product_size'] = $this->workorder_model->get_product_size();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  $data['shipping_types'] = $this->workorder_model->get_shipping_types();
	  $data['order_summary_id'] = $order_summary_id;
	  $this->load->view('workorder/edit_summary_model',$data);
  }
	public function edit_online($id=0){
	 
	  $moduleData=$this->rbac->check_operation_access(); // check opration permission
	  $data['title']=$moduleData['module_parent']." | ONLINE WORK ORDER";
	  $data['title_head']='ONLINE WORK ORDER';
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	  //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('error','Invalid work order.');
		  redirect('workorder/wo_online');
	  }
	  $data['woRow']=$row;
	  
	  
	  
	  $data['summary'] = $this->workorder_model->get_order_summary_in_detail_online($row['order_id']);
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  
	  $data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
	  $data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
	  $data['view']='workorder/edit_online';
	  $this->load->view('layout',$data);
	  
  }
	public function online_ajax_post_edit(){
	  if($this->input->post('online_draft_parent_id')==0){
		  $this->form_validation->set_rules('customer_mobile_no','Mobile Number', 'trim|required');
		  $this->form_validation->set_rules('customer_name', 'Name', 'trim|required');
		  $this->form_validation->set_rules('customer_email', 'Email', 'trim|required');
		  $this->form_validation->set_rules('wo_shipping_address', 'Shipping Address', 'trim|required');
	  }
	  $this->form_validation->set_rules('wo_ref_no','Reference Number', 'trim|required');
	  //$this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
	  if ($this->form_validation->run() == TRUE) {
			  $wo_current_form_no=$this->input->post('wo_current_form_no');
			  $online_draft_id=$this->input->post('online_draft_id');
			  
			  $current_s_id=$this->input->post('current_s_id');
			  $current_l_id=$this->input->post('current_l_id');
			  $Option_qty=0;
			  if($_POST['options']){
				  $sizerow=$this->workorder_model->remove_order_option_item($online_draft_id,$wo_current_form_no);
				  $option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id) VALUES ";
				  $option_count=0;
				  foreach($_POST['options'] as $options_item){
					  $option_name=trim(addslashes(htmlentities($options_item['option_name'])));
					  $option_number=trim(addslashes(htmlentities($options_item['option_number'])));
					  $option_size_id=trim(addslashes(htmlentities($options_item['option_size'])));
					  $option_fit=trim(addslashes(htmlentities($options_item['option_fit'])));
					  $option_info=trim(addslashes(htmlentities($options_item['option_info'])));
					  $size_row=$this->workorder_model->get_product_size_data($option_size_id);
					  $option_size_value=$size_row['product_size_name'];
					  $option_qty=trim(addslashes(htmlentities($options_item['option_qty'])));
					  $Option_qty=$Option_qty+$option_qty;
					  if($option_count==0){
						  $option_query.=" (NULL, '0', '$online_draft_id', '0', '$wo_current_form_no', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$current_s_id','$current_l_id')";
					  }else{
						  $option_query.=",(NULL, '0', '$online_draft_id', '0', '$wo_current_form_no', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$current_s_id','$current_l_id')";
					  }
					  $option_count++;
				  }
				  if($option_query!=""){
					  $summary = $this->workorder_model->insert_wo_options($option_query);
				  }
			  }
			  
			  $item_addons="";
			  $item_addons_names="";
			  $item_addons_mk_time=0;
			  $item_addons_mk_amt=0;
			  if($_POST['addons_ids']){
			  $aInc=0;
				  foreach($_POST['addons_ids'] as $addons){
					$addon_row=$this->settings_model->get_addons_data($addons);
					$wo_addon_name=$addon_row['addon_name'];
					$wo_addon_value=$addon_row['addon_amount'];
					$wo_addon_making_min=$addon_row['addon_making_min'];
					$item_addons_mk_time=$item_addons_mk_time+$wo_addon_making_min;
					$item_addons_mk_amt=$item_addons_mk_amt+$wo_addon_value;

					  if($aInc==0){
					  	$item_addons=$addons;
						$item_addons_names=$wo_addon_name;
					  }else{
					  	$item_addons.=",".$addons;
						$item_addons_names.=",".$wo_addon_name;
					  }
						$aInc++;
				  }
			  }
			  $draft_data = array(
				  'customer_id' => $this->input->post('customer_id'),
				  'customer_mobile_no' => $this->input->post('customer_mobile_no'),
				  'customer_name' => $this->input->post('customer_name'),
				  'customer_email' => $this->input->post('customer_email'),
				  'wo_ref_no' => $this->input->post('wo_ref_no'),
				  'wo_product_type_id' => $this->input->post('wo_product_type_id'),

				  'wo_collar_type_id' => $this->input->post('wo_collar_type_id'),
				  'wo_sleeve_type_id' => $this->input->post('wo_sleeve_type_id'),
				  'wo_fabric_type_id' => $this->input->post('wo_fabric_type_id'),
				  'wo_addon_id' => $this->input->post('wo_addon_id'),
				  'wo_qty' => $Option_qty,
				  'wo_shipping_type_id' => $this->input->post('wo_shipping_type_id'),
				  'wo_img_back' => $this->input->post('wo_img_back'),
				  'wo_img_front' => $this->input->post('wo_img_front'),
				  'wo_remark' => $this->input->post('wo_remark'),
				  'wo_shipping_address' => $this->input->post('wo_shipping_address'),
				  'item_addons' => $item_addons,
				  'item_addons_names'=>$item_addons_names,
				  'item_addons_mk_time'=>$item_addons_mk_time,
				  'item_addons_mk_amt'=>$item_addons_mk_amt,
			  );
			  $rs = $this->workorder_model->update_online_draft_data($draft_data,$this->input->post('online_draft_id'));
			  if($this->input->post('online_draft_parent_id')==0){
				  $draft_data1 = array(
				  'wo_ref_no' => $this->input->post('wo_ref_no'),
				  );
				  $this->workorder_model->update_summary_child_parent($draft_data1,$this->input->post('online_draft_id'));
			  }
			  $this->session->set_flashdata('success_draft','Order summary updated successfully');
			  echo json_encode(array('responseCode'=>"success"));
	  }else{
			  //echo $this->session->flashdata('error');
			  //echo validation_errors();
		  $responseMsg='<div class="alert alert-danger" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>'.validation_errors().'</div>';
		  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
	  }
  }
  public function online_ajax_post(){
		  //echo 'yrsss';
	  //if($this->input->post('submit')){
		  if($this->input->post('online_draft_parent_id')==0){
		  $this->form_validation->set_rules('customer_mobile_no','Mobile Number', 'trim|required');
		  $this->form_validation->set_rules('customer_name', 'Name', 'trim|required');
		  $this->form_validation->set_rules('customer_email', 'Email', 'trim|required');
		  $this->form_validation->set_rules('wo_ref_no','Reference Number', 'trim|required');
		  $this->form_validation->set_rules('wo_shipping_address', 'Shipping Address', 'trim|required');
		  //echo $this->input->post('wo_ref_no');
		  //echo $this->input->post('current_woid');
			  $refDatas= $this->workorder_model->chk_ref_no_exist($this->input->post('wo_ref_no'),$this->input->post('current_woid'));
			  //print_r($refDatas);
			  if($refDatas['online_draft_id']!=""){
				  $responseMsg='<div class="alert alert-danger" style="width:100%;">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
				  Order Form Reference Number Already Exist!!!
				  </div>';
				  //echo $responseMsg;
				  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
				  exit;
			  }
			  //echo 'yrsss2';exit;
		  }
		  $this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
		  if ($this->form_validation->run() == TRUE) {
			  $item_addons="";
			  $item_addons_names="";
			  $item_addons_mk_time=0;
			  $item_addons_mk_amt=0;
			  if($_POST['addons_ids']){
			  $aInc=0;
				  foreach($_POST['addons_ids'] as $addons){
					$addon_row=$this->settings_model->get_addons_data($addons);
					$wo_addon_name=$addon_row['addon_name'];
					$wo_addon_value=$addon_row['addon_amount'];
					$wo_addon_making_min=$addon_row['addon_making_min'];
					$item_addons_mk_time=$item_addons_mk_time+$wo_addon_making_min;
					$item_addons_mk_amt=$item_addons_mk_amt+$wo_addon_value;

					  if($aInc==0){
					  	$item_addons=$addons;
						$item_addons_names=$wo_addon_name;
					  }else{
					  	$item_addons.=",".$addons;
						$item_addons_names.=",".$wo_addon_name;
					  }
						$aInc++;
				  }
			  }
			  $draft_data = array(
				  'current_form_id' => $this->input->post('current_woid'),
				  'online_draft_parent_id' => $this->input->post('online_draft_parent_id'),
				  'customer_id' => $this->input->post('customer_id'),
				  'customer_mobile_no' => $this->input->post('customer_mobile_no'),
				  'customer_name' => $this->input->post('customer_name'),
				  'customer_email' => $this->input->post('customer_email'),
				  'wo_ref_no' => $this->input->post('wo_ref_no'),
				  'wo_product_type_id' => $this->input->post('wo_product_type_id'),
				  'wo_collar_type_id' => $this->input->post('wo_collar_type_id'),
				  'wo_sleeve_type_id' => $this->input->post('wo_sleeve_type_id'),
				  'wo_fabric_type_id' => $this->input->post('wo_fabric_type_id'),
				  'wo_addon_id' => $this->input->post('wo_addon_id'),
				  'wo_qty' => $this->input->post('wo_qty'),
				  'wo_shipping_type_id' => $this->input->post('wo_shipping_type_id'),
				  'wo_img_back' => $this->input->post('wo_img_back'),
				  'wo_img_front' => $this->input->post('wo_img_front'),
				  'wo_remark' => $this->input->post('wo_remark'),
				  'wo_shipping_address' => $this->input->post('wo_shipping_address'),
				  'current_session_id' => $this->input->post('current_s_id'),
				  'current_login_id' => $this->input->post('current_l_id'),
				  'item_addons'=>$item_addons,
				  'item_addons_names'=>$item_addons_names,
				  'item_addons_mk_time'=>$item_addons_mk_time,
				  'item_addons_mk_amt'=>$item_addons_mk_amt,
			  );
			  $online_draft_id= $this->workorder_model->insert_online_draft_data($draft_data);
			  $draftRow=$this->workorder_model->get_online_draft_only($online_draft_id);
			  $current_form_id=$draftRow['current_form_id'];
			  $Option_qty=0;
			  if($_POST['options']){
				  $option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id) VALUES ";
				  $option_count=0;
				  $option_session_id=$this->input->post('current_s_id');
				  $option_login_id=$this->input->post('current_l_id');
				  foreach($_POST['options'] as $options_item){
					  $option_name=trim(addslashes(htmlentities($options_item['option_name'])));
					  $option_number=trim(addslashes(htmlentities($options_item['option_number'])));
					  $option_size_id=trim(addslashes(htmlentities($options_item['option_size'])));
					  $option_fit=trim(addslashes(htmlentities($options_item['option_fit'])));
					  $option_info=trim(addslashes(htmlentities($options_item['option_info'])));
					  $size_row=$this->workorder_model->get_product_size_data($option_size_id);
					  $option_size_value=$size_row['product_size_name'];
					  $option_qty=trim(addslashes(htmlentities($options_item['option_qty'])));
					  $Option_qty=$Option_qty+$option_qty;
					  if($option_count==0){
						  $option_query.=" (NULL, '0', '$online_draft_id', '0', '$current_form_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id')";
					  }else{
						  $option_query.=",(NULL, '0', '$online_draft_id', '0', '$current_form_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id')";
					  }
					  $option_count++;
				  }
				  //echo $option_query;exit;
				  if($option_query!=""){
					  $summary = $this->workorder_model->insert_wo_options($option_query);
					  $draft_data2 = array(
						  'wo_qty' => $Option_qty
					  );
					  $summary2 = $this->workorder_model->update_online_draft_data($draft_data2,$online_draft_id);
				  }
			  }
			  $this->session->set_flashdata('success_draft','Order summary saved successfully');
			  //redirect('workorder/online/'.$this->input->post('current_woid'));
			  echo json_encode(array('responseCode'=>"success"));
		  }else{
			  //echo $this->session->flashdata('error');
			  $responseMsg='
			  <div class="alert alert-warning alert-dismissible" style="width:100%;">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
			  '.validation_errors().'
			  </div>';
			  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
		  }
	  //}
  }
  public function draft_data(){
	  $current_id=$_POST['current_id'];
	  $csession_id=$this->session->userdata('log_session_id');
	  $current_l_id=$this->session->userdata('loginid');;
	  //echo $csession_id."==".$current_l_id;
	  $data['summary_drafts'] = $this->workorder_model->get_summary_draft_latest($current_id,$csession_id,$current_l_id);
	  //$data['view']='workorder/online';
	  $this->load->view('workorder/online_draft_data',$data);
  }
  
  //
  public function remove_summary_in_edit($sid=0){
	  $refData = $this->workorder_model->get_summary_item_data($sid);
	  $wo_order_id=$refData['wo_order_id'];
	  if($refData['summary_parent']==0){
		  $this->workorder_model->remove_summary_item_in_edit($sid,'');
		  $this->workorder_model->remove_summary_item_in_edit($sid,'child');
	  }else{
		  $this->workorder_model->remove_summary_item_in_edit($sid,'');
	  }
	  $data['summary'] = $this->workorder_model->get_order_summary_in_detail_online($wo_order_id);
	  $data['wo_order_id'] =$wo_order_id;
	  //$data['view']='workorder/online';
	  $this->load->view('workorder/summary_items_ajax_data',$data);
	  
  }
  public function save_new_summary(){
	  if($this->input->post('summary_parent')==0){
		  //echo 'gg';
		  $this->form_validation->set_rules('customer_mobile_no','Mobile Number', 'trim|required');
		  $this->form_validation->set_rules('customer_name', 'Name', 'trim|required');
		  $this->form_validation->set_rules('customer_email', 'Email', 'trim|required');
		  $this->form_validation->set_rules('wo_ref_no','Reference Number', 'trim|required');
		  $this->form_validation->set_rules('wo_shipping_address', 'Shipping Address', 'trim|required');
	  }
	  $this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
	  if ($this->form_validation->run() == TRUE) {
			  $item_addons="";
			  $item_addons_names="";
			  $item_addons_mk_time=0;
			  $item_addons_mk_amt=0;
		  if($_POST['addons_ids']){
		  $aInc=0;
			  foreach($_POST['addons_ids'] as $addons){
				$addon_row=$this->settings_model->get_addons_data($addons);
				$wo_addon_name=$addon_row['addon_name'];
				$wo_addon_value=$addon_row['addon_amount'];
				$wo_addon_making_min=$addon_row['addon_making_min'];

				$item_addons_mk_time=$item_addons_mk_time+$wo_addon_making_min;
				$item_addons_mk_amt=$item_addons_mk_amt+$wo_addon_value;

				  if($aInc==0){
					$item_addons=$addons;
					$item_addons_names=$wo_addon_name;
				  }else{
					$item_addons.=",".$addons;
					$item_addons_names.=",".$wo_addon_name;
				  }
					$aInc++;
			}
		}

			  $wo_product_type_id=$this->input->post('wo_product_type_id');
			  $product_type_row=$this->settings_model->get_producttype_data($wo_product_type_id);
			  $wo_product_type_name=$product_type_row['product_type_name'];
			  $wo_product_type_value=$product_type_row['product_type_amount'];
			  $wo_product_making_time=$product_type_row['product_making_time'];
			  
			  $wo_collar_type_id=$this->input->post('wo_collar_type_id');
			  $collar_type_row=$this->settings_model->get_collartype_data($wo_collar_type_id);
			  $wo_collar_type_name=$collar_type_row['collar_type_name'];
			  $wo_collar_type_value=$collar_type_row['collar_amount'];
			  $wo_collar_making_min=$collar_type_row['collar_making_min'];
			  
			  $wo_sleeve_type_id=$this->input->post('wo_sleeve_type_id');
			  $sleeve_type_row=$this->settings_model->get_sleevetype_data($wo_sleeve_type_id);
			  $wo_sleeve_type_name=$sleeve_type_row['sleeve_type_name'];
			  $wo_sleeve_type_value=$sleeve_type_row['sleeve_type_amount'];
			  $wo_sleeve_making_time=$sleeve_type_row['sleeve_making_time'];
			  
			  $wo_fabric_type_id=$this->input->post('wo_fabric_type_id');
			  $fabric_type_row=$this->settings_model->get_fabrictype_data($wo_fabric_type_id);
			  $wo_fabric_type_name=$fabric_type_row['fabric_type_name'];
			  $wo_fabric_type_value=$fabric_type_row['fabric_amount'];
			  $wo_fabric_making_min=$fabric_type_row['fabric_making_min'];
			  
			  $wo_addon_id=$this->input->post('wo_addon_id');
			  $addon_row=$this->settings_model->get_addons_data($wo_addon_id);
			  $wo_addon_name=$addon_row['addon_name'];
			  $wo_addon_value=$addon_row['addon_amount'];
			  $wo_addon_making_min=$addon_row['addon_making_min'];
			  $summary_client_name=$this->input->post('customer_name').",".$this->input->post('customer_mobile_no');
			  $draft_data = array(
				  'wo_order_id' => $this->input->post('order_id'),
				  'summary_parent' => $this->input->post('summary_parent'),
				  'summary_client_id' => $this->input->post('customer_id'),
				  'summary_client_mobile' => $this->input->post('customer_mobile_no'),
				  'summary_client_name_only' => $this->input->post('customer_name'),
				  'summary_client_email' => $this->input->post('customer_email'),
				  'summary_client_name' => $summary_client_name,
				  'wo_ref_no' => $this->input->post('wo_ref_no'),
				  'wo_product_type_id' => $wo_product_type_id,
				  'wo_product_type_name' => $wo_product_type_name,
				  'wo_product_type_value' => $wo_product_type_value,
				  'wo_product_making_time' => $wo_product_making_time,
				  
				  'wo_collar_type_id' => $wo_collar_type_id,
				  'wo_collar_type_name' => $wo_collar_type_name,
				  'wo_collar_type_value' => $wo_collar_type_value,
				  'wo_collar_making_min' => $wo_collar_making_min,
				  
				  'wo_sleeve_type_id' => $wo_sleeve_type_id,
				  'wo_sleeve_type_name' => $wo_sleeve_type_name,
				  'wo_sleeve_type_value' => $wo_sleeve_type_value,
				  'wo_sleeve_making_time' => $wo_sleeve_making_time,
				  
				  'wo_fabric_type_id' => $wo_fabric_type_id,
				  'wo_fabric_type_name' => $wo_fabric_type_name,
				  'wo_fabric_type_value' => $wo_fabric_type_value,
				  'wo_fabric_making_min' => $wo_fabric_making_min,
				  
				  'wo_addon_id' => $wo_addon_id,
				  'wo_addon_name' => $wo_addon_name,
				  'wo_addon_value' => $wo_addon_value,
				  'wo_addon_making_min' => $wo_addon_making_min,
				  
				  'wo_qty' => 1,
				  'wo_shipping_type_id' => $this->input->post('wo_shipping_type_id'),
				  'wo_img_back' => $this->input->post('wo_img_back'),
				  'wo_img_front' => $this->input->post('wo_img_front'),
				  'wo_remark' => $this->input->post('wo_remark'),
				  'wo_shipping_address' => $this->input->post('wo_shipping_address'),
					'wo_item_addons' => $item_addons,
					'wo_item_addons_names' =>$item_addons_names,
					'wo_item_addons_mk_time' => $item_addons_mk_time,
					'wo_item_addons_mk_amt' => $item_addons_mk_amt,
					'wo_option_session_id'=>$this->input->post('wo_option_session_id'),
			  );
			  $order_summary_id= $this->workorder_model->create_online_summary_item_data($draft_data);
			  
			  $Option_qty=0;
			  $option_session_id=$this->input->post('wo_option_session_id');
			  $option_login_id=$this->session->userdata('loginid');
			  if($_POST['options']){
				  
				  //$sizerow=$this->workorder_model->remove_order_option_item($online_draft_id,$wo_current_form_no);
				  $option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id) VALUES ";
				  $option_count=0;
				  foreach($_POST['options'] as $options_item){
					  $option_name=trim(addslashes(htmlentities($options_item['option_name'])));
					  $option_number=trim(addslashes(htmlentities($options_item['option_number'])));
					  $option_size_id=trim(addslashes(htmlentities($options_item['option_size'])));
					  $option_fit=trim(addslashes(htmlentities($options_item['option_fit'])));
					  $option_info=trim(addslashes(htmlentities($options_item['option_info'])));

					  $size_row=$this->workorder_model->get_product_size_data($option_size_id);
					  $option_size_value=$size_row['product_size_name'];
					  $option_qty=trim(addslashes(htmlentities($options_item['option_qty'])));
					  $Option_qty=$Option_qty+$option_qty;
					  
					  if($option_count==0){
						  $option_query.=" (NULL, '$order_summary_id', '0', '".$this->input->post('order_id')."', '', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id')";
					  }else{
						  $option_query.=",(NULL, '$order_summary_id', '0', '".$this->input->post('order_id')."', '', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id')";
					  }
					  $option_count++;
				  }
				  if($option_query!=""){
					  $summary = $this->workorder_model->insert_wo_options($option_query);
				  }
			  }
			  
			  $summarydata = array(
			  'wo_qty' => $Option_qty,
			  );
			  $summary = $this->workorder_model->update_online_summary_item_data($summarydata,$order_summary_id);
			  
			  
			  //if($this->input->post('online_draft_parent_id')==0){
				  //$draft_data1 = array(
				  //'wo_ref_no' => $this->input->post('wo_ref_no'),
				  //);
				  //$this->workorder_model->update_summary_child_parent($draft_data1,$this->input->post('online_draft_id'));
			  //}
			  $responseMsg='<div class="alert alert-success" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			  Order summary saved successfully!!!</div>';
		  echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
		  
	  }else{
			  //echo $this->session->flashdata('error');
		  $responseMsg='<div class="alert alert-danger" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			  Enter all required inputs!!!</div>';
		  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
	  }
  }
  function update_new_summary($pORc=0){
	  //$data['view']='workorder/onlinemodel';
	  $data['product_size'] = $this->workorder_model->get_product_size();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  $data['shipping_types'] = $this->workorder_model->get_shipping_types();
	  $data['pORc'] = $pORc;
	  $data['order_id'] = $_POST['order_id'];
	  
	  $this->load->view('workorder/update_new_summary',$data);
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
		  );
		  
		  $this->workorder_model->update_wo_data($data,$this->input->post('order_id'));
		  $responseMsg='<div class="alert alert-success" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			  Order details updated !!!</div>';
		  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
	  }else{
		  $responseMsg='<div class="alert alert-danger" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
			  Enter all required inputs!!!</div>';
		  echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
	  }
  }
  public function summary_items_ajax_data(){
	  $wo_order_id=$_POST['wo_order_id'];
	  $data['summary'] = $this->workorder_model->get_order_summary_in_detail_online($wo_order_id);
	  $data['wo_order_id'] =$wo_order_id;
	  //$data['view']='workorder/online';
	  $this->load->view('workorder/summary_items_ajax_data',$data);
  }
  
  

  
  public function remove_summary_item($sid=0){
	  $refData = $this->workorder_model->get_summary_draft_data($sid);
	  $current_form_id=$refData['current_form_id'];
	  if($refData['online_draft_parent_id']==0){
		  $this->workorder_model->remove_summary_item($sid,'');
		  $this->workorder_model->remove_summary_item($sid,'child');
	  }else{
		  $this->workorder_model->remove_summary_item($sid,'');
	  }
	  $wo_current_form_no=$refData['current_form_id'];
	  $online_draft_id=$refData['online_draft_id'];
	  $sizerow=$this->workorder_model->remove_order_option_item($online_draft_id,$wo_current_form_no);
	  $current_id=$current_form_id;
	  $data['summary_drafts'] = $this->workorder_model->get_summary_draft($current_id);
	  //$data['view']='workorder/online';
	  $this->load->view('workorder/online_draft_data',$data);
  }
//------------------------------------------------------------------------------------------------------------------------------ONLINE START
  public function online($cid=0){
	  $moduleData=$this->rbac->check_operation_access(); // check opration permission
	  if($this->input->post('submit')){
		  $this->form_validation->set_rules('orderform_type_id', 'Order type', 'trim|required');
		  $this->form_validation->set_rules('orderform_number', 'Order number', 'trim|required');
		  $this->form_validation->set_rules('current_wo_id', 'Invalid online order form..', 'trim|required');
		  $dataWorkOrder = array(
			  'orderform_number' => $this->input->post('orderform_number')
		  );
		  $woDataa= $this->workorder_model->check_order_no_exist($dataWorkOrder,'');
		  if(!empty($woDataa)){
		  //print_r($woDataa);
		  if($woDataa['orderform_number']!=""){
			  $this->form_validation->set_rules('orderform_number_exist', 'Order number already exist', 'trim|required');
		  }
		  }
		  $summary_drafts= $this->workorder_model->get_summary_draft_latest($this->input->post('current_wo_id'),$this->input->post('current_session_id'),$this->input->post('current_login_id'));
		  if(empty($summary_drafts)){
			  $this->form_validation->set_rules('Order_summary', 'Order summary', 'trim|required');
		  }
		  if ($this->form_validation->run() == TRUE) {
		      $mobileNos=array();

			  date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
			  $now = date('d-m-Y H:i:s');
			  $wo_date = date('Y-m-d');
			  $wo_dispatch_date1 =$this->input->post('wo_dispatch_date');
			  $wo_dispatch_date=date('Y-m-d', strtotime($wo_dispatch_date1));
				  $orderData = array(
					  'orderform_number' => $this->input->post('orderform_number'),
					  'wo_date_time' => $now,
					  'wo_date' => $wo_date,
					  'orderform_type_id' => $this->input->post('orderform_type_id'),
					  'wo_order_nature_id' => $this->input->post('wo_order_nature_id'),
					  'wo_owner_id' => $this->session->userdata('loginid'),
					  'wo_dispatch_date' =>$wo_dispatch_date,
					  'wo_product_info' => $this->input->post('wo_product_info'),
					  'wo_work_priority_id' => $this->input->post('wo_work_priority_id'),
					  'wo_status_id' =>1,
					  'wo_row_status' => 1,
					  'wo_c_by' => $this->session->userdata('loginid'),
					  'wo_c_date' =>date('Y-m-d'),
					  'submited_to_production' =>'no'
				  );
				  $result = $this->workorder_model->insert_work_order_online($orderData);
				  if($result){ 
					  $wo_order_id=$result;
					  $orderRow= $this->workorder_model->get_work_order($wo_order_id);
					  $pCount=0;
					  $client_ids="";
					  $client_info="";
					  $ref_info="";
					  $this->load->model('customer_model', 'customer_model');
					  $inc=0;
					  if($summary_drafts){
						  foreach($summary_drafts as $wo_item){
							  $wo_product_type_id=trim(addslashes(htmlentities($wo_item['wo_product_type_id'])));
							  $product_type_row=$this->settings_model->get_producttype_data($wo_product_type_id);
							  $wo_product_type_name=$product_type_row['product_type_name'];
							  $wo_product_type_value=$product_type_row['product_type_amount'];
							  $wo_product_making_time=$product_type_row['product_making_time'];
							  $wo_collar_type_id=trim(addslashes(htmlentities($wo_item['wo_collar_type_id'])));
							  $collar_type_row=$this->settings_model->get_collartype_data($wo_collar_type_id);
							  $wo_collar_type_name=$collar_type_row['collar_type_name'];
							  $wo_collar_type_value=$collar_type_row['collar_amount'];
							  $wo_collar_making_min=$collar_type_row['collar_making_min'];
							  $wo_sleeve_type_id=trim(addslashes(htmlentities($wo_item['wo_sleeve_type_id'])));
							  $sleeve_type_row=$this->settings_model->get_sleevetype_data($wo_sleeve_type_id);
							  $wo_sleeve_type_name=$sleeve_type_row['sleeve_type_name'];
							  $wo_sleeve_type_value=$sleeve_type_row['sleeve_type_amount'];
							  $wo_sleeve_making_time=$sleeve_type_row['sleeve_making_time'];
							  $wo_fabric_type_id=trim(addslashes(htmlentities($wo_item['wo_fabric_type_id'])));
							  $fabric_type_row=$this->settings_model->get_fabrictype_data($wo_fabric_type_id);
							  $wo_fabric_type_name=$fabric_type_row['fabric_type_name'];
							  $wo_fabric_type_value=$fabric_type_row['fabric_amount'];
							  $wo_fabric_making_min=$fabric_type_row['fabric_making_min'];
							  $wo_addon_id=trim(addslashes(htmlentities($wo_item['wo_addon_id'])));
							  $addon_row=$this->settings_model->get_addons_data($wo_addon_id);
							  $wo_addon_name=$addon_row['addon_name'];
							  $wo_addon_value=$addon_row['addon_amount'];
							  $wo_addon_making_min=$addon_row['addon_making_min'];
							  $wo_qty=trim(addslashes(htmlentities($wo_item['wo_qty'])));
							  $wo_rate=0;
							  $wo_discount=0;
							  $wo_shipping_type_id=$wo_item['wo_shipping_type_id'];
							  $wo_shipping_address=$wo_item['wo_shipping_address'];
							  $wo_img_back=$wo_item['wo_img_back'];
							  $wo_img_front=$wo_item['wo_img_front'];
							  $wo_remark=$wo_item['wo_remark'];
							  $wo_ref_no=$wo_item['wo_ref_no'];							
							  $online_draft_parent_id=$wo_item['online_draft_parent_id'];
							  if($online_draft_parent_id==0){
								  $customer_id=$wo_item['customer_id'];
								  if($customer_id==0){
							  if (in_array($wo_item['customer_mobile_no'], $mobileNos))
							      {
							      }
							  else{
							  array_push($mobileNos,$wo_item['customer_mobile_no']);
							  }
									  $cus_datachk = array('customer_mobile_no' => $wo_item['customer_mobile_no']);
									  $rowCust= $this->customer_model->check_customer_mobileno_exist($cus_datachk,'');

									  if($rowCust['customer_id']==""){
										  $customer_data = array(
											  'customer_name' => $wo_item['customer_name'],
											  'customer_email' =>$wo_item['customer_email'],
											  'customer_mobile_no' => $wo_item['customer_mobile_no'],
											  'customer_c_by' => $this->session->userdata('loginid'),
											  'customer_c_date' =>date('Y-m-d'),
											  'customer_status' => '1'
										  );
										  $client_id=$this->customer_model->insert_customer_data_from_lead($customer_data);
									  }else{
										  $client_id=$rowCust['customer_id'];
									  }
								  }else{
									  $client_id=$customer_id;
								  }
								  if($pCount==0){
									  $client_ids=$client_id;
									  //$client_info=$wo_item['customer_name'].",".$wo_item['customer_email'].",".$wo_item['customer_mobile_no'];
									  $client_info=$wo_item['customer_name'].",".$wo_item['customer_mobile_no'];
									  $ref_info=$wo_item['wo_ref_no'];
								  }else{
									  $client_ids.=",".$client_id;
									  //$client_info.="|".$wo_item['customer_name'].",".$wo_item['customer_email'].",".$wo_item['customer_mobile_no'];
									  $client_info.="|".$wo_item['customer_name'].",".$wo_item['customer_mobile_no'];
									  $ref_info.=",".$wo_item['wo_ref_no'];
								  }
								  $pCount++;
							  }
							  $summary_parent=$wo_item['online_draft_parent_id'];
							  $summary_client_name=$wo_item['customer_name'].','.$wo_item['customer_mobile_no'];
							  //if($inc==0){
							  $summaryData = array(
							  'wo_order_id' => $wo_order_id,
							  'wo_product_type_id' => $wo_product_type_id,
							  'wo_product_type_name' => $wo_product_type_name,
							  'wo_product_type_value' => $wo_product_type_value,
							  'wo_collar_type_id' => $wo_collar_type_id,
							  'wo_collar_type_name' => $wo_collar_type_name,
							  'wo_collar_type_value' => $wo_collar_type_value,
							  'wo_sleeve_type_id' => $wo_sleeve_type_id,
							  'wo_sleeve_type_name' => $wo_sleeve_type_name,
							  'wo_sleeve_type_value' => $wo_sleeve_type_value,
							  'wo_fabric_type_id' => $wo_fabric_type_id,
							  'wo_fabric_type_name' => $wo_fabric_type_name,
							  'wo_fabric_type_value' => $wo_fabric_type_value,
							  'wo_addon_id' => $wo_addon_id,
							  'wo_addon_name' => $wo_addon_name,
							  'wo_addon_value' => $wo_addon_value,
							  'wo_qty' => $wo_qty,
							  'wo_rate' => $wo_rate,
							  'wo_discount' => $wo_discount,
							  'wo_product_making_time' => $wo_product_making_time,
							  'wo_collar_making_min' => $wo_collar_making_min,
							  'wo_sleeve_making_time' => $wo_sleeve_making_time,
							  'wo_fabric_making_min' => $wo_fabric_making_min,
							  'wo_addon_making_min' => $wo_addon_making_min,
							  'wo_ref_no' => $wo_ref_no,
							  'wo_shipping_type_id' => $wo_shipping_type_id,
							  'wo_img_back' => $wo_img_back,
							  'wo_img_front' => $wo_img_front,
							  'wo_shipping_address' => $wo_shipping_address,
							  'wo_remark' => $wo_remark,
							  'summary_parent' => $summary_parent,
							  'summary_client_name' => $summary_client_name,
							  'summary_client_id' => $wo_item['customer_id'],
							  'summary_client_name_only' =>$wo_item['customer_name'],
							  'summary_client_mobile' => $wo_item['customer_mobile_no'],
							  'summary_client_email' => $wo_item['customer_email'],
							  'wo_item_addons' => $wo_item['item_addons'],
							  'wo_item_addons_names' =>$wo_item['item_addons_names'],
							  'wo_item_addons_mk_time' => $wo_item['item_addons_mk_time'],
							  'wo_item_addons_mk_amt' => $wo_item['item_addons_mk_amt'],
						 	  'wo_option_session_id'=>$wo_item['current_session_id']
							  );
							  $summaryID = $this->workorder_model->insert_work_summary_one_by_one($summaryData);
							  $optionDataInputs= array(
							  'order_summary_id' => $summaryID,
							  'wo_order_id' => $wo_order_id,
							  'option_saved'=>1
							  );
							  $this->workorder_model->update_orders_option_final_new($optionDataInputs,$wo_item['online_draft_id'],'online');
							  $inc++;

						  }
					  }
					  if($inc!=0){
						  //$summary = $this->workorder_model->insert_work_summary($wo_item_query);
						  $summary = $this->workorder_model->remove_current_draft_data($this->input->post('current_wo_id'));
						  //$wo_order_id
					  }
					  //wo_order_id
					  $orderData1 = array(
					  'wo_client_id' => $client_ids,
					  'wo_customer_name' => $client_info,
					  'wo_ref_numbers' => $ref_info
					  );
					  $sms_status=$this->msg91->send_schedule_online_order_sms($mobileNos);
					  if($sms_status==1)
					      {
						  $sdataSms = array(
								    'scheduled_sms_status' =>1,
								    );
						  $this->workorder_model->update_wo_data($sdataSms,$wo_order_id);
					      }

					  $this->workorder_model->update_wo_data($orderData1,$wo_order_id);
					  redirect('workorder/online_details/'.$orderRow['order_uuid']);
				  }else{
					  $this->session->set_flashdata('error','Something wrong... Please try later !!!');
				  }
		  }
	  }

	  $data['title']="Sales | Online work order";
	  $data['title_head']='Online Work Order';
	  $data['product_size'] = $this->workorder_model->get_product_size();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  $session_id = $this->session->userdata('log_session_id');
	  $loginid=$this->session->userdata('loginid');
	  $data['summary_drafts'] = $this->workorder_model->get_summary_draft_latest($cid,$session_id,$loginid);
	  $data['cid'] = $cid;
	  $data['view']='workorder/online';
	  $this->load->view('layout',$data);
  }
  
  
  
  public function customermobajax($pno = "",$cid=""){
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
		  echo json_encode(array('responseCode'=>"yes",
								 'responseMsg'=>'readonly',
								 'customer_id'=>$row['customer_id'],
								 'customer_name'=>$row['customer_name'],
								 'customer_email'=>$row['customer_email'],
								 'customer_mobile_no'=>$row['customer_mobile_no'],
								 ));
	  }else{
		  echo json_encode(array('responseCode' =>"no",
								 'responseMsg'=>'Phone number available',
								 'customer_id'=>'',
								 'customer_name'=>'',
								 'customer_email'=>'',
								 'customer_mobile_no'=>'',
								 ));
	  }
	  
  }

  
  function onlinemodeledit($online_draft_id=0){
	  $data['product_fit'] = $this->workorder_model->get_product_fit();
	  $data['product_size'] = $this->workorder_model->get_product_size();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  $data['shipping_types'] = $this->workorder_model->get_shipping_types();
	  $data['online_draft_id'] = $online_draft_id;
	  $this->load->view('workorder/onlinemodeledit',$data);
  }
  function onlinemodel($pORc=0){
	  //$data['view']='workorder/onlinemodel';
	  $data['product_fit'] = $this->workorder_model->get_product_fit();
	  $data['product_size'] = $this->workorder_model->get_product_size();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  $data['shipping_types'] = $this->workorder_model->get_shipping_types();
	  $data['pORc'] = $pORc;
	  $this->load->view('workorder/onlinemodel',$data);
  }

  function delete_item($refNo,$orderId='',$orderuiid)
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

$orderData=$this->schedule_model->get_schedule_uuid_order($orderId);
$orderDataScheduled=$this->schedule_model->get_schedule_id_order($orderId);
$orderSummaryData = $this->workorder_model->get_order_summary_by_ref_no($orderId,$refNo);
$uuid=$orderData['schedule_uuid'];
$schedule_uuid=$orderDataScheduled['schedule_id'];
/*echo $refNo;
echo "<pre>";
print_r($orderData);
print_r($orderSummaryData);
echo $orderSummaryData['wo_order_id'];
echo "<br>";
print_r($uuid);
echo "<br>";
print_r($schedule_uuid);
exit();*/
$shRow=$this->schedule_model->get_scheduled_data_by_uuid($uuid);

                if($shRow['production_stitching_date']=="0000-00-00"){
                        $production_end_date=$shRow['schedule_end_date'];
                }else{
                        $production_end_date=$shRow['production_stitching_date'];
                }
$schedule_unit_id=$shRow['schedule_unit_id'];
                $day_data_row=$this->schedule_model->get_unit_day_info($production_end_date,$schedule_unit_id);
                $unit_working_capacity_in_sec=$day_data_row['unit_working_capacity_in_sec'];
                //echo $unit_working_capacity_in_sec."<br/>";
                $per_sum=0;
                $sec_sum=0;
                if($day_data_row['schedule_unit_percentage']!=''){
                        $per_sum=$day_data_row['schedule_unit_percentage'];
                }
                if($day_data_row['schedule_unit_percentage_sec']!=''){
                        $sec_sum=$day_data_row['schedule_unit_percentage_sec'];
                }
    		            //echo $per_sum."==".$sec_sum."<br/>";
                $array1 = json_decode($shRow['sh_order_json'],true);
//                print_r($array1);
 $item_order_total_sec=0;
                if($array1){
                        foreach($array1 as $key1 => $value1){
if($value1['online_ref_number'] == $orderSummaryData['wo_ref_no'])

{

                                $item_order_total_sec+=$value1['item_order_total_sec'];
}
                        }
                }

             $remaingSec=$sec_sum-$item_order_total_sec;
                $remainPer=$remaingSec/$unit_working_capacity_in_sec;
                $final_per=round( number_format( $remainPer * 100, 2 ));



             	  $this->schedule_model->delete_scheduled_item_qty_data_online($orderId,$orderSummaryData['order_summary_id']);
  $this->schedule_model->delete_rejected_order_data_online($schedule_uuid,$orderSummaryData['order_summary_id']);
  $updateRsDesign = $this->workorder_model->delete_rs_design_items($orderSummaryData['wo_order_id'],$refNo);
  $updateScheduleDesign = $this->workorder_model->delete_schedule_items($orderSummaryData['wo_order_id'],$refNo);
  $updateScheduleDepartmentDesign = $this->workorder_model->delete_schedule_department_items($orderSummaryData['wo_order_id'],$refNo);	
    $this->schedule_model->delete_work_order_summary_referenece_data_online($orderId,$refNo);

  $updateWorkOrderReferenceNo = $this->workorder_model->update_work_order_items($orderSummaryData['wo_order_id'],$refNo);	

//exit();


				  $u_data = array(
                        'schedule_unit_percentage' =>$final_per,
                        'schedule_unit_percentage_sec' =>$remaingSec,
                );
               $this->schedule_model->update_unit_calender_time($u_data,$production_end_date,$schedule_unit_id);
                $this->session->set_flashdata('success','successfully deleted the item.');





redirect('work_online/production_edit/'.$orderuiid);


}

  function delete($uuid='')
  {   
	  $this->rbac->check_operation_access(); // check opration permission
	  $wo_row=$this->workorder_model->get_order_data_by_uuid($uuid);
          $order_id=$wo_row['order_id'];
	  $lead_id=$wo_row['lead_id'];
	  $orderRow=$this->common_model->get_order_data_from_schedule($order_id);
		// print_r($wo_row);exit;
	  if($orderRow){
	
		  if($wo_row['orderform_type_id']==1){
	  $this->session->set_flashdata('error','Sorry..cannot delete. Please remove order schedules first.');
			  redirect('workorder/index');
		  }else{
	  $this->workorder_model->remove_wo_rs_design($order_id);//exit;
	  $this->workorder_model->remove_wo_shedules($order_id);//exit;

	  			  $this->workorder_model->remove_wo_shedule_department($order_id);
	  			  $this->workorder_model->remove_wo_shedule_department_rej($order_id);
	  			  $this->workorder_model->remove_wo_shedule_department_item($order_id);
	  			  $this->workorder_model->remove_wo_rj_scheduled($order_id);

	  $this->workorder_model->remove_wo_data($order_id);//exit;
	  $this->workorder_model->remove_wo_summary($order_id);
	  $this->workorder_model->remove_docs($order_id);
	  if($wo_docs){
		  foreach($wo_docs as $DOC){
			  $document_name=$DOC['document_name'];
			  $path= $_SERVER['DOCUMENT_ROOT'].'/uploads/orderform/'.$document_name;
			  if(is_file($path)){
				  unlink($path);
				  //echo 'File '.$filename.' has been deleted';
			  }
		  }
	  }
	  $this->session->set_flashdata('success','Order Removed successfully .');
			  redirect('workorder/wo_online');
		  }
	  }
				  
	  
	  $this->workorder_model->remove_wo_data($order_id);//exit;
	  $this->workorder_model->remove_wo_summary($order_id);
	  
	  if($wo_row['orderform_type_id']==1){
	  $dataLeadUpdate = array('generate_wo' => 0);
	  $this->leads_model->update_leads_data($dataLeadUpdate,$lead_id);
	  }
	  $this->workorder_model->remove_docs($order_id);
	  if($wo_docs){
		  foreach($wo_docs as $DOC){
			  $document_name=$DOC['document_name'];
			  $path= $_SERVER['DOCUMENT_ROOT'].'/uploads/orderform/'.$document_name;
			  if(is_file($path)){
				  unlink($path);
				  //echo 'File '.$filename.' has been deleted';
			  }
		  }
	  }
	  
	  
	  $this->session->set_flashdata('success','successfully deleted.');	
	  if($wo_row['orderform_type_id']==1){
		  redirect('workorder/index');
	  }else{
		  $this->workorder_model->remove_wo_order_options($order_id);
		  redirect('workorder/wo_online');
	  }
  }
  
  public function production($uuid=''){
	  $this->rbac->check_operation_access();
	  $wo_row=$this->workorder_model->get_order_data_by_uuid($uuid);
	  $order_id=$wo_row['order_id'];
	  date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
	  $submited_date = date('d-m-Y H:i:s');
	  if($order_id!=""){
		  $orderData = array(
			  'submited_to_production' =>'yes',
			  'wo_status_id' =>3,
			  'submited_date'=>$submited_date
		  );
		  $result = $this->workorder_model->update_wo_data($orderData,$order_id);
		//------------------------------------------------
			$recipient=$this->notification_model->get_users_form_production();
			if($recipient['ph_users']!=""){ // staff id
				$notification_recipients=$recipient['ph_users'];
				if($wo_row['lead_id']==0){
					$owner='Admin';
					$notification_from="Admin";
				}else{ 
					$owner=$wo_row['staff_name'];
					$notification_from=$wo_row['wo_owner_id'];
				}
				$notification_content='Order no. '.$wo_row['orderform_number'].' has been submitted to production by '.$owner;
				$notification_title="Submit To Production";
				$created_by=$this->session->userdata('loginid');
				$notificationData=array('notification_title'=>$notification_title,
				'notification_content'=>$notification_content,
				'notification_date'=>date('Y-m-d'),
				'notification_time_stamp'=>$submited_date,
				'notification_from'=>$notification_from,
				'notification_recipients'=>$notification_recipients,
				'created_by'=>$created_by
				);
				$this->notification_model->insert_notification($notificationData);
			}
			
		//------------------------------------------------
			
		  $this->session->set_flashdata('success','Work order successfully submitted to production.');	
		  if($wo_row['orderform_type_id']==1){
			  redirect('workorder/index');
		  }else{
			  redirect('workorder/wo_online');
		  }
	  }else{
		  $this->session->set_flashdata('error','Something wrong...Please try later..');	
		  if($wo_row['orderform_type_id']==1){
			  redirect('workorder/index');
		  }else{
			  redirect('workorder/wo_online');
		  }
	  }
  }
  
  
  

  
  public function wo_json_list(){
		  $accessArray=$this->rbac->check_operation_access(); 
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
				  
				  if($accessArray){if(in_array("edit",$accessArray)){
$option.='&nbsp;<a href="'.base_url('workorder/edit/'.$row['order_uuid']).'" title="Edit" style="cursor: pointer;"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>';
				  }}
				  
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
  
  
  function filter_online()
  {
	  $this->session->set_userdata('wo_date',$this->input->post('wo_date'));
	  $this->session->set_userdata('wo_dispatch_date',$this->input->post('wo_dispatch_date'));
	  $this->session->set_userdata('orderform_number',$this->input->post('orderform_number'));
	  $this->session->set_userdata('wo_staff_name',$this->input->post('wo_staff_name'));
	  $this->session->set_userdata('wo_customer_name',$this->input->post('wo_customer_name'));
	  $this->session->set_userdata('wo_work_priority_id',$this->input->post('wo_work_priority_id'));
	  $this->session->set_userdata('orderform_type_id',$this->input->post('orderform_type_id'));
	  $this->session->set_userdata('wo_ref_numbers',$this->input->post('wo_ref_numbers'));
  }
  function filter()
  {
	  $this->session->set_userdata('wo_date',$this->input->post('wo_date'));
	  $this->session->set_userdata('wo_dispatch_date',$this->input->post('wo_dispatch_date'));
	  $this->session->set_userdata('orderform_number',$this->input->post('orderform_number'));
	  $this->session->set_userdata('wo_staff_name',$this->input->post('wo_staff_name'));
	  $this->session->set_userdata('wo_customer_name',$this->input->post('wo_customer_name'));
	  $this->session->set_userdata('wo_work_priority_id',$this->input->post('wo_work_priority_id'));
	  $this->session->set_userdata('orderform_type_id',$this->input->post('orderform_type_id'));
	  $this->session->unset_userdata('wo_ref_numbers');
  }
  
  public function wo_online(){
	  
	  $this->session->unset_userdata('wo_date');
	  $this->session->unset_userdata('wo_dispatch_date');
	  $this->session->unset_userdata('orderform_number');
	  $this->session->unset_userdata('wo_staff_name');
	  $this->session->unset_userdata('wo_customer_name');
	  $this->session->unset_userdata('wo_work_priority_id');
	  $this->session->unset_userdata('orderform_type_id');
	  $this->session->unset_userdata('wo_ref_numbers');
	  
	  $accessArray=$this->rbac->check_operation_access(); // check opration permission
	  if($accessArray==""){
		  redirect('access/not_found');
	  }
	  $data['title']=$accessArray['module_parent']." | Online Work Order";
	  $data['title_head']='Online Work Order';
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  $data['order_types'] = $this->workorder_model->get_order_types();
	  //print_r($results);
	  //$data['results']=$results;
	  $data['view']='workorder/online_index';
	  $this->load->view('layout',$data);
  }
  public function index(){
	  
	  $accessArray=$this->rbac->check_operation_access(); // check opration permission
	  if($accessArray==""){
		  redirect('access/not_found');
	  }
	  
	  $this->session->unset_userdata('wo_date');
	  $this->session->unset_userdata('wo_dispatch_date');
	  $this->session->unset_userdata('orderform_number');
	  $this->session->unset_userdata('wo_staff_name');
	  $this->session->unset_userdata('wo_customer_name');
	  $this->session->unset_userdata('wo_work_priority_id');
	  $this->session->unset_userdata('orderform_type_id');
	  $this->session->unset_userdata('wo_ref_numbers');
	  
	  
	  $data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
	  $data['title_head']=$accessArray['menu_name'];
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  $data['order_types'] = $this->workorder_model->get_order_types();
	  //print_r($results);
	  //$data['results']=$results;
	  $data['view']='workorder/index';
	  $this->load->view('layout',$data);
  }
  
  
  public function view_online($id=0){
	  $accessArray=$this->rbac->check_operation_access(); // check opration permission
	  if($accessArray==""){
		  redirect('access/not_found');
	  }else{
		  if($accessArray){if(!in_array("view",$accessArray)){
		  redirect('access/access_denied');
		  }}
	  }
	  $data['title']=$accessArray['module_parent']." | Online Work Order";
	  $data['title_head']='Online Work Order';
	  
	  //print_r($results);
	  //$data['results']=$results;
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	  //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('success','Invalid work order.');
		  redirect('workorder/wo_online');
	  }
	  $data['row']=$row;
	  
	  $data['summary']=$this->workorder_model->get_order_summary_in_detail_online($row['order_id']);
	  $data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
	  $data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
	  
	  $data['view']='workorder/view_online';
	  $this->load->view('layout',$data);
  }
  public function view($id=0){
	  $accessArray=$this->rbac->check_operation_access(); // check opration permission
	  if($accessArray==""){
		  redirect('access/not_found');
	  }else{
		  if($accessArray){if(!in_array("view",$accessArray)){
		  redirect('access/access_denied');
		  }}
	  }
	  $data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
	  $data['title_head']=$accessArray['menu_name'];
	  
	  //print_r($results);
	  //$data['results']=$results;
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	  //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('success','Invalid work order.');
		  redirect('workorder/index');
	  }
	  $data['row']=$row;
	  
	  $data['summary']=$this->workorder_model->get_order_summary_in_detail($row['order_id']);
	  $data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
	  $data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
	 
	  $data['view']='workorder/view';
	  $this->load->view('layout',$data);
  }
  
  public function wonumber(){
	  
	  $nxt_id= $this->workorder_model->get_next_autoid('wo_work_orders');
	  $ordertype=$_POST['ot'];
	  $no_prefix="";
	  $leadid=$_POST['ln'];
	  $slno=1000+$nxt_id;
	  
	  if($ordertype==1){
		  $no_prefix.="F".$slno;
	  }else{
		  $no_prefix.="N".$slno;
	  }
	  echo $no_prefix;
  }
  function removedoc(){
	  $document_id=$_POST['document_id'];
	  $doc=$this->workorder_model->get_wo_document($document_id);
	  $document_name=$doc['document_name'];
	  $this->workorder_model->remove_wo_document($document_id);
	  $path= $_SERVER['DOCUMENT_ROOT'].'/uploads/orderform/'.$document_name ;
	  if(is_file($path)){
		  unlink($path);
		  //echo 'File '.$filename.' has been deleted';
	  }
  }
  
  public function online_details($id = 0){
	  if($this->input->post('submit')){
		  $this->form_validation->set_rules('order_id', 'Order data', 'trim|required');
		  if ($this->form_validation->run() == TRUE) {
			  $wo_data = array( 
				  'wo_status_id' =>2,
				  'wo_u_by' => $this->session->userdata('loginid'),
				  'wo_u_date' =>date('Y-m-d'),
			  );
			  $rs = $this->workorder_model->update_wo_data($wo_data,$this->input->post('order_id'));
			  $this->session->set_flashdata('success','Work order saved successfully');
			  redirect('workorder/wo_online');
		  }
	  }
	  $moduleData=$this->rbac->check_operation_access(); // check opration permission
	  $data['title']="Sales | Online work order ";
	  $data['title_head']='Online Work Order';
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	  //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('success','Invalid work order.');
		  redirect('workorder/wo_online');
	  }
	  $data['row']=$row;
	  //$data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
	  $data['view']='workorder/online_details';
	  $this->load->view('layout',$data);
  }
  public function details($id = 0){
	  
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
	  $data['taxclass'] = $this->workorder_model->get_taxclass();
	  $data['view']='formdata/details';
	  $this->load->view('layout',$data);
  }
  // //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function add($id=0){
	  $accessArray=$this->rbac->check_operation_access(); // check opration permission
	  if($accessArray==""){
		  redirect('access/not_found');
	  }else{
		  if($accessArray){if(!in_array("add",$accessArray)){
		  redirect('access/access_denied');
		  }}
	  }
	  $data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
	  $data['title_head']=$accessArray['menu_name'];
	  $leadData= $this->leads_model->get_leads_data($id);
	  //print_r($leadData);
	  if($leadData==""){
		  $this->session->set_flashdata('error','Invalid lead details.');	
		  redirect('leads/index');
	  }
	  $data['lead_info']=$leadData;
	  $data['order_types'] = $this->workorder_model->get_order_types();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  //$this->load->model('customer_model', 'customer_model');
	  //$data['customers']= $this->customer_model->get_all_customers();
	  $dataLead = array(
		  'lead_id' => $leadData['lead_id']
	  );
	  $woExist = $this->workorder_model->check_lead_saved($dataLead,'');
	  if($woExist['order_id']!=""){
		  $this->session->set_flashdata('error','Work order already created...');	
		  redirect('leads/index');
	  }
	  //print_r($woExist);
	  
	  $data['view']='workorder/add_new';
	  $this->load->view('layout',$data);
  }
  
public function attachments($id = 0){
		if($this->input->post('submit')){
			$this->session->set_flashdata('success','Work order saved successfully');
			redirect('workorder/index/');
		}
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
	  $data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
	  $data['title_head']=$moduleData['menu_name'];
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	 //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('error','Invalid action.');
		  redirect('workorder/index');
	  }
	  $data['row']=$row;
		$data['taxclass'] = $this->workorder_model->get_taxclass();
	  $data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
	  $data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  $data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
	  $data['view']='formdata/attachments';
	  $this->load->view('layout',$data);
	}
  
  
	public function documents($id = 0){
		if($this->input->post('submit')){
			$this->session->set_flashdata('success','Work order saved successfully');
			redirect('workorder/wo_online/');
		}
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
	  $data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
	  $data['title_head']=$moduleData['menu_name'];
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	 //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('error','Invalid action.');
		  redirect('workorder/index');
	  }
	  $data['row']=$row;
		$data['taxclass'] = $this->workorder_model->get_taxclass();
	  $data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
	  $data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  $data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
	  $data['view']='formdata/edit_documents_new';
	  $this->load->view('layout',$data);
	}
  public function edit_details($id = 0){
	  $moduleData=$this->rbac->check_operation_access(); // check opration permission
	  $data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
	  $data['title_head']=$moduleData['menu_name'];
	  $row= $this->workorder_model->get_order_data_by_uuid($id);
	 //print_r($row);
	  if($row==""){
		  $this->session->set_flashdata('error','Invalid work order.');
		  redirect('workorder/index');
	  }
	  $data['row']=$row;
		$data['taxclass'] = $this->workorder_model->get_taxclass();
	  $data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
	  $data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
	  $data['priority']= $this->workorder_model->get_all_active_priority();
	  $data['shipping_modes']= $this->workorder_model->get_all_active_shipping_modes();
	  $data['view']='formdata/edit_details_new';
	  $this->load->view('layout',$data);
  }
  
}
