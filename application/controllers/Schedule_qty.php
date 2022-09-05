<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('order_model', 'order_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('calendar_model', 'calendar_model');
		$this->load->model('common_model', 'common_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	
	public function view($uuid){
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
			
		$data['title']=$accessArray['module_parent']." | Scheduled Order View";
		$data['title_head']=$accessArray['menu_name'];
		$data['row']=$this->schedule_model->get_scheduled_data_by_uuid($uuid);
		$data['view']='schedule/view';
		$this->load->view('layout',$data);
	}
	
	public function delete($uuid){
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
		//print_r($array1);
		$item_order_total_sec=0;
		if($array1){
			foreach($array1 as $key1 => $value1){
				$item_order_total_sec+=$value1['item_order_total_sec'];
			} 
		}
		$remaingSec=$sec_sum-$item_order_total_sec;
		$remainPer=$remaingSec/$unit_working_capacity_in_sec;
		$final_per=round( number_format( $remainPer * 100, 2 )); 
		$this->schedule_model->delete_scheduled_data($uuid);
		$this->schedule_model->delete_scheduled_department_data($shRow['schedule_id']);
		$this->schedule_model->delete_scheduled_item_qty_data($shRow['schedule_uuid']);
		$this->schedule_model->delete_rejected_order_data($shRow['schedule_id']);
		$this->schedule_model->delete_dispatch_order_data($shRow['order_id']);
		$this->schedule_model->delete_schedule_updates($shRow['schedule_id']);
		
		$u_data = array(
			'schedule_unit_percentage' =>$final_per,
			'schedule_unit_percentage_sec' =>$remaingSec,
		);
		$this->schedule_model->update_unit_calender_time($u_data,$production_end_date,$schedule_unit_id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('schedule/index');
	}
	
	public function scheduled_list(){
		$accessArray=$this->rbac->check_operation_access(); 
		$records = $this->schedule_model->get_all_scheduled_orders();
		$data = array();
		foreach ($records['data']  as $row) 
		{
			
			$wo_ref_numbers="";
			$c="";
			if($row['wo_ref_numbers']!=""){
				//$wo_ref_numbers="<br/>Ref: No: ".$row['wo_ref_numbers'];
				$wo_ref_numbersArray=explode(',',$row['wo_ref_numbers']);
				$oItems="";
				$c='<ul class="list-ticked">';
				foreach($wo_ref_numbersArray as $onum){
					$c.='<li>'.$onum.'</li>';
					$oItems.=','.$onum;
				}
				$c.='</ul>';
			}
			$order_info=$row['orderform_number'].$oItems;
			//if($row['schedule_order_info']==""){
			$upInfo="UPDATE sh_schedules SET schedule_order_info='$order_info' WHERE schedule_id='".$row['schedule_id']."' ";
			$query = $this->db->query($upInfo);
			//}
			
			$startDate=$this->schedule_model->final_dispatch_dates($row['schedule_id'],4);
			
			$dispatchDates= $this->schedule_model->final_dispatch_dates($row['schedule_id'],10);
			
			$option='<td style="text-align:center;">';
			if($accessArray){if(in_array("view",$accessArray)){
				$option.='<a href="'.base_url('schedule/view/'.$row['schedule_uuid']).'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			}}
			if($accessArray){if(in_array("delete",$accessArray)){
				$option.='&nbsp;<a title="Delete"  onclick="return  deleteRow();" href="'.base_url('schedule/delete/'.$row['schedule_uuid']).'" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';
			}}
			$option.='</td>'; 
			$dispatch_date='<label class="badge badge-outline-warning">'.date("d-m-Y", strtotime($row['wo_dispatch_date']))."[R]</label>"."<br/><label class='badge badge-outline-success mt-1'>".date("d-m-Y", strtotime($dispatchDates['dates']))."[S]</label>";
			if($row['wo_product_info']==""){
				$Summary="Nil";
			}else{
				$Summary=$row['wo_product_info'];
			}
			$currentStage=$this->schedule_model->get_current_stage($row['schedule_id']);
			$currentDept="";
			if($currentStage!=""){
				$department1=$this->schedule_model->get_production_department_names($currentStage['department_ids']);
				$currentDept='<label class="badge badge-outline-warning">In '.$department1['DNAME'].'</label>';
			}
			
			$data[]= array(
					$row['orderform_number'].$c,
					$Summary,
					date("d-m-Y", strtotime($startDate['dates'])),
					$dispatch_date,
					$currentDept,
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
		$data['view']='schedule/index';
		$this->load->view('layout',$data);
	}
	
	
	function change_date_post_fqc(){
		
		//print_r($_POST);exit;
		if($this->input->post('submit')){
			
			$this->form_validation->set_rules('schedule_department_id', 'Department', 'trim|required');
			$this->form_validation->set_rules('order_total_qty', 'Order total quantity', 'trim|required');
			$this->form_validation->set_rules('input_total_qty', 'Order balance quantity', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-warning"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
			}else{
				$schedule_department_id =$this->input->post('schedule_department_id');
				$schedule_id =$this->input->post('schedule_id');
				$order_id =$this->input->post('order_id');
				$UID =$this->input->post('UID');
				$department_id=$this->input->post('department_id');
				$is_re_scheduled=$this->input->post('is_re_scheduled');
				
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$now = date('d-m-Y H:i:s');
				$old=$this->schedule_model->get_old_schedule_date_info($schedule_department_id);
				$selected_date=date('Y-m-d', strtotime($this->input->post('selected_date')));
				$scheduled_date=date('Y-m-d', strtotime($this->input->post('scheduled_date')));
				
				if($old['department_schedule_date']==$selected_date){
					$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">';
					$msg.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
					$msg.='<h4><i class="icon fa fa-warning"></i> Alert!</h4>Please choose different new date...!!</div>';
					echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
				}else{
					
					$calender_date_info=$this->schedule_model->get_unit_calender_date_info($selected_date,$_POST['UID']);
					if($calender_date_info['unit_is_working']=='no'){
						$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">';
						$msg.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
						$msg.='<h4><i class="icon fa fa-warning"></i> Alert!</h4>Please choose valid working new date...!!</div>';
						echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
					}else{
						
						$order_total_qty =$this->input->post('order_total_qty');
						$input_total_qty =$this->input->post('input_total_qty');
						$anySchedule=$this->schedule_model->check_any_schedule_exist_in_deptmt($selected_date,$UID,$schedule_id,$order_id,$department_id);
						
						
						$old_schedule_row=$this->schedule_model->get_old_schedule_date_info($schedule_department_id);
						//print_r($old_schedule_row);exit;
						//--------------------------------- $anySchedule start------------------------------------------------
						if($anySchedule['schedule_department_id']==""){
							
							
							//echo 'In 1';exit;
							//------------------------------------------------ Case Null Start---------------
							if($_POST['changeDate']!=""){
									$inccc=0;
									$new_json="[";
									foreach($_POST['changeDate'] as $SH){
										if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
										$inccc++;
									}
									$new_json.="]";
							}
							//print_r($new_json);
							//echo '<br/>';
							if($_POST['orginalData']!=""){
									$inccc1=0;
									$old_json="[";
									$index=0;
									foreach($_POST['orginalData'] as $SH1){
										if($inccc1==0){ 
											$old_json.=json_encode($SH1); 
										}else{
											$old_json.=",".json_encode($SH1);
											}
										$inccc1++;
									}
									$old_json.="]";
							}
							
							if($input_total_qty<$order_total_qty){
								//old_schedule_row
									$exsit_schedule_info=$old_schedule_row['scheduled_order_info'];
									$db_array=json_decode($exsit_schedule_info,true); // from db
									$post_array=json_decode($new_json,true);
									$old_json=json_decode($old_json,true);
									
									foreach($post_array as $postkey=>$postvalue){
										if($post_array[$postkey]['summary_id']==$db_array[$postkey]['summary_id']){
											if($post_array[$postkey]['item_unit_qty_input']!=0){
	$old_json[$postkey]['item_unit_qty_input']=$db_array[$postkey]['item_unit_qty_input']-$post_array[$postkey]['item_unit_qty_input'];
	$old_json[$postkey]['item_order_capacity']=$db_array[$postkey]['item_order_capacity']-$post_array[$postkey]['item_unit_qty_input'];
	$old_json[$postkey]['item_order_qty']=$db_array[$postkey]['item_order_qty']-$post_array[$postkey]['item_unit_qty_input'];
	
												//echo $post_array[$postkey]['item_order_qty']."</br>";
	$post_array[$postkey]['item_unit_qty_input']=$post_array[$postkey]['item_unit_qty_input'];
	$post_array[$postkey]['item_order_capacity']=$post_array[$postkey]['item_unit_qty_input'];
	$post_array[$postkey]['item_order_qty']=$post_array[$postkey]['item_unit_qty_input'];
												
												
											}
											
										}
									}
									//print_r($post_array);
									//exit;	
									//print_r($old_json);
									//exit;
									$update_old_half= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' =>json_encode($old_json),
									);
									$this->schedule_model->change_schedule_date($update_old_half,$schedule_department_id);
									$new_batch_number= date('YmdHis');
									
									$insert_new_half= array(
										'schedule_id'=>$old_schedule_row['schedule_id'],
										'department_ids'=>$old_schedule_row['department_ids'],
										'department_schedule_date' =>$selected_date,
										'department_schedule_status' => 0,
										'scheduled_order_info' => json_encode($post_array),
										'unit_id'=>$old_schedule_row['unit_id'],
										'order_id'=>$old_schedule_row['order_id'],
										'batch_number'=>$new_batch_number,
										'is_re_scheduled'=>$is_re_scheduled
									); 
									$this->schedule_model->save_department_data($insert_new_half);
									$responseMsg='<div class="alert alert-success" style="width:100%;">';
									$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
									$responseMsg.='Date changed successfully...!</div>';
									echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								
							}
							if($order_total_qty==$input_total_qty){
								//echo 'haiiii'.$old_schedule_row['department_ids'];
								//removeItemString
								
								$updated_deptms=$this->common_model->removeItemString($old_schedule_row['department_ids'],13);
								$update_dept= array(
								'department_ids' =>$updated_deptms,
								);
								$this->schedule_model->change_schedule_date($update_dept,$old_schedule_row['schedule_department_id']);
								$new_batch_number= date('YmdHis');
								$insert_new_dept= array(
									'schedule_id'=>$old_schedule_row['schedule_id'],
									'department_ids'=>13,
									'department_schedule_date' =>$selected_date,
									'department_schedule_status' => 0,
									'scheduled_order_info' =>$new_json,
									'unit_id'=>$old_schedule_row['unit_id'],
									'order_id'=>$old_schedule_row['order_id'],
									'batch_number'=>$new_batch_number,
									'is_re_scheduled'=>$is_re_scheduled
								); 
								$this->schedule_model->save_department_data($insert_new_dept);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
								
							}
							//------------------------------------------------ Case Null End-----------------
						}else{
							if($order_total_qty==$input_total_qty){
								
								//print_r($anySchedule);exit;
								if($_POST['changeDate']!=""){
										$inccc=0;
										$new_json="[";
										foreach($_POST['changeDate'] as $SH){
											if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
											$inccc++;
										}
										$new_json.="]";
								}
								if($_POST['orginalData']!=""){
										$inccc1=0;
										$old_json="[";
										$index=0;
										foreach($_POST['orginalData'] as $SH1){
											if($inccc1==0){ 
												$old_json.=json_encode($SH1); 
											}else{
												$old_json.=",".json_encode($SH1);
												}
											$inccc1++;
										}
										$old_json.="]";
								}
								//echo 'In 2';
								$exsit_schedule_info=$anySchedule['scheduled_order_info'];
								$db_array=json_decode($exsit_schedule_info,true); // from db
								//print_r($db_array);
								$post_array=json_decode($new_json,true);
								foreach($db_array as $dbkey=>$dbvalue){
									if($db_array[$dbkey]['summary_id']==$post_array[$dbkey]['summary_id']){
										if($post_array[$dbkey]['item_unit_qty_input']!=0){
											//echo $post_array[$dbkey]['summary_id'];
											$new_input_qty=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_capacity=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_order_capacity'];
											$new_item_order_qty=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_order_qty'];
											$db_array[$dbkey]['item_unit_qty_input']=$new_input_qty;
											$db_array[$dbkey]['item_order_capacity']=$new_item_order_capacity;
											$db_array[$dbkey]['item_order_qty']=$new_item_order_qty;
										}
									}
								}
								$update_all= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($db_array),
								);
								//print_r($db_array);
								//echo $old_schedule_row['department_ids'];
								//exit;
								$this->schedule_model->change_schedule_date($update_all,$anySchedule['schedule_department_id']);
								$this->schedule_model->drop_scheduled_department_by_id($schedule_department_id);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
							}
							if($input_total_qty<$order_total_qty){
								if($_POST['changeDate']!=""){
									$inccc=0;
									$new_json="[";
									foreach($_POST['changeDate'] as $SH){
										if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
										$inccc++;
									}
									$new_json.="]";
								}
								
								$exsit_schedule_info=$anySchedule['scheduled_order_info'];
								$db_array=json_decode($exsit_schedule_info,true); // from db
								$post_array=json_decode($new_json,true);
								$old_json_array=$old_schedule_row['scheduled_order_info']; // old db
								$old_json=json_decode($old_json_array,true);
								foreach($db_array as $dbkey=>$dbvalue){
									if($db_array[$dbkey]['summary_id']==$post_array[$dbkey]['summary_id']){
										
										if($post_array[$dbkey]['item_unit_qty_input']!=0){
											$post_array[$dbkey]['summary_id'];
											$new_item_unit_qty_input=$db_array[$dbkey]['item_unit_qty_input']+$post_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_capacity=$db_array[$dbkey]['item_order_capacity']+$post_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_qty=$db_array[$dbkey]['item_order_qty']+$post_array[$dbkey]['item_unit_qty_input'];
											
											$old_item_unit_qty_input=$old_json[$dbkey]['item_unit_qty_input']-$post_array[$dbkey]['item_unit_qty_input'];
											$old_item_order_capacity=$old_json[$dbkey]['item_order_capacity']-$post_array[$dbkey]['item_unit_qty_input'];
											$old_item_order_qty=$old_json[$dbkey]['item_order_qty']-$post_array[$dbkey]['item_unit_qty_input'];
											
											$db_array[$dbkey]['item_unit_qty_input']=$new_item_unit_qty_input;
											$db_array[$dbkey]['item_order_capacity']=$new_item_order_capacity;
											$db_array[$dbkey]['item_order_qty']=$new_item_order_qty;
											//echo $old_json[$dbkey]['item_unit_qty_input'];
											
											$old_json[$dbkey]['item_unit_qty_input']=$old_item_unit_qty_input;
											$old_json[$dbkey]['item_order_capacity']=$old_item_order_capacity;
											$old_json[$dbkey]['item_order_qty']=$old_item_order_qty;
										}
									}
								}
								//print_r($old_json);exit;
								$new_schedule_department_id=$anySchedule['schedule_department_id'];
								$update_new= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($db_array),
								);
								$this->schedule_model->change_schedule_date($update_new,$new_schedule_department_id);
								
								$old_schedule_department_id=$old_schedule_row['schedule_department_id'];
								$update_old= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($old_json),
								);
								$this->schedule_model->change_schedule_date($update_old,$old_schedule_department_id);
								//print_r($old_schedule_row);
								//print_r($old_json);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
							}
							exit;
							
						}
						//------------------------------------ $anySchedule End---------------------------------------------
					
					}
				}
			}
					
		}
		
	}
	//-------------------------------------
	function change_date_post_dispatch(){
		
		//print_r($_POST);exit;
		if($this->input->post('submit')){
			
			$this->form_validation->set_rules('schedule_department_id', 'Department', 'trim|required');
			$this->form_validation->set_rules('order_total_qty', 'Order total quantity', 'trim|required');
			$this->form_validation->set_rules('input_total_qty', 'Order balance quantity', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-warning"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
			}else{
				$schedule_department_id =$this->input->post('schedule_department_id');
				$schedule_id =$this->input->post('schedule_id');
				$order_id =$this->input->post('order_id');
				$UID =$this->input->post('UID');
				$department_id=$this->input->post('department_id');
				$is_re_scheduled=$this->input->post('is_re_scheduled');
				
				
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$now = date('d-m-Y H:i:s');
				$old=$this->schedule_model->get_old_schedule_date_info($schedule_department_id);
				$selected_date=date('Y-m-d', strtotime($this->input->post('selected_date')));
				$scheduled_date=date('Y-m-d', strtotime($this->input->post('scheduled_date')));
				
				
				
				
				if($old['department_schedule_date']==$selected_date){
					$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">';
					$msg.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
					$msg.='<h4><i class="icon fa fa-warning"></i> Alert!</h4>Please choose different new date...!!</div>';
					echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
				}else{
					
					$calender_date_info=$this->schedule_model->get_unit_calender_date_info($selected_date,$_POST['UID']);
					if($calender_date_info['unit_is_working']=='no'){
						$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">';
						$msg.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
						$msg.='<h4><i class="icon fa fa-warning"></i> Alert!</h4>Please choose valid working new date...!!</div>';
						echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
					}else{
						
						$order_total_qty =$this->input->post('order_total_qty');
						$input_total_qty =$this->input->post('input_total_qty');
						$anySchedule=$this->schedule_model->check_any_schedule_exist_in_deptmt($selected_date,$UID,$schedule_id,$order_id,$department_id);
						$old_schedule_row=$this->schedule_model->get_old_schedule_date_info($schedule_department_id);
						//print_r($old_schedule_row);exit;
						//--------------------------------- $anySchedule start------------------------------------------------
						if($anySchedule['schedule_department_id']==""){
							//echo 'In 1';exit;
							//------------------------------------------------ Case Null Start---------------
							if($_POST['changeDate']!=""){
									$inccc=0;
									$new_json="[";
									foreach($_POST['changeDate'] as $SH){
										if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
										$inccc++;
									}
									$new_json.="]";
							}
							//print_r($new_json);
							//echo '<br/>';
							if($_POST['orginalData']!=""){
									$inccc1=0;
									$old_json="[";
									$index=0;
									foreach($_POST['orginalData'] as $SH1){
										if($inccc1==0){ 
											$old_json.=json_encode($SH1); 
										}else{
											$old_json.=",".json_encode($SH1);
											}
										$inccc1++;
									}
									$old_json.="]";
							}
							
							if($input_total_qty<$order_total_qty){
								//old_schedule_row
									$exsit_schedule_info=$old_schedule_row['scheduled_order_info'];
									$db_array=json_decode($exsit_schedule_info,true); // from db
									$post_array=json_decode($new_json,true);
									$old_json=json_decode($old_json,true);
									
									foreach($post_array as $postkey=>$postvalue){
										if($post_array[$postkey]['summary_id']==$db_array[$postkey]['summary_id']){
											if($post_array[$postkey]['item_unit_qty_input']!=0){
	$old_json[$postkey]['item_unit_qty_input']=$db_array[$postkey]['item_unit_qty_input']-$post_array[$postkey]['item_unit_qty_input'];
	$old_json[$postkey]['item_order_capacity']=$db_array[$postkey]['item_order_capacity']-$post_array[$postkey]['item_unit_qty_input'];
	$old_json[$postkey]['item_order_qty']=$db_array[$postkey]['item_order_qty']-$post_array[$postkey]['item_unit_qty_input'];
	
												//echo $post_array[$postkey]['item_order_qty']."</br>";
	$post_array[$postkey]['item_unit_qty_input']=$post_array[$postkey]['item_unit_qty_input'];
	$post_array[$postkey]['item_order_capacity']=$post_array[$postkey]['item_unit_qty_input'];
	$post_array[$postkey]['item_order_qty']=$post_array[$postkey]['item_unit_qty_input'];
												
												
											}
											
										}
									}
									//print_r($post_array);
									//exit;	
									//print_r($old_json);
									//exit;
									$update_old_half= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' =>json_encode($old_json),
									);
									$this->schedule_model->change_schedule_date($update_old_half,$schedule_department_id);
									$new_batch_number= date('YmdHis');
									
									$insert_new_half= array(
										'schedule_id'=>$old_schedule_row['schedule_id'],
										'department_ids'=>$old_schedule_row['department_ids'],
										'department_schedule_date' =>$selected_date,
										'department_schedule_status' => 0,
										'scheduled_order_info' => json_encode($post_array),
										'unit_id'=>$old_schedule_row['unit_id'],
										'order_id'=>$old_schedule_row['order_id'],
										'batch_number'=>$new_batch_number,
										'is_re_scheduled'=>$is_re_scheduled
									); 
									$this->schedule_model->save_department_data($insert_new_half);
									$responseMsg='<div class="alert alert-success" style="width:100%;">';
									$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
									$responseMsg.='Date changed successfully...!</div>';
									echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								
							}
							if($order_total_qty==$input_total_qty){
								//echo 'haiiii'.$old_schedule_row['department_ids'];
								//removeItemString
								
								$updated_deptms=$this->common_model->removeItemString($old_schedule_row['department_ids'],10);
								$update_dept= array(
								'department_ids' =>$updated_deptms,
								);
								$this->schedule_model->change_schedule_date($update_dept,$old_schedule_row['schedule_department_id']);
								$new_batch_number= date('YmdHis');
								$insert_new_dept= array(
									'schedule_id'=>$old_schedule_row['schedule_id'],
									'department_ids'=>10,
									'department_schedule_date' =>$selected_date,
									'department_schedule_status' => 0,
									'scheduled_order_info' =>$new_json,
									'unit_id'=>$old_schedule_row['unit_id'],
									'order_id'=>$old_schedule_row['order_id'],
									'batch_number'=>$new_batch_number,
									'is_re_scheduled'=>$is_re_scheduled
								); 
								$this->schedule_model->save_department_data($insert_new_dept);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
								
							}
							//------------------------------------------------ Case Null End-----------------
						}else{
							if($order_total_qty==$input_total_qty){
								
								//print_r($anySchedule);exit;
								if($_POST['changeDate']!=""){
										$inccc=0;
										$new_json="[";
										foreach($_POST['changeDate'] as $SH){
											if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
											$inccc++;
										}
										$new_json.="]";
								}
								if($_POST['orginalData']!=""){
										$inccc1=0;
										$old_json="[";
										$index=0;
										foreach($_POST['orginalData'] as $SH1){
											if($inccc1==0){ 
												$old_json.=json_encode($SH1); 
											}else{
												$old_json.=",".json_encode($SH1);
												}
											$inccc1++;
										}
										$old_json.="]";
								}
								//echo 'In 2';
								$exsit_schedule_info=$anySchedule['scheduled_order_info'];
								$db_array=json_decode($exsit_schedule_info,true); // from db
								//print_r($db_array);
								$post_array=json_decode($new_json,true);
								foreach($db_array as $dbkey=>$dbvalue){
									if($db_array[$dbkey]['summary_id']==$post_array[$dbkey]['summary_id']){
										if($post_array[$dbkey]['item_unit_qty_input']!=0){
											//echo $post_array[$dbkey]['summary_id'];
											$new_input_qty=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_capacity=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_order_capacity'];
											$new_item_order_qty=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_order_qty'];
											$db_array[$dbkey]['item_unit_qty_input']=$new_input_qty;
											$db_array[$dbkey]['item_order_capacity']=$new_item_order_capacity;
											$db_array[$dbkey]['item_order_qty']=$new_item_order_qty;
										}
									}
								}
								$update_all= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($db_array),
								);
								//print_r($db_array);
								//echo $old_schedule_row['department_ids'];
								//exit;
								$this->schedule_model->change_schedule_date($update_all,$anySchedule['schedule_department_id']);
								$this->schedule_model->drop_scheduled_department_by_id($schedule_department_id);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
							}
							if($input_total_qty<$order_total_qty){
								if($_POST['changeDate']!=""){
									$inccc=0;
									$new_json="[";
									foreach($_POST['changeDate'] as $SH){
										if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
										$inccc++;
									}
									$new_json.="]";
								}
								
								$exsit_schedule_info=$anySchedule['scheduled_order_info'];
								$db_array=json_decode($exsit_schedule_info,true); // from db
								$post_array=json_decode($new_json,true);
								$old_json_array=$old_schedule_row['scheduled_order_info']; // old db
								$old_json=json_decode($old_json_array,true);
								foreach($db_array as $dbkey=>$dbvalue){
									if($db_array[$dbkey]['summary_id']==$post_array[$dbkey]['summary_id']){
										
										if($post_array[$dbkey]['item_unit_qty_input']!=0){
											$post_array[$dbkey]['summary_id'];
											$new_item_unit_qty_input=$db_array[$dbkey]['item_unit_qty_input']+$post_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_capacity=$db_array[$dbkey]['item_order_capacity']+$post_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_qty=$db_array[$dbkey]['item_order_qty']+$post_array[$dbkey]['item_unit_qty_input'];
											
											$old_item_unit_qty_input=$old_json[$dbkey]['item_unit_qty_input']-$post_array[$dbkey]['item_unit_qty_input'];
											$old_item_order_capacity=$old_json[$dbkey]['item_order_capacity']-$post_array[$dbkey]['item_unit_qty_input'];
											$old_item_order_qty=$old_json[$dbkey]['item_order_qty']-$post_array[$dbkey]['item_unit_qty_input'];
											
											$db_array[$dbkey]['item_unit_qty_input']=$new_item_unit_qty_input;
											$db_array[$dbkey]['item_order_capacity']=$new_item_order_capacity;
											$db_array[$dbkey]['item_order_qty']=$new_item_order_qty;
											//echo $old_json[$dbkey]['item_unit_qty_input'];
											
											$old_json[$dbkey]['item_unit_qty_input']=$old_item_unit_qty_input;
											$old_json[$dbkey]['item_order_capacity']=$old_item_order_capacity;
											$old_json[$dbkey]['item_order_qty']=$old_item_order_qty;
										}
									}
								}
								//print_r($old_json);exit;
								$new_schedule_department_id=$anySchedule['schedule_department_id'];
								$update_new= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($db_array),
								);
								$this->schedule_model->change_schedule_date($update_new,$new_schedule_department_id);
								
								$old_schedule_department_id=$old_schedule_row['schedule_department_id'];
								$update_old= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($old_json),
								);
								$this->schedule_model->change_schedule_date($update_old,$old_schedule_department_id);
								//print_r($old_schedule_row);
								//print_r($old_json);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
							}
							exit;
							
						}
						//------------------------------------ $anySchedule End---------------------------------------------
					
					}
				}
			}
					
		}
		
	}
	
	function change_date_post(){
		
		//print_r($_POST);exit;
		if($this->input->post('submit')){
			
			$this->form_validation->set_rules('schedule_department_id', 'Department', 'trim|required');
			$this->form_validation->set_rules('order_total_qty', 'Order total quantity', 'trim|required');
			$this->form_validation->set_rules('input_total_qty', 'Order balance quantity', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-warning"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
			}else{
				$schedule_department_id =$this->input->post('schedule_department_id');
				$schedule_id =$this->input->post('schedule_id');
				$order_id =$this->input->post('order_id');
				$UID =$this->input->post('UID');
				$department_id=$this->input->post('department_id');
				//$is_from_dispatch =$this->input->post('is_from_dispatch');
				$is_re_scheduled =$this->input->post('is_re_scheduled');
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$now = date('d-m-Y H:i:s');
				$old=$this->schedule_model->get_old_schedule_date_info($schedule_department_id);
				$selected_date=date('Y-m-d', strtotime($this->input->post('selected_date')));
				$scheduled_date=date('Y-m-d', strtotime($this->input->post('scheduled_date')));
								
				if($old['department_schedule_date']==$selected_date){
					$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">';
					$msg.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
					$msg.='<h4><i class="icon fa fa-warning"></i> Alert!</h4>Please choose different new date...!!</div>';
					echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
				}else{
					
					$calender_date_info=$this->schedule_model->get_unit_calender_date_info($selected_date,$_POST['UID']);
					if($calender_date_info['unit_is_working']=='no'){
						$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">';
						$msg.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
						$msg.='<h4><i class="icon fa fa-warning"></i> Alert!</h4>Please choose valid working new date...!!</div>';
						echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
					}else{
						
						$order_total_qty =$this->input->post('order_total_qty');
						$input_total_qty =$this->input->post('input_total_qty');
						$anySchedule=$this->schedule_model->check_any_schedule_exist_in_deptmt($selected_date,$UID,$schedule_id,$order_id,$department_id);
						$old_schedule_row=$this->schedule_model->get_old_schedule_date_info($schedule_department_id);
						
						//print_r($old_schedule_row);exit;
						//--------------------------------- $anySchedule start------------------------------------------------
						if($anySchedule['schedule_department_id']==""){
							//echo 'In 1';exit;
							//------------------------------------------------ Case Null Start---------------
							if($_POST['changeDate']!=""){
									$inccc=0;
									$new_json="[";
									foreach($_POST['changeDate'] as $SH){
										if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
										$inccc++;
									}
									$new_json.="]";
							}
							//print_r($new_json);
							//echo '<br/>';
							if($_POST['orginalData']!=""){
									$inccc1=0;
									$old_json="[";
									$index=0;
									foreach($_POST['orginalData'] as $SH1){
										if($inccc1==0){ 
											$old_json.=json_encode($SH1); 
										}else{
											$old_json.=",".json_encode($SH1);
											}
										$inccc1++;
									}
									$old_json.="]";
							}
							//print_r($old_json);
							//exit;	
							if($input_total_qty < $order_total_qty){
								//echo 'less than';exit;
								//old_schedule_row
									$exsit_schedule_info=$old_schedule_row['scheduled_order_info'];
									$db_array=json_decode($exsit_schedule_info,true); // from db
									$post_array=json_decode($new_json,true);
									$old_json=json_decode($old_json,true);
									$schedule_item_qty_ids=0;
									foreach($post_array as $postkey=>$postvalue){
										//echo $schedule_department_id."<br/>";
										if($post_array[$postkey]['summary_id']==$db_array[$postkey]['summary_id']){
											if($post_array[$postkey]['item_unit_qty_input']!=0){
												//$old_json[$postkey]['item_unit_qty_input']=$post_array[$postkey]['item_order_qty'];
												//echo $post_array[$postkey]['item_order_qty']."</br>";
												//$post_array[$postkey]['item_unit_qty_input']=0;
												//$post_array[$postkey]['item_order_capacity']=0;
												//$post_array[$postkey]['item_order_qty']=0;
										$qty_row=$this->schedule_model->get_old_schedule_qty_info($schedule_department_id,$schedule_id,$order_id,$post_array[$postkey]['summary_id']);															//print_r($qty_row);
										$schedule_item_qty_id=$qty_row['schedule_item_qty_id'];
										$sh_qty=$qty_row['sh_qty'];
										$balance_qty=$qty_row['sh_qty']-$post_array[$postkey]['item_unit_qty_input'];
										$new_qty=$post_array[$postkey]['item_unit_qty_input'];
										$old_item_json=json_decode($qty_row['item_json'],true);
										$old_item_json['item_unit_qty_input']=$balance_qty;
										$old_item_json=json_encode($old_item_json);

										$new_item_json=json_decode($qty_row['item_json'],true);
										$new_item_json['item_unit_qty_input']=$new_qty;
										$new_item_json=json_encode($new_item_json);
										$insert_new_qty_row= array(
											'scheduled_id'=>$qty_row['scheduled_id'],
											'schedule_uuid'=>$qty_row['schedule_uuid'],
											'orderid'=>$qty_row['orderid'],
											'order_summery_id'=>$qty_row['order_summery_id'],
											'item_position'=>$qty_row['item_position'],
											'order_total_qty'=>$qty_row['order_total_qty'],
											'sh_qty'=>$new_qty,
											'item_json'=>$new_item_json,
											'schedule_department_ids'=>$schedule_department_id,
										);
										if($balance_qty==0){
											$this->schedule_model->remove_qty_row($qty_row['schedule_item_qty_id']);
										}else{
											$update_old_qty_row= array(
												'sh_qty'=>$balance_qty,
												'item_json'=>$old_item_json,
											);
											$this->schedule_model->update_schedule_old_qty_row($update_old_qty_row,$schedule_item_qty_id);
										}
										//print_r($update_old_qty_row);
										//echo json_encode($new_item_json);
										$schedule_item_qty_id_new=$this->schedule_model->insert_schedule_new_qty_row($insert_new_qty_row);
										$schedule_item_qty_ids.=",".$schedule_item_qty_id_new;
										
		
$old_json[$postkey]['item_unit_qty_input']=$db_array[$postkey]['item_unit_qty_input']-$post_array[$postkey]['item_unit_qty_input'];
$old_json[$postkey]['item_order_capacity']=$db_array[$postkey]['item_order_capacity']-$post_array[$postkey]['item_unit_qty_input'];
$old_json[$postkey]['item_order_qty']=$db_array[$postkey]['item_order_qty']-$post_array[$postkey]['item_unit_qty_input'];
	
	//echo $post_array[$postkey]['item_order_qty']."</br>";
$post_array[$postkey]['item_unit_qty_input']=$post_array[$postkey]['item_unit_qty_input'];
$post_array[$postkey]['item_order_capacity']=$post_array[$postkey]['item_unit_qty_input'];
$post_array[$postkey]['item_order_qty']=$post_array[$postkey]['item_unit_qty_input'];
												
											}else{
												$post_array[$postkey]['item_unit_qty_input']=0;
												$post_array[$postkey]['item_order_capacity']=0;
												$post_array[$postkey]['item_order_qty']=0;
												
												$old_json[$postkey]['item_unit_qty_input']=$db_array[$postkey]['item_unit_qty_input'];
												$old_json[$postkey]['item_order_capacity']=$db_array[$postkey]['item_order_capacity'];
												$old_json[$postkey]['item_order_qty']=$db_array[$postkey]['item_order_qty'];
											}
											
										}
									}
									//print_r($post_array);
									//exit;
									//echo "Not Equal";exit;
									$update_old_half= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' =>json_encode($old_json),
									);
									$this->schedule_model->change_schedule_date($update_old_half,$schedule_department_id);
									$new_batch_number= date('YmdHis');
									$insert_new_half= array(
										'schedule_id'=>$old_schedule_row['schedule_id'],
										'department_ids'=>$old_schedule_row['department_ids'],
										'department_schedule_date' =>$selected_date,
										'department_schedule_status' => 0,
										'scheduled_order_info' => json_encode($post_array),
										'unit_id'=>$old_schedule_row['unit_id'],
										'order_id'=>$old_schedule_row['order_id'],
										'batch_number'=>$new_batch_number,
										'is_re_scheduled'=>$is_re_scheduled
									); 
									$schedule_department_id_latest=$this->schedule_model->save_department_data($insert_new_half);
									if($schedule_item_qty_ids){
										$schedule_item_qty_ids_array=explode(',',$schedule_item_qty_ids);
										foreach($schedule_item_qty_ids_array as $itemIDS){
										$updateQty=array('schedule_department_ids'=>$schedule_department_id_latest);
										$this->schedule_model->update_schedule_old_qty_row($updateQty,$itemIDS);
										}
									}
									$responseMsg='<div class="alert alert-success" style="width:100%;">';
									$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
									$responseMsg.='Date changed successfully...!</div>';
									echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								
							}
							if($order_total_qty==$input_total_qty){
//echo 'Eql';exit;
								$exsit_schedule_info=$old_schedule_row['scheduled_order_info']; 
								$post_array=json_decode($new_json,true);
								$db_array=json_decode($exsit_schedule_info,true); // from db
								//print_r($db_array);
								
								foreach($post_array as $postkey=>$postvalue){
								if($post_array[$postkey]['summary_id']==$db_array[$postkey]['summary_id']){
								if($post_array[$postkey]['item_unit_qty_input']!=0){
								
								$qty_row=$this->schedule_model->get_old_schedule_qty_info($schedule_department_id,$schedule_id,$order_id,$post_array[$postkey]['summary_id']);	
								$input = $schedule_department_id;
								$list =$qty_row['schedule_department_ids'];
								$array1 = Array($input);
								$array2 = explode(',', $list);
								$array3 = array_diff($array2, $array1);
								$updated_old_deptment= implode(',', $array3);
								$insert_new_qty_row= array(
									'scheduled_id'=>$qty_row['scheduled_id'],
									'schedule_uuid'=>$qty_row['schedule_uuid'],
									'orderid'=>$qty_row['orderid'],
									'order_summery_id'=>$qty_row['order_summery_id'],
									'item_position'=>$qty_row['item_position'],
									'order_total_qty'=>$qty_row['order_total_qty'],
									'sh_qty'=>$qty_row['sh_qty'],
									'item_json'=>$qty_row['item_json'],
									'schedule_department_ids'=>$schedule_department_id,
								);
								//echo($updated_old_deptment);
								//echo $qty_row['schedule_item_qty_id'];
								if($updated_old_deptment==""){
									$this->schedule_model->remove_qty_row($qty_row['schedule_item_qty_id']);
								}else{
									$update_old_qty_row= array(
									'schedule_department_ids'=>$updated_old_deptment,
									);
									$this->schedule_model->update_schedule_old_qty_row($update_old_qty_row,$qty_row['schedule_item_qty_id']);
								}
								$this->schedule_model->insert_schedule_new_qty_row($insert_new_qty_row);
								}}
								}
								//echo "Equal";exit; 
								$update_all= array(
								'department_schedule_date' =>$selected_date,
								'department_schedule_status' => 0,
								'scheduled_order_info' => $new_json,
								);
								$this->schedule_model->change_schedule_date($update_all,$schedule_department_id);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
							}
							//------------------------------------------------ Case Null End-----------------
						}else{
							
							if($order_total_qty==$input_total_qty){
								if($_POST['changeDate']!=""){
										$inccc=0;
										$new_json="[";
										foreach($_POST['changeDate'] as $SH){
											if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
											$inccc++;
										}
										$new_json.="]";
								}
								if($_POST['orginalData']!=""){
										$inccc1=0;
										$old_json="[";
										$index=0;
										foreach($_POST['orginalData'] as $SH1){
											if($inccc1==0){ 
												$old_json.=json_encode($SH1); 
											}else{
												$old_json.=",".json_encode($SH1);
												}
											$inccc1++;
										}
										$old_json.="]";
								}
								//echo '=In 2 equal';	exit;
								$exsit_schedule_info=$anySchedule['scheduled_order_info'];
								$db_array=json_decode($exsit_schedule_info,true); // from db
								$post_array=json_decode($new_json,true);
								foreach($db_array as $dbkey=>$dbvalue){
									if($db_array[$dbkey]['summary_id']==$post_array[$dbkey]['summary_id']){
										if($post_array[$dbkey]['item_unit_qty_input']!=0){
											//echo $post_array[$dbkey]['summary_id'];

//echo $post_array[$dbkey]['summary_id']."<br/>";
											//=================================Start Of Qty==============================================//
											$qty_row=$this->schedule_model->get_old_schedule_qty_info($schedule_department_id,$schedule_id,$order_id,$post_array[$dbkey]['summary_id']);
//print_r($qty_row);
																	
											$sh_qty=$qty_row['sh_qty'];
											$input = $schedule_department_id;
											$list =$qty_row['schedule_department_ids'];
											$array1 = Array($input);
											$array2 = explode(',', $list);
											$array3 = array_diff($array2, $array1);
											$updated_old_deptment= implode(',', $array3);
											$insert_new_qty_row= array(
												'scheduled_id'=>$qty_row['scheduled_id'],
												'schedule_uuid'=>$qty_row['schedule_uuid'],
												'orderid'=>$qty_row['orderid'],
												'order_summery_id'=>$qty_row['order_summery_id'],
												'item_position'=>$qty_row['item_position'],
												'order_total_qty'=>$qty_row['order_total_qty'],
												'sh_qty'=>$qty_row['sh_qty'],
												'item_json'=>$qty_row['item_json'],
												'schedule_department_ids'=>$anySchedule['schedule_department_id'],
											);
											//print_r($insert_new_qty_row);
											if($updated_old_deptment==""){
												$this->schedule_model->remove_qty_row($qty_row['schedule_item_qty_id']);
											}else{
												$update_old_qty_row= array('schedule_department_ids'=>$updated_old_deptment);
												//print_r($update_old_qty_row);
												$this->schedule_model->update_schedule_old_qty_row($update_old_qty_row,$qty_row['schedule_item_qty_id']);
											}
											$this->schedule_model->insert_schedule_new_qty_row($insert_new_qty_row);
											//=================================End Of Qty==============================================//

											$new_input_qty=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_capacity=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_order_capacity'];
											$new_item_order_qty=$post_array[$dbkey]['item_unit_qty_input']+$db_array[$dbkey]['item_order_qty'];
											$db_array[$dbkey]['item_unit_qty_input']=$new_input_qty;
											$db_array[$dbkey]['item_order_capacity']=$new_item_order_capacity;
											$db_array[$dbkey]['item_order_qty']=$new_item_order_qty;
										}
									}
								}
								$update_all= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($db_array),
								);
								//print_r($db_array);
								//exit;
								$this->schedule_model->change_schedule_date($update_all,$anySchedule['schedule_department_id']);
								$this->schedule_model->drop_scheduled_department_by_id($schedule_department_id);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
							}
							if($input_total_qty < $order_total_qty){
//echo 'ok2';exit;
								if($_POST['changeDate']!=""){
									$inccc=0;
									$new_json="[";
									foreach($_POST['changeDate'] as $SH){
										if($inccc==0){ $new_json.=json_encode($SH);}else{ $new_json.=",".json_encode($SH);}
										$inccc++;
									}
									$new_json.="]";
								}
								
								$exsit_schedule_info=$anySchedule['scheduled_order_info'];
								$db_array=json_decode($exsit_schedule_info,true); // from db
								$post_array=json_decode($new_json,true);
								$old_json_array=$old_schedule_row['scheduled_order_info']; // old db
								$old_json=json_decode($old_json_array,true);
								foreach($db_array as $dbkey=>$dbvalue){
									if($db_array[$dbkey]['summary_id']==$post_array[$dbkey]['summary_id']){
										
										if($post_array[$dbkey]['item_unit_qty_input']!=0){
											//echo $schedule_department_id."++".$anySchedule['schedule_department_id'];
											//=========================================================================================================
												$qty_row=$this->schedule_model->get_old_schedule_qty_info($schedule_department_id,$schedule_id,$order_id,$post_array[$dbkey]['summary_id']);															//print_r($qty_row);

												$schedule_item_qty_id=$qty_row['schedule_item_qty_id'];
												$sh_qty=$qty_row['sh_qty'];
												$balance_qty=$qty_row['sh_qty']-$post_array[$dbkey]['item_unit_qty_input'];
												$new_qty=$post_array[$dbkey]['item_unit_qty_input'];
												$old_item_json=json_decode($qty_row['item_json'],true);
												$old_item_json['item_unit_qty_input']=$balance_qty;
												$old_item_json=json_encode($old_item_json);

												$new_item_json=json_decode($qty_row['item_json'],true);
												$new_item_json['item_unit_qty_input']=$new_qty;
												$new_item_json=json_encode($new_item_json);
												$insert_new_qty_row= array(
													'scheduled_id'=>$qty_row['scheduled_id'],
													'schedule_uuid'=>$qty_row['schedule_uuid'],
													'orderid'=>$qty_row['orderid'],
													'order_summery_id'=>$post_array[$dbkey]['summary_id'],
													'item_position'=>$qty_row['item_position'],
													'order_total_qty'=>$qty_row['order_total_qty'],
													'sh_qty'=>$new_qty,
													'item_json'=>$new_item_json,
													'schedule_department_ids'=>$anySchedule['schedule_department_id'],
												);
												if($balance_qty==0){
													$input = $schedule_department_id;
													$list =$qty_row['schedule_department_ids'];
													$array1 = Array($input);
													$array2 = explode(',', $list);
													$array3 = array_diff($array2, $array1);
													$updated_old_deptment= implode(',', $array3);
													$update_old_qty_row= array(
														'sh_qty'=>$balance_qty,
														'item_json'=>$old_item_json,
														'schedule_department_ids'=>$updated_old_deptment
													);

												}else{
													$update_old_qty_row= array(
														'sh_qty'=>$balance_qty,
														'item_json'=>$old_item_json,
													);
												}
												//print_r($insert_new_qty_row);
												//print_r($update_old_qty_row);
												//echo json_encode($new_item_json);

												$this->schedule_model->insert_schedule_new_qty_row($insert_new_qty_row);
												$this->schedule_model->update_schedule_old_qty_row($update_old_qty_row,$schedule_item_qty_id);
											//=========================================================================================================

											$new_item_unit_qty_input=$db_array[$dbkey]['item_unit_qty_input']+$post_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_capacity=$db_array[$dbkey]['item_order_capacity']+$post_array[$dbkey]['item_unit_qty_input'];
											$new_item_order_qty=$db_array[$dbkey]['item_order_qty']+$post_array[$dbkey]['item_unit_qty_input'];
											
											$old_item_unit_qty_input=$old_json[$dbkey]['item_unit_qty_input']-$post_array[$dbkey]['item_unit_qty_input'];
											$old_item_order_capacity=$old_json[$dbkey]['item_order_capacity']-$post_array[$dbkey]['item_unit_qty_input'];
											$old_item_order_qty=$old_json[$dbkey]['item_order_qty']-$post_array[$dbkey]['item_unit_qty_input'];
											
											$db_array[$dbkey]['item_unit_qty_input']=$new_item_unit_qty_input;
											$db_array[$dbkey]['item_order_capacity']=$new_item_order_capacity;
											$db_array[$dbkey]['item_order_qty']=$new_item_order_qty;
											//echo $old_json[$dbkey]['item_unit_qty_input'];
											
											$old_json[$dbkey]['item_unit_qty_input']=$old_item_unit_qty_input;
											$old_json[$dbkey]['item_order_capacity']=$old_item_order_capacity;
											$old_json[$dbkey]['item_order_qty']=$old_item_order_qty;

											
										}
									}
								}
								//print_r($old_json);
								//exit;
								$new_schedule_department_id=$anySchedule['schedule_department_id'];
								$update_new= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($db_array),
								);
								$this->schedule_model->change_schedule_date($update_new,$new_schedule_department_id);
								
								$old_schedule_department_id=$old_schedule_row['schedule_department_id'];
								$update_old= array(
									'department_schedule_status' => 0,
									'scheduled_order_info' => json_encode($old_json),
								);
								$this->schedule_model->change_schedule_date($update_old,$old_schedule_department_id);
								//print_r($old_schedule_row);
								//print_r($old_json);
								$responseMsg='<div class="alert alert-success" style="width:100%;">';
								$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';
								$responseMsg.='Date changed successfully...!</div>';
								echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
								exit;
							}
							exit;
							
						}
						//------------------------------------ $anySchedule End---------------------------------------------
					
					}
				}
			}
					
		}
		
	}
	
	//---------------------------------------------------------------------------------------------------
	
	
	
	function day_overview_stiching(){
		$data['calender_date_info']=$this->schedule_model->get_unit_calender_date_info($_POST['choosed_date'],$_POST['uid']);
		$data['day_overview']=$this->schedule_model->get_orders_under_date_and_depmt($_POST['choosed_date'],$_POST['did'],$_POST['uid']);
		$this->load->view('schedule/day_overview_stiching',$data);
	}
	
	function day_overview(){
		$data['calender_date_info']=$this->schedule_model->get_unit_calender_date_info($_POST['choosed_date'],$_POST['uid']);
		$data['day_overview']=$this->schedule_model->get_orders_under_date_and_depmt($_POST['choosed_date'],$_POST['did'],$_POST['uid']);
		$this->load->view('schedule/day_overview',$data);
		
	}
	
	
	//---------------------------------------------------------------------------------------------------
	
	function change_date(){
		
		$sdepartment= $this->schedule_model->get_shedule_department_row_by_id($_POST['sdid']);
		$data['sdepartment']=$sdepartment;
		//$data['order_row']= $this->schedule_model->get_order_data_by_id_for_schedule($sdepartment['schedule_department_id'],$_POST['did']);
		//$data['summary_info']=$this->schedule_model->get_order_summary_in_detail_info($_POST['oid']);
		if($_POST['did']==13){
			$this->load->view('schedule/change_date_final_qc',$data);
		}else if($_POST['did']==10){
			$this->load->view('schedule/change_date_dispatch',$data);
		}else if($_POST['did']==8){
			$this->load->view('schedule/change_date_for_stiching',$data);
		}else{
			$this->load->view('schedule/change_date',$data);
		}
	}
	
	//---------------------------------------------------------------------------------------------------

}
