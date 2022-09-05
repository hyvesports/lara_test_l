<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Formdata extends CI_Controller {
  public function __construct(){ 
	  parent::__construct();
	  $this->load->model('auth_model', 'auth_model');
	  $this->load->model('workorder_model', 'workorder_model');
	  $this->load->model('schedule_model', 'schedule_model');
	  $this->load->model('settings_model', 'settings_model');
	  $this->load->model('leads_model', 'leads_model');
	  $this->load->model('formdata_model', 'formdata_model');
	  $this->load->model('common_model', 'common_model');
	  $this->load->library('datatable');
	  if(!$this->session->has_userdata('loginid')){
		  redirect('auth/login');
	  }
  }
	//
	public function edit($id=0){
	if($this->input->post('submit')){

		$this->form_validation->set_rules('lead_id', 'Lead data', 'trim|required');
		$this->form_validation->set_rules('orderform_type_id', 'Order type', 'trim|required');
		$this->form_validation->set_rules('orderform_number', 'Order number', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Alert!</h4>'.validation_errors().'</div>';
			$this->session->set_flashdata('error',$msg);
			redirect('workorder/edit/'.$id);
		}else{
			$wo_dispatch_date = $this->input->post('wo_dispatch_date');
			$orderData = array(
				'wo_customer_name' => $this->input->post('wo_customer_name'),
				'wo_staff_name' => $this->input->post('wo_staff_name'),
				'wo_order_nature_id' => $this->input->post('wo_order_nature_id'),
				'wo_owner_id' => $this->input->post('wo_owner_id'),
				'wo_dispatch_date' =>$wo_dispatch_date,
				'wo_u_by' => $this->session->userdata('loginid'),
				'wo_u_date' =>date('Y-m-d'),
				'wo_product_info'=>$this->input->post('wo_product_info'),
				'submited_to_production' =>'no'
			);
			$result = $this->workorder_model->update_wo_data($orderData,$this->input->post('order_id'));
			redirect('workorder/edit_details/'.$id);
		}
		
	}else{
		$this->session->set_flashdata('error','Invalid form action');
		redirect('workorder/edit/'.$id);
	}}
	public function update_summary(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
			$this->form_validation->set_rules('order_id', 'Order details', 'trim|required');
			$this->form_validation->set_rules('order_summary_id', 'Order item', 'trim|required');
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
				//echo $item_addons;
				$wo_product_type_id=trim(addslashes(htmlentities($_POST['wo_product_type_id'])));
				$product_type_row=$this->settings_model->get_producttype_data($wo_product_type_id);
				$wo_product_type_name=$product_type_row['product_type_name'];
				$wo_product_type_value=$product_type_row['product_type_amount'];
				$wo_product_making_time=$product_type_row['product_making_time'];
				
				$wo_collar_type_id=trim(addslashes(htmlentities($_POST['wo_collar_type_id'])));
				$collar_type_row=$this->settings_model->get_collartype_data($wo_collar_type_id);
				$wo_collar_type_name=$collar_type_row['collar_type_name'];
				$wo_collar_type_value=$collar_type_row['collar_amount'];
				$wo_collar_making_min=$collar_type_row['collar_making_min'];
				
				$wo_sleeve_type_id=trim(addslashes(htmlentities($_POST['wo_sleeve_type_id'])));
				$sleeve_type_row=$this->settings_model->get_sleevetype_data($wo_sleeve_type_id);
				$wo_sleeve_type_name=$sleeve_type_row['sleeve_type_name'];
				$wo_sleeve_type_value=$sleeve_type_row['sleeve_type_amount'];
				$wo_sleeve_making_time=$sleeve_type_row['sleeve_making_time'];
				
				$wo_fabric_type_id=trim(addslashes(htmlentities($_POST['wo_fabric_type_id'])));
				$fabric_type_row=$this->settings_model->get_fabrictype_data($wo_fabric_type_id);
				$wo_fabric_type_name=$fabric_type_row['fabric_type_name'];
				$wo_fabric_type_value=$fabric_type_row['fabric_amount'];
				$wo_fabric_making_min=$fabric_type_row['fabric_making_min'];
				
				$wo_addon_id=0;
				$addon_row=$this->settings_model->get_addons_data($wo_addon_id);
				$wo_addon_name=$addon_row['addon_name'];
				$wo_addon_value=$addon_row['addon_amount'];
				$wo_addon_making_min=$addon_row['addon_making_min'];
				$wo_qty=trim(addslashes(htmlentities($_POST['wo_qty'])));
				$wo_rate=trim(addslashes(htmlentities($_POST['wo_rate'])));
				$wo_discount=trim(addslashes(htmlentities($_POST['wo_discount'])));
				$summaryData = array(
				'wo_order_id' => $_POST['order_id'],
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
				'wo_addon_id' => 0,
				'wo_addon_name' => 0,
				'wo_addon_value' => 0,
				'wo_qty' => $wo_qty,
				'wo_rate' => $wo_rate,
				'wo_discount' => $wo_discount,
				'wo_product_making_time' => $wo_product_making_time,
				'wo_collar_making_min' => $wo_collar_making_min,
				'wo_sleeve_making_time' => $wo_sleeve_making_time,
				'wo_fabric_making_min' => $wo_fabric_making_min,
				'wo_addon_making_min' => $wo_addon_making_min,
				'wo_item_addons' => $item_addons,
				'wo_item_addons_names' =>$item_addons_names,
				'wo_item_addons_mk_time' => $item_addons_mk_time,
				'wo_item_addons_mk_amt' => $item_addons_mk_amt,
				'wo_option_session_id'=>$_POST['current_s_id'],
				'wo_img_back' => $_POST['wo_img_back'],
				'wo_img_front' => $_POST['wo_img_front'],
				'wo_remark' => $_POST['wo_remark'],
				);
				$order_id=$this->input->post('order_id');
				$this->formdata_model->update_work_summary_one_by_one($summaryData,$this->input->post('order_summary_id'));
				$summaryID=$this->input->post('order_summary_id');
//-------------------------------------------------
				$this->formdata_model->drop_orginal_order_option_item($this->input->post('order_summary_id'),$order_id);
				$Option_qty=0;
				$offline_draft_id=0;
				if($_POST['options']){
					$option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id,data_from) VALUES ";
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
							$option_query.=" (NULL, '$summaryID', '$offline_draft_id', '$order_id', '$option_session_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
						}else{
							$option_query.=",(NULL, '$summaryID', '$offline_draft_id', '$order_id', '$option_session_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
						}
						$option_count++;
					}
					//echo $option_query;exit;
					if($option_query!=""){
						$summary = $this->workorder_model->insert_wo_options($option_query);
					}
			}
			$order_id=$this->input->post('order_id');
			$sumRow=$this->formdata_model->get_wo_order_summary_sum($order_id);
			$orderRow=$this->workorder_model->get_work_order($order_id);
			$total_rate=$sumRow['totalRate'];
			$total_disc=$sumRow['totalDiscount'];
			$rate=$total_rate-$total_disc;
			$rate=$rate+$orderRow['wo_additional_cost'];
			$tax=0;
			$taxamount=0;
			if($orderRow['wo_tax_value']){
				$tax=$orderRow['wo_tax_value'];
				$taxamount= ($tax / 100) * $rate;
			}
			$rate=$rate+$taxamount;
			$rate=$rate+$orderRow['wo_shipping_cost'];
			$wo_gross_cost=$rate-$orderRow['wo_adjustment'];
			$wo_balance=$wo_gross_cost-$orderRow['wo_balance'];
			//
			$orderData = array(
			'wo_gross_cost' => $wo_gross_cost,
			'wo_balance'=>$wo_balance);
			$this->workorder_model->update_wo_data($orderData,$order_id);


			$this->session->set_flashdata('success_draft','Order summary saved successfully');
			//redirect('workorder/online/'.$this->input->post('current_woid'));
			echo json_encode(array('responseCode'=>"success"));
//--------------------------------------------------


			}else{
				$responseMsg='
			  	<div class="alert alert-warning alert-dismissible" style="width:100%;">
			  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			  	<h4><i class="icon fa fa-warning"></i> Alert!</h4>
			  	'.validation_errors().'
			  	</div>';
			  	echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
			}
		}else{
			$responseMsg='
			<div class="alert alert-warning alert-dismissible" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Alert!</h4>Invalid action
			</div>';
			echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
		}
	}
	public function model_order_edit($order_summary_id){
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
		$data['order_summary_id'] = $order_summary_id;
		$this->load->view('formdata/model_order_edit',$data);
	}

	public function offlinemodelinedit(){
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
		$this->load->view('formdata/offline_model_in_edit',$data);
	}
	
	public function summary_data_offline(){
		$data['summary']=$this->workorder_model->get_order_summary($_POST['order_id']);
		$data['cAction']="save";
		$this->load->view('formdata/items_table',$data);
	}
	public function drop_summary_item($sid=0){
		$summaryData = $this->formdata_model->get_summary_of_online_data($sid);
		$wo_order_id=$summaryData['wo_order_id'];
		$wo_option_session_id=$summaryData['wo_option_session_id'];
		$order_summary_id=$summaryData['order_summary_id'];
		$this->formdata_model->remove_orginal_summary_item($order_summary_id);
		$this->formdata_model->remove_orginal_order_option_item($order_summary_id,$wo_order_id,$wo_option_session_id);
		$data['summary']=$this->workorder_model->get_order_summary($wo_order_id);
		$data['cAction']="drop";

		$order_id=$wo_order_id;
		$sumRow=$this->formdata_model->get_wo_order_summary_sum($order_id);
		$orderRow=$this->workorder_model->get_work_order($order_id);
		$total_rate=$sumRow['totalRate'];
		$total_disc=$sumRow['totalDiscount'];
		$rate=$total_rate-$total_disc;
		$rate=$rate+$orderRow['wo_additional_cost'];
		$tax=0;
		$taxamount=0;
		if($orderRow['wo_tax_value']){
		  $tax=$orderRow['wo_tax_value'];
		  $taxamount= ($tax / 100) * $rate;
		}
		$rate=$rate+$taxamount;
		$rate=$rate+$orderRow['wo_shipping_cost'];
		$wo_gross_cost=$rate-$orderRow['wo_adjustment'];
		$wo_balance=$wo_gross_cost-$orderRow['wo_balance'];
		//
		$orderData = array(
		'wo_gross_cost' => $wo_gross_cost,
		'wo_balance'=>$wo_balance);
		$this->workorder_model->update_wo_data($orderData,$order_id);
		$this->load->view('formdata/items_table',$data);
	}
	
public function offline_details($id=0){
	if($this->input->post('submit')){
		$this->form_validation->set_rules('wo_tax_id', 'Tax class', 'trim|required');
		$this->form_validation->set_rules('order_id', 'Order data', 'trim|required');
		$this->form_validation->set_rules('shipping_address', 'Shipping address', 'trim|required');
		$this->form_validation->set_rules('billing_address', 'Billing address', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Alert!</h4>'.validation_errors().'</div>';
			$this->session->set_flashdata('error',$msg);
			redirect('workorder/details/'.$id);
		}else{

//-------------------------------------------------------------------------------------------
			  //exit;
			  if($this->input->post('customer_shipping_id')!=""){
				   $this->workorder_model->remove_shipping_data($this->input->post('customer_shipping_id'));
			  }
			  $shipping_data = array(
				  'shipping_address' => $this->input->post('shipping_address'),
				  'shipping_customer_id' => $this->input->post('wo_client_id'),
				  'wo_order_id' => $this->input->post('order_id'),
			  );
			  $rs = $this->workorder_model->insert_shipping_data($shipping_data);
			  
			  
			  
			  if($this->input->post('customer_billing_id')!=""){
				   $this->workorder_model->remove_billing_data($this->input->post('customer_billing_id'));
			  }
			  $billing_data = array(
				  'billing_address' => $this->input->post('billing_address'),
				  'billing_customer_id' => $this->input->post('wo_client_id'),
				  'wo_order_id' => $this->input->post('order_id'),
			  );
			  $rs = $this->workorder_model->insert_billing_data($billing_data);
			  $taxDataRow=$this->workorder_model->get_txa_info_data($this->input->post('wo_tax_id'));

			  $wo_data = array(
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
				'wo_special_requirement' => $this->input->post('wo_special_requirement'),
				'wo_shipping_mode_id' => $this->input->post('wo_shipping_mode_id'),
				'wo_work_priority_id' => $this->input->post('wo_work_priority_id'),
				'wo_status_id' =>2,
				'wo_u_by' => $this->session->userdata('loginid'),
				'wo_u_date' =>date('Y-m-d'),
			  );
			  $rs = $this->workorder_model->update_wo_data($wo_data,$this->input->post('order_id'));
			  //$this->session->set_flashdata('success','Work order saved successfully');
			  redirect('workorder/attachments/'.$id);
			  //print_r($files);
		  
//___________________________________________________________________________________________
		}
	}else{
		$this->session->set_flashdata('error','Invalid form actions');
		redirect('workorder/add/');
	}}
public function details($id=0){
	if($this->input->post('submit')){
		$this->form_validation->set_rules('wo_tax_id', 'Tax class', 'trim|required');
		$this->form_validation->set_rules('order_id', 'Order data', 'trim|required');
		$this->form_validation->set_rules('shipping_address', 'Shipping address', 'trim|required');
		$this->form_validation->set_rules('billing_address', 'Billing address', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Alert!</h4>'.validation_errors().'</div>';
			$this->session->set_flashdata('error',$msg);
			redirect('workorder/details/'.$id);
		}else{

//-------------------------------------------------------------------------------------------
			  //exit;
			  if($this->input->post('customer_shipping_id')!=""){
				   $this->workorder_model->remove_shipping_data($this->input->post('customer_shipping_id'));
			  }
			  $shipping_data = array(
				  'shipping_address' => $this->input->post('shipping_address'),
				  'shipping_customer_id' => $this->input->post('wo_client_id'),
				  'wo_order_id' => $this->input->post('order_id'),
			  );
			  $rs = $this->workorder_model->insert_shipping_data($shipping_data);
			  
			  
			  
			  if($this->input->post('customer_billing_id')!=""){
				   $this->workorder_model->remove_billing_data($this->input->post('customer_billing_id'));
			  }
			  $billing_data = array(
				  'billing_address' => $this->input->post('billing_address'),
				  'billing_customer_id' => $this->input->post('wo_client_id'),
				  'wo_order_id' => $this->input->post('order_id'),
			  );
			  $rs = $this->workorder_model->insert_billing_data($billing_data);
			  $taxDataRow=$this->workorder_model->get_txa_info_data($this->input->post('wo_tax_id'));

			  $wo_data = array(
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
				'wo_special_requirement' => $this->input->post('wo_special_requirement'),
				'wo_shipping_mode_id' => $this->input->post('wo_shipping_mode_id'),
				'wo_work_priority_id' => $this->input->post('wo_work_priority_id'),
				'wo_status_id' =>2,
				'wo_u_by' => $this->session->userdata('loginid'),
				'wo_u_date' =>date('Y-m-d'),
			  );
			  $rs = $this->workorder_model->update_wo_data($wo_data,$this->input->post('order_id'));
			  //$this->session->set_flashdata('success','Work order saved successfully');
			  redirect('workorder/documents/'.$id);
			  //print_r($files);
		  
//___________________________________________________________________________________________
		}
	}else{
		$this->session->set_flashdata('error','Invalid form actions');
		redirect('workorder/add/');
	}}
	public function add($id=0){
	if($this->input->post('submit')){
		$this->form_validation->set_rules('lead_id', 'Lead data', 'trim|required');
		$this->form_validation->set_rules('orderform_type_id', 'Order type', 'trim|required');
		$this->form_validation->set_rules('orderform_number', 'Order number', 'trim|required');
		$draft_rows=$this->formdata_model->get_offline_order_draft($id,$this->session->userdata('loginid'));
		if(empty($draft_rows)){
			$this->form_validation->set_rules('Ordersummary', 'Order summary item', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Alert!</h4>'.validation_errors().'</div>';
			$this->session->set_flashdata('error',$msg);
			redirect('workorder/add/'.$id);
		}else{
			$dataLead = array(
				'lead_id' => $this->input->post('lead_id'),
				'orderform_number' => $this->input->post('orderform_number')
			);
			$leadExist = $this->workorder_model->check_lead_saved($dataLead,'');
			if($leadExist['lead_id']==""){
				$orderExist = $this->workorder_model->check_order_no_exist($dataLead,'');
				if($orderExist['orderform_number']==""){
					date_default_timezone_set('Asia/kolkata');
					$now = date('d-m-Y H:i:s');
					$wo_date = date('Y-m-d');
					$wo_dispatch_date1=$this->input->post('wo_dispatch_date');
					$wo_dispatch_date=date('Y-m-d', strtotime($wo_dispatch_date1));
					$orderData = array(
						'lead_id' => $this->input->post('lead_id'),
						'orderform_number' => $this->input->post('orderform_number'),
						'wo_customer_name' => $this->input->post('wo_customer_name'),
						'wo_staff_name' => $this->input->post('wo_staff_name'),
						'wo_date_time' => $now,
						'wo_date' => $wo_date,
						'wo_client_id' => $this->input->post('wo_client_id'),
						'wo_owner_id' => $this->input->post('wo_owner_id'),
						'orderform_type_id' => $this->input->post('orderform_type_id'),
						'wo_order_nature_id' => $this->input->post('wo_order_nature_id'),
						'wo_dispatch_date' =>$wo_dispatch_date,
						'wo_product_info' => $this->input->post('wo_product_info'),
						'wo_shipping_cost' => "",
						'wo_additional_cost' => "",
						'wo_additional_cost_desc' =>"",
						'wo_tax_id' =>"",
						'wo_tax_name' => "",
						'wo_tax_value' =>"",
						'wo_adjustment' =>"",
						'wo_gross_cost' =>"",
						'wo_advance' =>"",
						'wo_balance' =>"",
						'wo_status_id' =>1,
						'wo_row_status' => 1,
						'wo_c_by' => $this->session->userdata('loginid'),
						'wo_c_date' =>date('Y-m-d'),
						'submited_to_production' =>'no'
					);
					$result = $this->workorder_model->insert_work_order($orderData);
					if($result){
						$wo_order_id=$result;
						$orderRow= $this->workorder_model->get_work_order($wo_order_id);
						$dataLeadUpdate = array(
							'generate_wo' => 1
						);
						$this->leads_model->update_leads_data($dataLeadUpdate,$this->input->post('lead_id'));
						$wo_item_query="";
						if($draft_rows){

							$inc=0;
							
							foreach($draft_rows as $wo_item){
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
								
								$wo_addon_id=0;
								$addon_row=$this->settings_model->get_addons_data($wo_addon_id);
								$wo_addon_name=$addon_row['addon_name'];
								$wo_addon_value=$addon_row['addon_amount'];
								$wo_addon_making_min=$addon_row['addon_making_min'];

								$wo_qty=trim(addslashes(htmlentities($wo_item['wo_qty'])));
								$wo_rate=trim(addslashes(htmlentities($wo_item['wo_rate'])));
								$wo_discount=trim(addslashes(htmlentities($wo_item['wo_discount'])));
								$wo_item_addons=trim(addslashes(htmlentities($wo_item['item_addons'])));
								$wo_item_addons_names=trim(addslashes(htmlentities($wo_item['item_addons_names'])));
								$wo_item_addons_mk_time=trim(addslashes(htmlentities($wo_item['item_addons_mk_time'])));
								$wo_item_addons_mk_amt=trim(addslashes(htmlentities($wo_item['item_addons_mk_amt'])));
								$wo_option_session_id=trim(addslashes(htmlentities($wo_item['current_session_id'])));			
								
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
								'wo_addon_id' => 0,
								'wo_addon_name' => 0,
								'wo_addon_value' => 0,
								'wo_qty' => $wo_qty,
								'wo_rate' => $wo_rate,
								'wo_discount' => $wo_discount,
								'wo_product_making_time' => $wo_product_making_time,
								'wo_collar_making_min' => $wo_collar_making_min,
								'wo_sleeve_making_time' => $wo_sleeve_making_time,
								'wo_fabric_making_min' => $wo_fabric_making_min,
								'wo_addon_making_min' => $wo_addon_making_min,
								'wo_item_addons' => $wo_item['item_addons'],
								'wo_item_addons_names' =>$wo_item['item_addons_names'],
								'wo_item_addons_mk_time' => $wo_item['item_addons_mk_time'],
								'wo_item_addons_mk_amt' => $wo_item['item_addons_mk_amt'],
								'wo_option_session_id'=>$wo_item['current_session_id'],
								'wo_img_back' => $wo_item['wo_img_back'],
								'wo_img_front' => $wo_item['wo_img_front'],
								'wo_remark' => $wo_item['wo_remark'],
								);
								$offline_draft_id=$wo_item['offline_draft_id'];
								$summaryID= $this->workorder_model->insert_work_summary_one_by_one($summaryData);
								$this->formdata_model->remove_offline_draft_one_by_one($offline_draft_id);
								$optionDataInputs= array(
								  'order_summary_id' => $summaryID,
								  'wo_order_id' => $wo_order_id,
								  'option_saved'=>1
								);
								$this->workorder_model->update_orders_option_final_new($optionDataInputs,$offline_draft_id,'offline');
 								$inc++;
							}
						}
						//if($wo_item_query!=""){
							//$summary = $this->workorder_model->insert_work_summary($wo_item_query);
							//$draft_rows=$this->formdata_model->remove_offline_draft($id,$this->session->userdata('loginid'));
						//}
						redirect('workorder/details/'.$orderRow['order_uuid']);
					}else{
						$this->session->set_flashdata('error','Something wrong... Please try later !!!');
						redirect('workorder/add/'.$id);
					}
				}else{
					$this->session->set_flashdata('error','Work order number already taken');
					redirect('workorder/add/'.$id);
				}
			}else{
				$this->session->set_flashdata('error','Work order already created with this lead');
				redirect('workorder/add/'.$id);
			}
		}
	
	}else{
		$this->session->set_flashdata('error','Invalid form action');
		redirect('workorder/add/'.$orderRow['order_uuid']);
	}		}
	public function offline_ajax_post_edit(){
	  if($this->input->post('submit')){
			$this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
		  $this->form_validation->set_rules('current_woid', 'Lead details', 'trim|required');
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
				//echo $item_addons;
			
			  $draft_data = array(
				  
				  'wo_product_type_id' => $this->input->post('wo_product_type_id'),
				  'wo_collar_type_id' => $this->input->post('wo_collar_type_id'),
				  'wo_sleeve_type_id' => $this->input->post('wo_sleeve_type_id'),
				  'wo_fabric_type_id' => $this->input->post('wo_fabric_type_id'),
				  'wo_qty' => $this->input->post('wo_qty'),
				  'wo_img_back' => $this->input->post('wo_img_back'),
				  'wo_img_front' => $this->input->post('wo_img_front'),
				  'wo_remark' => $this->input->post('wo_remark'),
				  'item_addons'=>$item_addons,
				  'item_addons_names'=>$item_addons_names,
				  'item_addons_mk_time'=>$item_addons_mk_time,
				  'item_addons_mk_amt'=>$item_addons_mk_amt,
					'wo_rate' => $this->input->post('wo_rate'),
					'wo_discount' => $this->input->post('wo_discount'),
			  );
			$current_form_id=$this->input->post('current_woid');
			$offline_draft_id=$this->input->post('offline_draft_id');
			$this->formdata_model->update_offline_draft_data($draft_data,$offline_draft_id);
			$sizerow=$this->formdata_model->remove_order_option_item($offline_draft_id,$current_form_id);
			  $Option_qty=0;
			  if($_POST['options']){
				  $option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id,data_from) VALUES ";
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
						  $option_query.=" (NULL, '0', '$offline_draft_id', '0', '$current_form_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
					  }else{
						  $option_query.=",(NULL, '0', '$offline_draft_id', '0', '$current_form_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
					  }
					  $option_count++;
				  }
				  //echo $option_query;exit;
				  if($option_query!=""){
					  $summary = $this->workorder_model->insert_wo_options($option_query);
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
	  }
  }
	public function offlinemodeledit($offline_draft_id=0){
	  $data['product_fit'] = $this->workorder_model->get_product_fit();
	  $data['product_size'] = $this->workorder_model->get_product_size();
	  $data['fabric_types'] = $this->workorder_model->get_fabric_types();
	  $data['collar_types'] = $this->workorder_model->get_collar_types();
	  $data['sleeve_types'] = $this->workorder_model->get_sleeve_types();
	  $data['product_types'] = $this->workorder_model->get_product_types();
	  $data['order_nature'] = $this->workorder_model->get_order_nature();
	  $data['addons'] = $this->workorder_model->get_addons();
	  $data['shipping_types'] = $this->workorder_model->get_shipping_types();
	  $data['offline_draft_id'] = $offline_draft_id;
	  $this->load->view('formdata/offlinemodeledit',$data);
  }
	public function remove_summary_item($sid=0){
	  $refData = $this->formdata_model->get_summary_draft_data($sid);
	  $current_form_id=$refData['current_form_id'];
	  $this->formdata_model->remove_summary_item($sid);
	  $offline_draft_id=$refData['offline_draft_id'];
	  $sizerow=$this->formdata_model->remove_order_option_item($offline_draft_id,$current_form_id);
	  //$current_id=$current_form_id;
	 $current_l_id=$this->session->userdata('loginid');;
	  $data['summary_drafts'] = $this->formdata_model->get_offline_order_draft($current_form_id,$current_l_id);
	  //$data['view']='workorder/online';
	  $this->load->view('formdata/draft_data',$data);
	}
	public function draft_data(){
	  $current_id=$_POST['current_id'];
	  $current_l_id=$this->session->userdata('loginid');;
	  //echo $csession_id."==".$current_l_id;
	  $data['summary_drafts'] = $this->formdata_model->get_offline_order_draft($current_id,$current_l_id);
	  //$data['view']='workorder/online';
	  $this->load->view('formdata/draft_data',$data);
  }
	public function save_to_summary(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
			$this->form_validation->set_rules('order_id', 'Order details', 'trim|required');
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
				//echo $item_addons;
				$wo_product_type_id=trim(addslashes(htmlentities($_POST['wo_product_type_id'])));
				$product_type_row=$this->settings_model->get_producttype_data($wo_product_type_id);
				$wo_product_type_name=$product_type_row['product_type_name'];
				$wo_product_type_value=$product_type_row['product_type_amount'];
				$wo_product_making_time=$product_type_row['product_making_time'];
				
				$wo_collar_type_id=trim(addslashes(htmlentities($_POST['wo_collar_type_id'])));
				$collar_type_row=$this->settings_model->get_collartype_data($wo_collar_type_id);
				$wo_collar_type_name=$collar_type_row['collar_type_name'];
				$wo_collar_type_value=$collar_type_row['collar_amount'];
				$wo_collar_making_min=$collar_type_row['collar_making_min'];
				
				$wo_sleeve_type_id=trim(addslashes(htmlentities($_POST['wo_sleeve_type_id'])));
				$sleeve_type_row=$this->settings_model->get_sleevetype_data($wo_sleeve_type_id);
				$wo_sleeve_type_name=$sleeve_type_row['sleeve_type_name'];
				$wo_sleeve_type_value=$sleeve_type_row['sleeve_type_amount'];
				$wo_sleeve_making_time=$sleeve_type_row['sleeve_making_time'];
				
				$wo_fabric_type_id=trim(addslashes(htmlentities($_POST['wo_fabric_type_id'])));
				$fabric_type_row=$this->settings_model->get_fabrictype_data($wo_fabric_type_id);
				$wo_fabric_type_name=$fabric_type_row['fabric_type_name'];
				$wo_fabric_type_value=$fabric_type_row['fabric_amount'];
				$wo_fabric_making_min=$fabric_type_row['fabric_making_min'];
				
				$wo_addon_id=0;
				$addon_row=$this->settings_model->get_addons_data($wo_addon_id);
				$wo_addon_name=$addon_row['addon_name'];
				$wo_addon_value=$addon_row['addon_amount'];
				$wo_addon_making_min=$addon_row['addon_making_min'];
				$wo_qty=trim(addslashes(htmlentities($_POST['wo_qty'])));
				$wo_rate=trim(addslashes(htmlentities($_POST['wo_rate'])));
				$wo_discount=trim(addslashes(htmlentities($_POST['wo_discount'])));
				$summaryData = array(
				'wo_order_id' => $_POST['order_id'],
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
				'wo_addon_id' => 0,
				'wo_addon_name' => 0,
				'wo_addon_value' => 0,
				'wo_qty' => $wo_qty,
				'wo_rate' => $wo_rate,
				'wo_discount' => $wo_discount,
				'wo_product_making_time' => $wo_product_making_time,
				'wo_collar_making_min' => $wo_collar_making_min,
				'wo_sleeve_making_time' => $wo_sleeve_making_time,
				'wo_fabric_making_min' => $wo_fabric_making_min,
				'wo_addon_making_min' => $wo_addon_making_min,
				'wo_item_addons' => $item_addons,
				'wo_item_addons_names' =>$item_addons_names,
				'wo_item_addons_mk_time' => $item_addons_mk_time,
				'wo_item_addons_mk_amt' => $item_addons_mk_amt,
				'wo_option_session_id'=>$_POST['current_s_id'],
				'wo_img_back' => $_POST['wo_img_back'],
				'wo_img_front' => $_POST['wo_img_front'],
				'wo_remark' => $_POST['wo_remark'],
				);
				$summaryID= $this->workorder_model->insert_work_summary_one_by_one($summaryData);
//-------------------------------------------------
				$Option_qty=0;
				$offline_draft_id=0;
				if($_POST['options']){
					$option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id,data_from) VALUES ";
					$option_count=0;
					$option_session_id=$this->input->post('current_s_id');
					$option_login_id=$this->input->post('current_l_id');
					$order_id=$this->input->post('order_id');
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
							$option_query.=" (NULL, '$summaryID', '$offline_draft_id', '$order_id', '$option_session_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
						}else{
							$option_query.=",(NULL, '$summaryID', '$offline_draft_id', '$order_id', '$option_session_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
						}
						$option_count++;
					}
					//echo $option_query;exit;
					if($option_query!=""){
						$summary = $this->workorder_model->insert_wo_options($option_query);
					}
			}
			$order_id=$this->input->post('order_id');
			$sumRow=$this->formdata_model->get_wo_order_summary_sum($order_id);
			$orderRow=$this->workorder_model->get_work_order($order_id);
			$total_rate=$sumRow['totalRate'];
			$total_disc=$sumRow['totalDiscount'];
			$rate=$total_rate-$total_disc;
			$rate=$rate+$orderRow['wo_additional_cost'];
			$tax=0;
			$taxamount=0;
			if($orderRow['wo_tax_value']){
				$tax=$orderRow['wo_tax_value'];
				$taxamount= ($tax / 100) * $rate;
			}
			$rate=$rate+$taxamount;
			$rate=$rate+$orderRow['wo_shipping_cost'];
			$wo_gross_cost=$rate-$orderRow['wo_adjustment'];
			$wo_balance=$wo_gross_cost-$orderRow['wo_balance'];
			//
			$orderData = array(
			'wo_gross_cost' => $wo_gross_cost,
			'wo_balance'=>$wo_balance);
			$this->workorder_model->update_wo_data($orderData,$order_id);


			$this->session->set_flashdata('success_draft','Order summary saved successfully');
			//redirect('workorder/online/'.$this->input->post('current_woid'));
			echo json_encode(array('responseCode'=>"success"));
//--------------------------------------------------


			}else{
				$responseMsg='
			  	<div class="alert alert-warning alert-dismissible" style="width:100%;">
			  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			  	<h4><i class="icon fa fa-warning"></i> Alert!</h4>
			  	'.validation_errors().'
			  	</div>';
			  	echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
			}
		}else{
			$responseMsg='
			<div class="alert alert-warning alert-dismissible" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Alert!</h4>Invalid action
			</div>';
			echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
		}
	}
	public function online_ajax_post(){
	  if($this->input->post('submit')){
		 
			$this->form_validation->set_rules('wo_qty', 'Quantity', 'trim|required');
		  $this->form_validation->set_rules('current_woid', 'Lead details', 'trim|required');
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
				//echo $item_addons;
			
			  $draft_data = array(
				  'current_form_id' => $this->input->post('current_woid'),
				  'wo_product_type_id' => $this->input->post('wo_product_type_id'),
				  'wo_collar_type_id' => $this->input->post('wo_collar_type_id'),
				  'wo_sleeve_type_id' => $this->input->post('wo_sleeve_type_id'),
				  'wo_fabric_type_id' => $this->input->post('wo_fabric_type_id'),
				  'wo_qty' => $this->input->post('wo_qty'),
				  'wo_img_back' => $this->input->post('wo_img_back'),
				  'wo_img_front' => $this->input->post('wo_img_front'),
				  'wo_remark' => $this->input->post('wo_remark'),
				  'current_session_id' => $this->input->post('current_s_id'),
				  'current_login_id' => $this->input->post('current_l_id'),
				  'item_addons'=>$item_addons,
				  'item_addons_names'=>$item_addons_names,
				  'item_addons_mk_time'=>$item_addons_mk_time,
				  'item_addons_mk_amt'=>$item_addons_mk_amt,
				'wo_rate' => $this->input->post('wo_rate'),
					'wo_discount' => $this->input->post('wo_discount'),
			  );
			$current_form_id=$this->input->post('current_woid');
			  $offline_draft_id= $this->formdata_model->insert_offline_draft_data($draft_data);
			  $Option_qty=0;
			  if($_POST['options']){
				  $option_query="INSERT INTO `wo_order_options` (`order_option_id`, `order_summary_id`, `online_draft_id`, `wo_order_id`, `wo_current_form_no`, `option_name`, `option_number`, `option_size_id`, `option_size_value`, `option_qty`, `option_saved`,fit_type_id,customer_item_info,option_session_id,option_login_id,data_from) VALUES ";
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
						  $option_query.=" (NULL, '0', '$offline_draft_id', '0', '$current_form_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
					  }else{
						  $option_query.=",(NULL, '0', '$offline_draft_id', '0', '$current_form_id', '$option_name', '$option_number', '$option_size_id', '$option_size_value', '$option_qty', '0','$option_fit','$option_info','$option_session_id','$option_login_id','offline')";
					  }
					  $option_count++;
				  }
				  //echo $option_query;exit;
				  if($option_query!=""){
					  $summary = $this->workorder_model->insert_wo_options($option_query);
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
	  }
  }
	public function offlinemodel(){
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
		$this->load->view('formdata/offlinemodel',$data);
	}
  
}
