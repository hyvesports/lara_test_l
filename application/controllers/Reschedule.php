<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Reschedule extends CI_Controller {

	public function __construct(){ 

		parent::__construct();

		$this->load->model('auth_model', 'auth_model');

		$this->load->model('workorder_model', 'workorder_model');

		$this->load->model('order_model', 'order_model');

		$this->load->model('schedule_model', 'schedule_model');

		$this->load->model('reschedule_model', 'reschedule_model');

		$this->load->model('common_model', 'common_model');

		$this->load->model('myaccount_model', 'myaccount_model');

		

		

		$this->load->library('datatable');

		if(!$this->session->has_userdata('loginid')){

			redirect('auth/login');

		}

	}

	

	

	function save_schedule(){

		//print_r($_POST);exit;

		if($this->input->post('submitScheduleData')){

			$this->form_validation->set_rules('schedule_department_id', 'Department', 'trim|required');

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

				$unit_id =$this->input->post('unit_id');

				$department_id=$this->input->post('department_id');

				$re_schedule_status=$this->input->post('re_schedule_status');

				$rs_design_id=$this->input->post('rs_design_id');

				$new_batch_number= date('YmdHis');

				if($re_schedule_status==-1){

					if($_POST['submittedData']!=""){

						foreach($_POST['submittedData'] as $SD){

							$reschedule_date=$SD['new_date'];

							$rej_order_id=$SD['rej_order_id'];

							$up="UPDATE rj_scheduled_orders SET reschedule_date='$reschedule_date',re_schedule_status='-1' WHERE rej_order_id='$rej_order_id' ";

							$query = $this->db->query($up);

						}

						//$this->session->set_flashdata('success','Data saved successfully in draft');

						//redirect('reschedule/schedule/'.$schedule_id.'/'.$order_id.'/'.$rs_design_id);

						$responseMsg='<div class="alert alert-success" style="width:100%;">';

						$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';

						$responseMsg.='Data saved successfully in draft...!</div>';

						echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));

						

					}

				}else{

					//orderITEM

					$total_order_second=0;

					if($_POST['orderITEM']!=""){

						$inccc=0;

						$new_json="[";

						foreach($_POST['orderITEM'] as $SH){

							if($inccc==0){

								$new_json.=json_encode($SH);

							}else{ 

								$new_json.=",".json_encode($SH);

							}

							$item_qty=$SH['item_unit_qty_input'];

							$item_second=$SH['item_order_sec'];

							$total_order_second+=$item_second*$item_qty;

							$inccc++;

						}

						$new_json.="]";

					}

					

					//print_r($new_json);

					if($_POST['submittedData']!=""){

						$schedule_is_completed=1;

						$uuid=$this->schedule_model->get_schedule_uuid();

						$now = date('d-m-Y H:i:s');

						$save_data1 = array(

							'schedule_uuid' => $uuid['uid'],

							'parent_schedule_id' => $schedule_id,

							'order_id' => $order_id,

							'schedule_code' => 'RSH'.date('Ymdhis'),

							'schedule_unit_id' => $unit_id,

							'schedule_c_by' => $this->session->userdata('loginid'),

							'schedule_c_date' =>date('Y-m-d'),

							'schedule_u_by' => $this->session->userdata('loginid'),

							'schedule_u_date' =>date('Y-m-d'),

							'schedule_time_stamp' => $now,

							'schedule_is_completed' =>$schedule_is_completed,

							'order_total_qty' =>1,

							'order_total_submitted_qty' => 1,

							'order_balance_qty' => 0,

							'sh_order_json' => $new_json,

							'total_order_second' => $total_order_second,

							'schedule_status' =>$schedule_is_completed

						);

						//print_r($new_json);

						

						$new_schedule_id=$this->schedule_model->save_schedule_data($save_data1);

						//echo $new_schedule_id;

						//exit;

						foreach($_POST['submittedData'] as $SD){

							$reschedule_date=$SD['new_date'];

							$scheduled_date=date('Y-m-d', strtotime($reschedule_date));

							$department_ids=$SD['department_ids'];

							$schedule_department_id=$SD['schedule_department_id'];

							

							$insert= array(
								'schedule_id'=>$new_schedule_id,
								'department_ids'=>$department_ids,
								'department_schedule_date' =>$scheduled_date,
								'department_schedule_status' => 0,
								'scheduled_order_info' => $new_json,
								'unit_id'=>$unit_id,
								'order_id'=>$order_id,
								'batch_number'=>$new_batch_number,
								'is_re_scheduled'=>$schedule_department_id

							);

							$this->reschedule_model->save_reschedule_data($insert);

							$rej_order_id=$SD['rej_order_id'];

							$up="UPDATE rj_scheduled_orders SET reschedule_date='$reschedule_date',re_schedule_status='1',new_schedule_id='$new_schedule_id'  WHERE rej_order_id='$rej_order_id' ";

							$query = $this->db->query($up);

							

							$up2="UPDATE sh_schedule_departments SET is_re_scheduled='-1' WHERE schedule_department_id='$schedule_department_id' ";
							$query = $this->db->query($up2);
							$insert="";

							

						}

					}

					//exit;

					$responseMsg='<div class="alert alert-success" style="width:100%;">';

					$responseMsg.='<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>';

					$responseMsg.='Order rescheduled successfully...!</div>';

					echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));

				}

				

				

			}

			

		}else{

			redirect('reschedule/index');

		}

	}

	

	public function schedule($schedule_id,$order_id,$rs_design_id){

		$accessArray=$this->rbac->check_operation_access(); 

		if($accessArray==""){

			redirect('access/not_found');

		}

		$data['row']= $this->reschedule_model->get_order_details($order_id);

		$data['response']= $this->reschedule_model->get_order_response_details($rs_design_id);

		$data['rejection_row']= $this->reschedule_model->get_order_rejection_details($schedule_id,$order_id,$rs_design_id);

		

		$data['all_rej_rows']= $this->reschedule_model->get_all_order_rejection_rows($schedule_id,$order_id,$rs_design_id);

		

		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];

		$data['title_head']="RE SCHEDULE";

		$data['view']='reschedule/reschedule_item';

		$this->load->view('layout',$data);

	}

	



	public function index(){

		$accessArray=$this->rbac->check_operation_access(); // check opration permission

		if($accessArray==""){

			redirect('access/not_found');

		}

		$loginid=$this->session->userdata('loginid');

		$staffRow=$this->auth_model->get_staff_profile_data($loginid);

		if($this->session->userdata('role_id')=="1"){ // is admin

			$unit_managed="admin";

		}else{

			$unit_managed=$staffRow['unit_managed'];

		}

		

		$data['records']= $this->reschedule_model->get_all_rejected_works($unit_managed);

		

		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];

		$data['title_head']=$accessArray['menu_name'];

		$data['view']='reschedule/index';

		$this->load->view('layout',$data);

	}

	

	function day_overview_stiching(){

		$choosed_date=date('Y-m-d', strtotime($_POST['choosed_date']));

		$data['calender_date_info']=$this->schedule_model->get_unit_calender_date_info($choosed_date,$_POST['uid']);

		$data['day_overview']=$this->schedule_model->get_orders_under_date_and_depmt($choosed_date,$_POST['did'],$_POST['uid']);

		$this->load->view('schedule/day_overview_stiching',$data);

		

	}

	

	//________________________________________________________________________________________________________________________________________



}

