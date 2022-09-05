<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dispatch extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('dispatch_model', 'dispatch_model');
		$this->load->model('accounts_model', 'accounts_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('notification_model', 'notification_model');
		 $this->load->library('msg91');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}

	public function list_works_dispatch($type){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data_by_fields($loginid);
		$records = $this->dispatch_model->get_works_dispatch($staffRow['department_id'],$staffRow['unit_managed'],$type);
		
		$data = array();
		$dis="";

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
		
			$st='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#statusInfo"  data-sid="'.$row['schedule_department_id'].'" data-fd="dispatch" data-did="'.$staffRow['department_id'].'">View Status</a>';

			if($row['wo_product_info']!=""){
				$quicInfo='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#scheduleInfo"  data-sid="'.$row['schedule_department_id'].'" title="'.$row['wo_product_info'].'" >'.substr($row['wo_product_info'],0,30).'..</a>';
			}else{
				$quicInfo='<a href="#" class=" mt-1 mb-1 float-center w-100"  style="cursor: pointer;"  data-toggle="modal" data-target="#scheduleInfo"  data-sid="'.$row['schedule_department_id'].'"  >Nil</a>';
			}
			
if($row['account_status']!="" && $row['account_status'] > 0 && $row['account_status'] =="1")
{
					$dis='<a href="'.base_url('dispatch/dispatch_order/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'/'.$lastUpdateRow['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-success mt-1" style="cursor: pointer;"><i class="fa fa-edit" ></i>Manage Dispatch</label></a>';
}			
else
{
	
				$dis='<a href="#" title="View" style="cursor: pointer;"><label class="badge badge-danger mt-1" style="cursor: pointer;"><i class="fa fa-ban" ></i>Not Approved</label></a>';
}			

			$data[]= array(
			'<td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>',
			'<td><span class="badge badge-success" >'.$row['orderform_number'].' (S'.$tschedules.')</span>'.$re.'</td>',
			'<td><span class="badge" >'.substr($row['wo_date_time'],0,10).'<br/>'.substr($row['wo_date_time'],10,10).'</span></td>',
			date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])),
			$sales_handler,
			$quicInfo,
			$st,
			$dis.$option
			);
			
			}
		$records['data']=$data;
//print_r($records['data']);
		echo json_encode($records);	
	}
	
	public function drop(){ 
		$id=$_POST['id'];
		$this->dispatch_model->delete_tracking($id);
		$this->dispatch_model->delete_dispatch($id);
		echo 1;
	}
	public function load_dispatch_model(){ 
		$data['shipping_modes']=$this->dispatch_model->get_shipping_modes();
		$data['shipping_types']=$this->dispatch_model->get_shipping_types();
		//$data['dispatch_row']=$this->dispatch_model->get_dispatch_row($_POST['dipsid']);
		$this->load->view('dispatch/dispatch_model',$data);
	}
	public function save_dispatch(){
		if($this->input->post('submitData')){
			$this->form_validation->set_rules('dispatch_date', 'Dispatch date', 'trim|required');
			$this->form_validation->set_rules('dispatch_client_name', 'Customer name', 'trim|required');
			$this->form_validation->set_rules('dispatch_address', 'Dispatch address', 'trim|required');
			//$this->form_validation->set_rules('shipping_qty', 'Quantity', 'trim|required');
			$this->form_validation->set_rules('shipping_type_id', 'Shipping type', 'trim|required');
			$this->form_validation->set_rules('shipping_mode_id', 'Shipping mode', 'trim|required');
			$this->form_validation->set_rules('dispatch_status', 'Dispatch status', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg=validation_errors();
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
			}else{
				$rs_design_id=$this->input->post('rs_design_id');
				$up_dis="UPDATE rs_design_departments SET submitted_to_dispatch='1' WHERE rs_design_id='$rs_design_id'  ";
				$customer_phone_no=str_replace(' ', '',$this->input->post('mobile_number'));
				$orderform_type_id=$this->input->post('orderform_type_id');
if($orderform_type_id==2)
{
$wo_ref_no=$this->input->post('wo_ref_no');
}
				//$this->db->query($up_dis);
				//echo 'dfgdfgdfg';exit;
				$dataTracking = array(
					'order_id'=> $this->input->post('dispatch_order_id'),
					'dispatch_id' => 0,
					'traking_number' => $this->input->post('tracking_number'),
					'traking_info' => $this->input->post('tracking_info'),
					'tracking_date' =>date('d-m-Y H:i:s'),
					'tracking_status' =>'Order Shipped'
				);
				$trackingid= $this->dispatch_model->insert_tracking($dataTracking);
				if($_POST['dispatchPost']){

//exit;
					$dispatch_ids=0;
					foreach($_POST['dispatchPost'] as $postROW){
						$dispatch_item_id=$postROW['order_summary_id'];
						$dispatch_item_qty=$postROW['dispatch_qty'];
						$completed_id=$postROW['completed_id'];
						if($dispatch_item_qty!=0){
							
							$data = array( 
								'tracking_id'=>$trackingid,
								'dispatch_order_id' => $this->input->post('dispatch_order_id'),
								'dispatch_order_item_id' => $dispatch_item_id,
								'dispatch_date' => $this->input->post('dispatch_date'),
								'dispatch_customer_id'=>$this->input->post('dispatch_customer_id'),
								'dispatch_client_name' => $this->input->post('dispatch_client_name'),
								'dispatch_address' => $this->input->post('dispatch_address'),
								'shipping_qty' => $dispatch_item_qty,
								'shipping_type_id' => $this->input->post('shipping_type_id'),
								'shipping_mode_id' => $this->input->post('shipping_mode_id'),
								'dispatch_address' => $this->input->post('dispatch_address'),
								'dispatch_by' => $this->session->userdata('loginid'),
								'dispatch_datetime' =>date('d-m-Y H:i:s'),
								'dispatch_status' => 1,
								'dispatch_customer_mobile_no' => $customer_phone_no,
							);
							//print_r($data);
							$dispatch_id= $this->dispatch_model->insert_dispatch($data);
							$dispatch_ids.=",".$dispatch_id;
						}
					}
					$updataTracking= array('dispatch_id'=>$dispatch_ids);
					$this->dispatch_model->update_tracking($updataTracking,$trackingid);
				}

				//------------------------------------------------
				$hidden_order_id=$this->input->post('dispatch_order_id');
				//$hidden_order_item_name=$this->input->post('hidden_order_item_name');
				//$approved_qty=$this->input->post('item_unit_qty_input');
				$order_row=$this->notification_model->get_wo_info($hidden_order_id);
				//$recipient=$this->notification_model->get_users_form_production();
				if($order_row['wo_owner_id']!=""){ // staff id
					$notification_recipients=$order_row['wo_owner_id'];
					$created_by=$this->session->userdata('loginid');
					if($created_by==0){
						$owner='Admin';
						$notification_from="Admin";
					}else{ 
						$owner=$this->session->userdata('log_full_name');
						$notification_from=$this->session->userdata('loginid');
					}
				
					$notification_content=" Your order no:  ".$order_row['orderform_number']." waybill has been updated";
					$notification_title="Waybill number";
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

//sms
if($customer_phone_no !='' && $this->input->post('tracking_number') !='')
{
	$shippingNameArray=$this->workorder_model->get_shipping_modes_by_id($this->input->post('shipping_mode_id'));

$shipping_name=$shippingNameArray['shipping_mode_name'];
if($orderform_type_id==1)
{
$sms_status=$this->msg91->send_dispatch_order_sms($customer_phone_no,$order_row['orderform_number'],$this->input->post('tracking_number'),$shipping_name);
}
elseif($orderform_type_id==2)
{
$sms_status=$this->msg91->send_online_dispatch_order_sms($customer_phone_no,$wo_ref_no,$this->input->post('tracking_number'),$shipping_name);
}
//error_log("Sms Status sending==".$sms_status,0);
}
				//------------------------------------------------					
				


				$msg='<br/><div class="alert alert-success mt-1" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>Dispatch details saved successfully</div>';
				echo json_encode(array('responseCode'=>"S",'responseMsg'=>$msg));
				exit;
			}
		}
	}
	public function load_dispatch_online_data(){
		$data['shipping_modes']=$this->dispatch_model->get_shipping_modes();
		$data['shipping_types']=$this->dispatch_model->get_shipping_types();
		
		$this->load->view('dispatch/dispatch_data_online',$data);
	}
	public function load_dispatch_data(){
		$data['shipping_modes']=$this->dispatch_model->get_shipping_modes();
		$data['shipping_types']=$this->dispatch_model->get_shipping_types();
		
		$this->load->view('dispatch/dispatch_data',$data);
	}
	public function dispatch_order($uuid=0,$sdid=0,$rs_design_id=0){
		//echo $rs_design_id;
		//die("Testing");
		$data['title']="Order | View";
		$data['title_head']="Order Submitted | View";
		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$data['rowResponse']=$this->accounts_model->get_final_qc_data_for_accounts($rs_design_id);
		$data['order_info']=$this->dispatch_model->get_order_data_by_order_id($data['schedule_data']['order_id']);
		$data['staffRow']=$staffRow;
	
		if($staffRow['department_id']==10){
			$data['request_row']=$this->dispatch_model->get_fusing_request_row($rs_design_id);
			//$data['view']='dispatch/dispatch_order_view_single_final';
			$data['view']='dispatch/dispatch_order';
			$this->load->view('layout',$data);
		}
		
	}

} 
