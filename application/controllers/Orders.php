<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('order_model', 'order_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('calendar_model', 'calendar_model');
		$this->load->model('notification_model', 'notification_model');
		$this->load->library('datatable');
		$this->load->library('msg91');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	//---------------------------------------------------------------------------------------------------
	function order_summary(){
		$data['row']= $this->workorder_model->get_order_data_by_uuid($_POST['uid']);
		$data['summary_info']=$this->schedule_model->get_order_summary_in_detail_info($_POST['oid']);
		$this->load->view('orders/summary_info',$data);
	}
	function overview_result(){
		$accessArray=$this->rbac->check_operation_access(); 
		$data['accessArray']=$accessArray;
		$start_date =$this->input->post('start_date');
		$end_date =$this->input->post('end_date');
		$unit_id =$this->input->post('unit_id');
		$data['dates']=$this->schedule_model->get_dates_from_scheduled_dptmt($start_date,$end_date,$unit_id);
		$this->schedule_model->remove_unwanted_schedules();
		$this->load->view('orders/overview_result',$data);
	}
	function overview(){
		
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		//print_r($accessArray);
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			$loginid=$this->session->userdata('loginid');
			if($loginid!=1){
			if($accessArray){if(!in_array("overview",$accessArray)){
			redirect('access/access_denied');
			}}
			}
		}
		
		$data['title']=$accessArray['module_parent']." | Schedule Overview";
		$data['title_head']=$accessArray['menu_name'];
		$data['punits']= $this->schedule_model->get_my_business_unit('');
		$data['view']='orders/overview';
		$this->load->view('layout',$data);
		
	}
	
	//---------------------------------------------------------------------------------------------------
	function schedule_summary(){
		//echo $_POST['ps'];
		$start_date = date('Y-m-d', $_POST['ps']);
		$end_date = date('Y-m-d', $_POST['pe']);
		$data['dates']=$this->schedule_model->get_dates_from_scheduled_dptmt($start_date,$end_date,'');
		$this->load->view('orders/schedule_summary',$data);
	}
	//---------------------------------------------------------------------------------------------------
	function save_schedule(){
		
		if($this->input->post('submitSheduleData')){
			$this->form_validation->set_rules('order_id', 'Order details', 'trim|required');
			$this->form_validation->set_rules('schedule_unit_id', 'Unit', 'trim|required');
			if($_POST['schedule']==""){
				$this->form_validation->set_rules('schedule', 'Order item', 'trim|required');
			}
			if ($this->form_validation->run() == TRUE) {

				
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$now = date('d-m-Y H:i:s');
				$schedule_is_completed=0;
				if($this->input->post('order_balance_qty')==0){
					$schedule_is_completed=1;
				}
				$unitid=$this->input->post('schedule_unit_id');
				$total_order_second=0;
				$sh_order_json="[";
				$order_item_group="";
				if($_POST['schedule']!=""){
					$inccc=0;
					
					$k=0;
					$ins="INSERT INTO `sh_schedule_item_qty` (`schedule_item_qty_id`, `schedule_uuid`,orderid, `order_summery_id`,item_position,order_total_qty,`sh_qty`,item_json) VALUES ";
					$items_count=0;
					foreach($_POST['schedule'] as $SH){
						//$item_qty=$SH['item_unit_qty'.$unitid];
						$item_qty=$SH['item_unit_qty_input'];
						$summary_id=$SH['summary_id'];
						$order_total_qty=$SH['item_order_qty'];
						$item_position=$SH['item_position'];
			
						if($item_qty!=0){
							$items_count++;
							if($k==0){
								$ins.="(NULL, '".$this->input->post('schedule_uuid')."','".$this->input->post('order_id')."','$summary_id','$item_position','$order_total_qty','$item_qty','".json_encode($SH)."')";
								$order_item_group=$summary_id;
							}else{
								$ins.=",(NULL, '".$this->input->post('schedule_uuid')."','".$this->input->post('order_id')."', '$summary_id','$item_position','$order_total_qty','$item_qty','".json_encode($SH)."')";
								$order_item_group.="-".$summary_id;
							}
							$item_second=$SH['item_order_sec'];
							$total_order_second+=$item_second*$item_qty;
							$k++;
							
						}
						//echo json_encode($SH);
						if($inccc==0){
						$sh_order_json.=json_encode($SH);
						}else{
							$sh_order_json.=",".json_encode($SH);
						}
						$inccc++;
					}
				}
				//exit;
				//echo $total_order_second;
				$sh_order_json.="]";
				
				$save_data1 = array(
					'schedule_uuid' => $this->input->post('schedule_uuid'),
					'parent_schedule_id' => $this->input->post('parent_schedule_id'),
					'order_id' => $this->input->post('order_id'),
					'schedule_code' => $this->input->post('schedule_code'),
					'schedule_unit_id' => $unitid,
					'schedule_date' => $this->input->post('schedule_date'),
					'schedule_end_date' => $this->input->post('production_end_date'),
					'production_stitching_date'=>$this->input->post('production_stitching_date'),
					'schedule_c_by' => $this->session->userdata('loginid'),
					'schedule_c_date' =>date('Y-m-d'),
					'schedule_u_by' => $this->session->userdata('loginid'),
					'schedule_u_date' =>date('Y-m-d'),
					'schedule_time_stamp' => $now,
					'schedule_is_completed' =>$schedule_is_completed,
					'order_total_qty' => $this->input->post('order_total_qty'),
					'order_total_submitted_qty' => $this->input->post('order_total_submitted_qty'),
					'order_balance_qty' => $this->input->post('order_balance_qty'),
					'sh_order_json' => $sh_order_json,
					'total_order_second' => $total_order_second,
					'schedule_status' =>$schedule_is_completed
				);
				//exit;
				
				$schedule_id=$this->schedule_model->save_schedule_data($save_data1);
				$this->schedule_model->save_schedule_qty_data($ins);
				
				$shedule_id_data = array(
					'scheduled_id' =>$schedule_id
				);
				$this->schedule_model->update_schedule_ids($shedule_id_data,$this->input->post('schedule_uuid'));
				
				$schedule_date=$this->input->post('schedule_date');
				$production_end_date=$this->input->post('production_end_date');
				$production_stitching_date=$this->input->post('production_stitching_date');
				
				
				$day_data_row=$this->schedule_model->get_unit_day_info($production_stitching_date,$unitid);
				$per_sum=0;
				$sec_sum=0;
				if($day_data_row['schedule_unit_percentage']!=''){
					$per_sum=$day_data_row['schedule_unit_percentage'];
				}
				
				if($day_data_row['schedule_unit_percentage_sec']!=''){
					$sec_sum=$day_data_row['schedule_unit_percentage_sec'];
				}
				//die("testing 12345");
				
				$system_working_capacity_sec=$this->input->post('system_working_capacity_sec');
				$unit_working_capacity_in_sec=$this->input->post('unit_working_capacity_in_sec');
				
				$schedule_unit_percentage1=$total_order_second/$unit_working_capacity_in_sec;
				$schedule_unit_percentage=$schedule_unit_percentage1*100;
				
				$order_per=round(number_format($schedule_unit_percentage,2));
				$final_per=$order_per+$per_sum;
				$final_sec=$total_order_second+$sec_sum;
				
				$u_data = array(
					'schedule_unit_percentage' =>$final_per,
					'schedule_unit_percentage_sec' => $final_sec,
				);
				$this->schedule_model->update_unit_calender_time($u_data,$production_stitching_date,$unitid);
				
				$sdata123 = array('scheduled_order_seconds' =>$total_order_second);
				$this->schedule_model->update_schedule_data($sdata123,$schedule_id);
				$schedule_department_ids=0;
				if($_POST['departments']!=""){
					$batch_number= date('YmdHis');
					foreach($_POST['departments'] as $DEP){
						$department_schedule_date=trim(addslashes(htmlentities($DEP['department_schedule_date'])));
						$department_ids=trim(addslashes(htmlentities($DEP['department_ids'])));
						$dataa = array(
							'schedule_id' => $schedule_id,
							'department_ids' => $department_ids,
							'department_schedule_date' => $department_schedule_date,
							'unit_id' =>$unitid,
							'order_id' =>$this->input->post('order_id'),
							'scheduled_order_info'=>$sh_order_json,
							'batch_number'=>$batch_number,
							'total_order_items'=>$items_count
						);
						$schedule_department_id=$this->schedule_model->save_department_data($dataa);
						$schedule_department_ids.=','.$schedule_department_id;
					}
				}
				$dataQtyArray=array('schedule_department_ids'=>$schedule_department_ids);
				$schedule_department_id=$this->schedule_model->update_schedule_qty_data($dataQtyArray,$schedule_id,$this->input->post('order_id'));
				$woArray=$this->schedule_model->get_wo_items_total($this->input->post('order_id'));
				$shArray=$this->schedule_model->get_sh_items_total($this->input->post('order_id'));

				$unitTypeArray=$this->workorder_model->get_order_data_unit_type($this->input->post('order_id'));




				$anyThing=0;
				$WOQTY=0;
				if($woArray['WOQTY']!=""){
					$WOQTY=$woArray['WOQTY'];
				}
				$SHQTY=0;
				if($shArray['SHQTY']!=""){
					$SHQTY=$shArray['SHQTY'];
				}
				
				$anyThing=$WOQTY-$SHQTY;
				
				//------------------------------------------------
					$recipient=$this->notification_model->get_wo_sales_person($this->input->post('order_id'));
					if($recipient['wo_owner_id']!=""){ // staff id
						$notification_recipients=$recipient['wo_owner_id'];
						$created_by=$this->session->userdata('loginid');
						if($created_by==1){
							$owner='Admin';
							$notification_from="Admin";
						}else{ 
							$owner=$this->session->userdata('username');
							$notification_from=$created_by;
						}
						$notification_content='Your order no.'.$recipient['orderform_number'].' has been scheduled by '.$owner;
						$notification_title="On scheduling order";
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

					//sms integration
					if($unitTypeArray['orderform_type_id'] ==1)
					    {
						$customerArray=$this->workorder_model->get_order_data_by_order_id($this->input->post('order_id'));
						
						if($customerArray)
						    {
							if($customerArray['scheduled_sms_status'] !=1)
							    {
							    $customer_phone_no=$customerArray['customer_mobile_no'];
							    
							    if($customer_phone_no!='')
								{
								    $sms_status=$this->msg91->send_schedule_order_sms($customer_phone_no);
								    if($sms_status==1)
									{
									    $sdataSms = array(
											      'scheduled_sms_status' =>1,
											      );
									    $this->workorder_model->update_wo_data($sdataSms,$this->input->post('order_id'));
									}
								}
							    
							    }
						    }
					    }
					
				if($anyThing==0){
					$sdata = array(
						'schedule_status' =>1,
						'schedule_is_completed'=>1,
					);
					$this->schedule_model->update_schedule_data($sdata,$schedule_id);
					$responseMsg='<div class="alert alert-success alert-dismissible mt-2" style="width:100%;">
					<h4>Success!</h4>
					<p>Your order scheduled successfully</p>
					<p>Please wait. Redirecting soon...</p>
					</div>';
					$this->session->set_flashdata('success','Order scheduled successfully');
					echo json_encode(array('responseCode'=>"S",'responseMsg'=>$responseMsg,'nxtForm'=>"no"));
				}else{
					$nxtDate=date('Y-m-d', strtotime($schedule_date. ' + 1 day'));
					$unit_id=$this->input->post('schedule_unit_id');
					//exit;


					$responseMsg='<div class="alert alert-success alert-dismissible mt-2" style="width:100%;">
					<h4>Success!</h4>
					<p>Your order scheduled successfully</p>
					<p><i class="fa fa-spin fa-refresh"></i> Please wait balance order detalis form generating...</p>
					</div>
					';
					echo json_encode(array('responseCode'=>"S",'responseMsg'=>$responseMsg,'nxtForm'=>"yes",'schedule_id'=>$schedule_id,'schedule_date'=>$nxtDate,'unit_id'=>$unit_id));
				}
			}else{
				$responseMsg='<div class="alert alert-warning alert-dismissible mt-2" style="width:100%;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<h4><i class="fa fa-ban"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$responseMsg));
			}
		}
	}
	//---------------------------------------------------------------------------------------------------
	
	function online_filter()
	{
		$this->session->set_userdata('wo_date',$this->input->post('wo_date'));
		$this->session->set_userdata('wo_dispatch_date',$this->input->post('wo_dispatch_date'));
		$this->session->set_userdata('orderform_number',$this->input->post('orderform_number'));
		$this->session->set_userdata('wo_staff_name',$this->input->post('wo_staff_name'));
		$this->session->set_userdata('wo_customer_name',$this->input->post('wo_customer_name'));
		$this->session->set_userdata('wo_work_priority_id',$this->input->post('wo_work_priority_id'));
		$this->session->set_userdata('orderform_type_id',$this->input->post('orderform_type_id'));
		$this->session->set_userdata('wo_ref_numbers',$this->input->post('wo_ref_numbers'));
		$this->session->set_userdata('is_scheduled',$this->input->post('is_scheduled'));
	}
		
	function offline_filter()
	{
		//print_r($_POST);
		$this->session->set_userdata('offline_wo_date',$this->input->post('offline_wo_date'));
		$this->session->set_userdata('offline_wo_dispatch_date',$this->input->post('wo_dispatch_date'));
		$this->session->set_userdata('offline_orderform_number',$this->input->post('orderform_number'));
		$this->session->set_userdata('offline_wo_staff_name',$this->input->post('wo_staff_name'));
		$this->session->set_userdata('offline_wo_customer_name',$this->input->post('wo_customer_name'));
		$this->session->set_userdata('offline_wo_work_priority_id',$this->input->post('wo_work_priority_id'));
		$this->session->set_userdata('offline_is_scheduled',$this->input->post('is_scheduled'));

	}
	
	//---------------------------------------------------------------------------------------------------
	
	public function schedule($id=0){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("schedule",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		$row= $this->order_model->get_order_data_by_uuid_for_schedule($id);
		if($row==""){
			$this->session->set_flashdata('error','Invalid work order.');
			redirect('orders/index');
		}
		$data['row']=$row;
		$data['summary']=$this->workorder_model->get_order_summary_in_detail($row['order_id']);
		//$data['sumTotal']=$this->order_model->get_sum_making_time($row['order_id']);
		$data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
		$data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
		$data['punits']= $this->schedule_model->get_my_business_unit('');
		$data['view']='orders/schedule';
		$this->load->view('layout',$data);
	}
	
	//---------------------------------------------------------------------------------------------------
	
	public function online_schedule($id=0){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("schedule",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		
		$data['title']=$accessArray['module_parent']." | Online";
		$data['title_head']=$accessArray['menu_name'];
		$row= $this->order_model->get_order_data_by_uuid_for_schedule($id);
		if($row==""){
			$this->session->set_flashdata('error','Invalid work order.');
			redirect('orders/index');
		}
		$data['row']=$row;
		$data['summary']=$this->workorder_model->get_order_summary_in_detail_online($row['order_id']);
		$data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
		$data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
		$data['punits']= $this->schedule_model->get_my_business_unit('');
		$data['view']='orders/online_schedule';
		$this->load->view('layout',$data);
	}
	
	//---------------------------------------------------------------------------------------------------
	
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
		$row= $this->workorder_model->get_order_data_by_uuid($id);
		if($row==""){
			$this->session->set_flashdata('error','Invalid work order.');
			redirect('orders/index');
		}
		$data['row']=$row;
		$data['summary']=$this->workorder_model->get_order_summary_in_detail($row['order_id']);
		$data['images']= $this->workorder_model->get_wo_documents($row['order_id'],'image');
		$data['Attachment']= $this->workorder_model->get_wo_documents($row['order_id'],'document');
		$data['view']='orders/view';
		$this->load->view('layout',$data);
	}
	
	
	//---------------------------------------------------------------------------------------------------
	
	public function online_view($id=0){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("view",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['title']=$accessArray['module_parent']." | Online";
		$data['title_head']=$accessArray['menu_name'];
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
		$data['view']='orders/online_view';
		$this->load->view('layout',$data);
	}
	
	//---------------------------------------------------------------------------------------------------
	
	public function offline_wo_list(){
			$accessArray=$this->rbac->check_operation_access(); 
			$records = $this->order_model->get_all_offline_production_orders();
			$data = array();
			$i=0;
			foreach ($records['data']  as $row) 
			{  
				//$summary_info=$this->schedule_model->get_order_summary_in_detail_info($row['order_id']);
				
				if($row['schedule_id']!="" ){
					$clr='success';
					$sheduled='<i class="fa fa-check-circle font-weight-bold ml-auto px-1 py-1 text-success"></i>';
				}else{
					$clr='danger';
					$sheduled='<i class="fa fa-exclamation-circle font-weight-bold ml-auto px-1 py-1 text-danger"></i>';
				}
				
				//data-toggle="popover" title="Popover title" data-content="Sed posuere consectetur est at lobortis. Aenean eu leo quam."
				$orderform_number=$sheduled.'<button type="button" class="badge  popov" data-toggle="modal" data-target="#productionSummary" style="background:'.$row['priority_color_code'].';border:#333;" data-oid="'.$row['order_id'].'" data-uid="'.$row['order_uuid'].'" >'.$row['orderform_number'].'</button>';
				$option='<td>';
				if($accessArray){if(in_array("view",$accessArray)){
				$option.='<a href="'.base_url('orders/view/'.$row['order_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
				}}
				
				if($row['wo_row_status']==1 && $row['submited_to_production']=='yes'){
					if($accessArray){if(in_array("schedule",$accessArray)){
					$option.='&nbsp;<a href="'.base_url('orders/schedule/'.$row['order_uuid']).'" title="Schedule order" style="cursor: pointer;"><label class="badge badge-'.$clr.'" style="cursor: pointer;"><i class="fa fa-calendar" ></i></label></a>';
					}} 
					
				}
				
				$option.='</td>';
				$data[]= array(
					$orderform_number,
					$row['customer_name']."<br/>".$row['customer_email']."<br/>".$row['customer_mobile_no'],
					$row['staff_code']." : ".$row['staff_name'],
					substr($row['wo_date_time'],0,10),
					date("d-m-Y", strtotime($row['wo_dispatch_date'])),
					'<td ><label class="'.$row['style_class'].'">Submited On <br/>'.$row['submited_date'].'</label></td>',
					$option
				);
			}
			$records['data']=$data;
			echo json_encode($records);							   
	}
	
	//---------------------------------------------------------------------------------------------------
	
	public function online_wo_list(){
			$accessArray=$this->rbac->check_operation_access(); 
			$records = $this->order_model->get_all_online_production_orders();
			//print_r($records);
			$data = array();
			$i=0;
			foreach ($records['data']  as $row) 
			{  
				
				if($row['schedule_id']!="" ){
					$clr='success';
					$sheduled='<i class="fa fa-check-circle font-weight-bold ml-auto px-1 py-1 text-success"></i>';
				}else{
					$clr='danger';
					$sheduled='<i class="fa fa-exclamation-circle font-weight-bold ml-auto px-1 py-1 text-danger"></i>';
				}
				//$summary_info=$this->schedule_model->get_order_summary_in_detail_info($row['order_id']);
				
				//data-toggle="popover" title="Popover title" data-content="Sed posuere consectetur est at lobortis. Aenean eu leo quam."
				$orderform_number=$sheduled.'<button type="button" class="badge  popov" data-toggle="modal" data-target="#productionSummary" style="background:'.$row['priority_color_code'].';border:#333;" data-oid="'.$row['order_id'].'" data-uid="'.$row['order_uuid'].'" >'.$row['orderform_number'].'</button>';
				
				$option='<td>';
				if($accessArray){if(in_array("view",$accessArray)){
				$option.='<a href="'.base_url('orders/online_view/'.$row['order_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
				}}
				
				if($row['wo_row_status']==1 && $row['submited_to_production']=='yes'){
					if($accessArray){if(in_array("schedule",$accessArray)){
					$option.='&nbsp;<a href="'.base_url('orders/online_schedule/'.$row['order_uuid']).'" title="Schedule order" style="cursor: pointer;"><label class="badge badge-'.$clr.'" style="cursor: pointer;"><i class="fa fa-calendar" ></i></label></a>';
					}} 
					
				}
								
				$option.='</td>';
				$cust=explode('|',$row['wo_customer_name']);
				$c='<ul class="list-ticked">';
					if($cust){
					$cust_names='';
					foreach($cust as $css){
						$c.='<li>'.$css.'</li>';
					}
				}
                $c.='</ul>';
				$ref=explode(',',$row['wo_ref_numbers']);
				$r='<ul class="list-ticked">';
					if($ref){
					foreach($ref as $rfno){
						$r.='<li>'.$rfno.'</li>';
					}
				}
                $r.='</ul>';
				$data[]= array(
					$orderform_number.$r,
					$c,
				
					substr($row['wo_date_time'],0,10),
					date("d-m-Y", strtotime($row['wo_dispatch_date'])),
					'<td ><label class="'.$row['style_class'].'">Submited On <br/>'.$row['submited_date'].'</label></td>',
					$option
				);
			}
			$records['data']=$data;
			echo json_encode($records);							   
	}
	
	//---------------------------------------------------------------------------------------------------
	
	public function online(){
		
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
		$this->session->unset_userdata('is_scheduled');

		$data['title']=$accessArray['module_parent']." | Online Orders";
		$data['title_head']=$accessArray['menu_name'];
		$data['priority']= $this->workorder_model->get_all_active_priority();
		$data['order_types'] = $this->workorder_model->get_order_types();
		$data['view']='orders/online_index';
		$this->load->view('layout',$data);
	}
	//---------------------------------------------------------------------------------------------------
	
	public function schedule_timeline(){
		
		$wo_uuid=$this->input->post('wo_uuid');
		$row= $this->workorder_model->get_order_data_by_uuid($wo_uuid);
		$data['row']=$row;
		$data['summary']=$this->order_model->get_order_summary_in_detail_list($row['order_id']);
		//$data['sumTotal']=$this->order_model->get_sum_making_time($row['order_id']);
		$this->load->view('orders/schedule_timeline',$data);
		
	}
	
	
	public function online_schedule_timeline(){
		
		$wo_uuid=$this->input->post('wo_uuid');
		$row= $this->workorder_model->get_order_data_by_uuid($wo_uuid);
		$data['row']=$row;
		$data['summary']=$this->order_model->get_order_summary_in_detail_list($row['order_id']);
		//$data['sumTotal']=$this->order_model->get_sum_making_time($row['order_id']);
		$this->load->view('orders/online_schedule_timeline',$data);
		
	}
	
	
	//---------------------------------------------------------------------------------------------------
	
	

	
	
	
	//---------------------------------------------------------------------------------------------------
	
	
	
	//---------------------------------------------------------------------------------------------------
	public function index(){
		
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		
		
		$this->session->unset_userdata('offline_wo_date');
		$this->session->unset_userdata('offline_wo_dispatch_date');
		$this->session->unset_userdata('offline_orderform_number');
		$this->session->unset_userdata('offline_wo_staff_name');
		$this->session->unset_userdata('offline_wo_customer_name');
		$this->session->unset_userdata('offline_wo_work_priority_id');
		$this->session->unset_userdata('offline_is_scheduled');
		
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		$data['priority']= $this->workorder_model->get_all_active_priority();
		$data['order_types'] = $this->workorder_model->get_order_types();
		$data['view']='orders/index';
		$this->load->view('layout',$data);
	}


}
