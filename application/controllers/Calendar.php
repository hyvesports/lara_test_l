<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Calendar extends CI_Controller {
	
	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('calendar_model', 'calendar_model');
		$this->load->model('settings_model', 'settings_model');
		
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	
	
	//----------------------------------------------------------------------------------
	
	function delete($uuid='')
	{   
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("delete",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$calendar_month=date("m",$uuid);
		$calendar_year=date("Y",$uuid);
		
		//echo $calendar_date;exit;
		$this->calendar_model->delete_calender_data($calendar_month,$calendar_year);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('calendar/index');
	}
	
	
	//----------------------------------------------------------------------------------
	
	
	public function update_calender_dates(){
		
		if($this->input->post('submitDataa')){
			if($_POST['dates']){
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				//$calendar_c_datetime= date('d-m-Y H:i:s');
				//$calendar_c_by=$this->session->has_userdata('loginid');
				$calendar_u_datetime= date('d-m-Y H:i:s');
				$calendar_u_by=$this->session->has_userdata('loginid');
				
				$system_working_capacity_sec=$this->input->post('system_working_capacity_sec');
				//exit;
				$production_unit_ids=$this->input->post('production_unit_ids');
				$production_unit_ids_array=explode(',',$production_unit_ids);
				
				$inc=0;
				$up="UPDATE ";
				$table='';
				$where=' WHERE ';
				$condition='';
				$fields='';
				$set=' SET ';
				
				$up1="UPDATE ";
				$table1='';
				$where1=' WHERE ';
				$condition1='';
				$fields1='';
				$set1=' SET ';
				
				
				foreach($_POST['dates'] as $postedData){
					$calendar_date=trim(addslashes(htmlentities($postedData['date'])));
					$calendar_date=date("Y-m-d", strtotime($calendar_date));
					$calendar_year=date("Y", strtotime($calendar_date));
					$calendar_month=date("m", strtotime($calendar_date));
					$working_type=trim(addslashes(htmlentities($postedData['working'])));
					$working_capacity=trim(addslashes(htmlentities($postedData['capacity'])));
					
					//My number is 52200.
					$myNumber = $system_working_capacity_sec;
					//I want to get 25% of 928.
					$percentToGet = $working_capacity;
					//Convert our percentage value into a decimal.
					$percentInDecimal = $percentToGet / 100;
					//Get the result.
					$working_capacity_in_sec = $percentInDecimal * $myNumber;
					//$sec=$system_working_capacity_sec*$working_capacity;
					//$working_capacity_in_sec=$sec/100;
					
					$day_remark=trim(addslashes(htmlentities($postedData['remark'])));
					$calendar_id=trim(addslashes(htmlentities($postedData['calendar_id'])));
					
					if($production_unit_ids_array){
						$uic=1;
						foreach($production_unit_ids_array as $PArray){
							$unit_work=$postedData['unit_'.$PArray.'_'.$inc];
							//$sec1=$unit_work*$working_capacity_in_sec;
							//$unit_working_capacity_in_sec=$sec1/100;
							//My number is 52200.
							$myNumber1 = $system_working_capacity_sec;
							//I want to get 25% of 928.
							$percentToGet1 = $unit_work;
							//Convert our percentage value into a decimal.
							$percentInDecimal1 = $percentToGet1 / 100;
							//Get the result.
							$unit_working_capacity_in_sec = $percentInDecimal1 * $myNumber1;
							$update="UPDATE pr_unit_calendar SET unit_calendar_date='$calendar_date',unit_work='$unit_work',unit_working_capacity_in_sec='$unit_working_capacity_in_sec',unit_is_working='$working_type' WHERE calendar_id='$calendar_id' AND unit_id='$PArray'";
							$this->calendar_model->insert_production_calendar($update);
							$myNumber1=0;
							$unit_work=0;
							$percentToGet1=0;
							$percentInDecimal1=0;
							$unit_working_capacity_in_sec=0;
						}
					}
					
					
					if($inc==0){
						$table.='pr_production_calendar as T'.$inc;
						$fields.="T".$inc.".calendar_year='$calendar_year'";
						$fields.=",T".$inc.".calendar_month='$calendar_month'";
						$fields.=",T".$inc.".calendar_date='$calendar_date'";
						$fields.=",T".$inc.".working_type='$working_type'";
						$fields.=",T".$inc.".working_capacity='$working_capacity'";
						$fields.=",T".$inc.".day_remark='$day_remark'";
						$fields.=",T".$inc.".calendar_u_by='$calendar_u_by'";
						$fields.=",T".$inc.".calendar_u_datetime='$calendar_u_datetime'";
						$fields.=",T".$inc.".production_unit_ids='$production_unit_ids'";
						$fields.=",T".$inc.".working_capacity_in_sec='$working_capacity_in_sec'";
						$fields.=",T".$inc.".system_working_capacity_sec='$system_working_capacity_sec'";
						
						
						$condition.=" T".$inc.".calendar_id=".$calendar_id;
					}else{
						$table.=',pr_production_calendar as T'.$inc;
						$fields.=",T".$inc.".calendar_year='$calendar_year'";
						$fields.=",T".$inc.".calendar_month='$calendar_month'";
						$fields.=",T".$inc.".calendar_date='$calendar_date'";
						$fields.=",T".$inc.".working_type='$working_type'";
						$fields.=",T".$inc.".working_capacity='$working_capacity'";
						$fields.=",T".$inc.".day_remark='$day_remark'";
						$fields.=",T".$inc.".calendar_u_by='$calendar_u_by'";
						$fields.=",T".$inc.".calendar_u_datetime='$calendar_u_datetime'";
						$fields.=",T".$inc.".production_unit_ids='$production_unit_ids'";
						$fields.=",T".$inc.".working_capacity_in_sec='$working_capacity_in_sec'";
						$fields.=",T".$inc.".system_working_capacity_sec='$system_working_capacity_sec'";
						$condition.=" AND T".$inc.".calendar_id=".$calendar_id;
						
						
					}
					
					$inc++;
					$json_key_value='';
					
				}
				$up_sql=$up.$table.$set.$fields.$where.$condition;
				//$up_sql_1=$up1.$table1.$set1.$fields1.$where1.$condition1;
				if($up_sql){
					
					//$this->calendar_model->delete_production_calendar($calendar_year,$calendar_month);
					//echo $up_sql_1;exit;
					$this->calendar_model->insert_production_calendar($up_sql);
					//echo $up_sql_1;
					
					$responseMsg='<div class="alert alert-success" style="width:100%;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
					Production Calendar Saved Successfully
					</div>';
					echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
				}else{
					$responseMsg='<div class="alert alert-danger" style="width:100%;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
					Invalid form action!!!
					</div>';
					echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
				}
			}else{
				$responseMsg='<div class="alert alert-danger" style="width:100%;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
				Invalid form action!!!
				</div>';
				echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
			}
		}

	}
	
	//----------------------------------------------------------------------------------
	
	public function save_calender_dates(){
		
		if($this->input->post('submitDataa')){
			if($_POST['dates']){
				date_default_timezone_set('Asia/kolkata'); # add your city to set local time zone wo_client_id 
				$calendar_c_datetime= date('d-m-Y H:i:s');
				$calendar_c_by=$this->session->has_userdata('loginid');
				$calendar_u_datetime= date('d-m-Y H:i:s');
				$calendar_u_by=$this->session->has_userdata('loginid');
				
				$system_working_capacity_sec=$this->input->post('system_working_capacity_sec');
				$production_unit_ids=$this->input->post('production_unit_ids');
				$production_unit_ids_array=explode(',',$production_unit_ids);
				$calendar_uuid=date('Ymdhis');
				$inc=1;
				
				
				$inc=1;
				foreach($_POST['dates'] as $postedData){
					$calendar_date=trim(addslashes(htmlentities($postedData['date'])));
					$calendar_date=date("Y-m-d", strtotime($calendar_date));
					$calendar_year=date("Y", strtotime($calendar_date));
					$calendar_month=date("m", strtotime($calendar_date));
					$working_type=trim(addslashes(htmlentities($postedData['working'])));
					$working_capacity=trim(addslashes(htmlentities($postedData['capacity'])));
					
					$Design=trim(addslashes(htmlentities($postedData['Design'])));
					$Printing=trim(addslashes(htmlentities($postedData['Printing'])));
					$Fusing=trim(addslashes(htmlentities($postedData['Fusing'])));
					$Bundling=trim(addslashes(htmlentities($postedData['Bundling'])));
					$FinalQc=trim(addslashes(htmlentities($postedData['FinalQc'])));
					$Dispatch=trim(addslashes(htmlentities($postedData['Dispatch'])));
					
					//My number is 52200.
					$myNumber = $system_working_capacity_sec;
					//I want to get 25% of 928.
					$percentToGet = $working_capacity;
					//Convert our percentage value into a decimal.
					$percentInDecimal = $percentToGet / 100;
					//Get the result.
					$working_capacity_in_sec = $percentInDecimal * $myNumber;
					//Print it out - Result is 232.
					//echo $percent;
					//$sec=$system_working_capacity_sec*$working_capacity;
					//$working_capacity_in_sec=$sec/100;
					$day_remark=trim(addslashes(htmlentities($postedData['remark'])));
										
					//name="dates[30][unit_1_30]"
					$insert_sql="INSERT INTO `pr_production_calendar` (`calendar_id`,calendar_uuid, `calendar_year`, `calendar_month`, `calendar_date`, `working_type`, `working_capacity`, `day_remark`, `calendar_c_by`, `calendar_c_datetime`, `calendar_u_by`, `calendar_u_datetime`,production_unit_ids,system_working_capacity_sec,working_capacity_in_sec) VALUES ";					
					$insert_sql.="(NULL,'$calendar_uuid','$calendar_year','$calendar_month', '$calendar_date', '$working_type', '$working_capacity', '$day_remark', '$calendar_c_by', '$calendar_c_datetime', '$calendar_u_by', '$calendar_u_datetime','$production_unit_ids','$system_working_capacity_sec','$working_capacity_in_sec')";
					$calendar_id=$this->calendar_model->insert_production_calendar($insert_sql);
					
					
					 if($production_unit_ids_array){
					foreach($production_unit_ids_array as $PArray){
						$unit_work=$postedData['unit_'.$PArray.'_'.$inc];
						//$sec1=$unit_work*$working_capacity_in_sec;
						//$unit_working_capacity_in_sec=$sec1/100;
						//My number is 52200.
						$myNumber1 = $system_working_capacity_sec;
						//I want to get 25% of 928.
						$percentToGet1 = $unit_work;
						//Convert our percentage value into a decimal.
						$percentInDecimal1 = $percentToGet1 / 100;
						//Get the result.
						$unit_working_capacity_in_sec = $percentInDecimal1 * $myNumber1;
						$sql="INSERT INTO `pr_unit_calendar` (`unit_calendar_id`, `calendar_id`,unit_is_working,unit_calendar_date, `unit_id`, `unit_work`,unit_working_capacity_in_sec,allocated_to_design,allocated_to_printing,allocated_to_fusing,allocated_to_bundling,allocated_to_finalqc,allocated_to_dispatch) VALUES (NULL, '$calendar_id','$working_type','$calendar_date','$PArray', '".$unit_work."','$unit_working_capacity_in_sec','$Design','$Printing','$Fusing','$Bundling','$FinalQc','$Dispatch');";
						$this->calendar_model->insert_production_unit_calendar($sql);
						
						$myNumber1=0;
						$unit_work=0;
						$percentToGet1=0;
						$percentInDecimal1=0;
						$unit_working_capacity_in_sec=0;
						}
					}
					$inc++;
					$calendar_id="";
					$insert_sql="";
				}
			
				
					
					$responseMsg='<div class="alert alert-success" style="width:100%;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
					Production Calendar Updated Successfully
					</div>';
					echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
			
			}else{
				$responseMsg='<div class="alert alert-danger" style="width:100%;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
				Invalid form action!!!
				</div>';
				echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
			}
		}
	}
	
	public function update_dept_qty(){
		
		if($this->input->post('submitDataa')){
			if($_POST['dates']){
				$inc=0;
				foreach($_POST['dates'] as $postedData){
					$unit_calendar_id=$postedData['unit_calendar_id'];
					$allocated_to_design=$postedData['design'];
					$allocated_to_printing=$postedData['printing'];
					$allocated_to_fusing=$postedData['fusing'];
					$allocated_to_bundling=$postedData['bundling'];
					$allocated_to_finalqc=$postedData['finalqc'];
					$allocated_to_dispatch=$postedData['dispatch'];
					$sql="UPDATE  `pr_unit_calendar` SET allocated_to_design='$allocated_to_design',
allocated_to_printing='$allocated_to_printing',allocated_to_fusing='$allocated_to_fusing',allocated_to_bundling='$allocated_to_bundling',allocated_to_finalqc='$allocated_to_finalqc',allocated_to_dispatch='$allocated_to_dispatch' WHERE unit_calendar_id='$unit_calendar_id' ";
					//$this->calendar_model->insert_production_unit_calendar($sql);
					$query = $this->db->query($sql);
					$inc++;
				}

				$responseMsg='<div class="alert alert-success" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>Production Qty Updated Successfully</div>';
				echo json_encode(array('responseCode'=>"success",'responseMsg'=>$responseMsg));
			
			}else{
				$responseMsg='<div class="alert alert-danger" style="width:100%;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
				Invalid form action!!!
				</div>';
				echo json_encode(array('responseCode'=>"fali",'responseMsg'=>$responseMsg));
			}
		}
	}
	
	//----------------------------------------------------------------------------------
	public function load_dates(){
		$posted_year=$this->input->post('calendar_year');
		$posted_month=$this->input->post('calendar_month');
		$created_date=$posted_year.'-'.$posted_month.'-01';
		
		
		$unit_id=$this->input->post('unit_id');
		
		$data['posted_year']=$posted_year;
		$data['posted_month']=$posted_month;
		
		$data['production_units']=$this->calendar_model->get_all_production_units();
		//$data['production_units']=$this->calendar_model->get_all_production_units_by_id($unit_id);
		
//		$data['no_of_days']=cal_days_in_month(CAL_GREGORIAN,$posted_month,$posted_year);
		$data['no_of_days']=$this->calendar_model->days_in_month($posted_month,$posted_year);



		$data['created_date']=$created_date;
		
		$this->load->model('schedule_model', 'schedule_model');
		$data['systemRow1']=$this->schedule_model->get_system_production_days('WH');
		
		$row=$this->calendar_model->chk_calender_created($posted_year,$posted_month);
		if($row['calendar_id']!=""){
			
			echo $responseMsg='<div class="alert alert-warning" style="width:100%;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
				Calender already created..!!!
				</div>';
			exit;
		}else{
		
		$this->load->view('calendar/load_dates',$data);
		}
		
	}
	//---------------------------------------------------------------------------------
	
	public function view($id=0){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("view",$accessArray)){
			redirect('access/access_denied');
			}}
		}
		$data['production_units']=$this->calendar_model->get_all_production_units();
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		$calendar_month=date("m",$id);
		$calendar_year=date("Y",$id);
		$data['month_and_year']=date("F Y",$id);
		$data['allDates']=$this->calendar_model->get_all_dates_list($calendar_month,$calendar_year);
		$data['view']='calendar/view';
		$this->load->view('layout',$data);
		
	}
	
	//---------------------------------------------------------------------------------
	
	public function load_dates_for_departments(){
		$unit_id=$this->input->post('unit_id');
		$calendar_month=$this->input->post('calendar_month');
		$calendar_year=$this->input->post('calendar_year');
		$data['month_and_year']=$this->input->post('month_and_year');
		$data['allDates']=$this->calendar_model->get_all_dates_list_by_unit($calendar_month,$calendar_year,$unit_id);
		$this->load->view('calendar/load_dates_for_departments',$data);
	}
	public function capacity($id=0){
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
		//$this->load->model('schedule_model', 'schedule_model');
		//$data['systemRow1']=$this->schedule_model->get_system_production_days('WH');
		$calendar_month=date("m",$id);
		$calendar_year=date("Y",$id);
		$data['calendar_month']=$calendar_month;
		$data['calendar_year']=$calendar_year;
		$data['month_and_year']=date("F Y",$id);
		$data['production_units']=$this->calendar_model->get_all_production_units();

		//$data['allDates']=$this->calendar_model->get_all_dates_list($calendar_month,$calendar_year);
		$data['view']='calendar/capacity';
		$this->load->view('layout',$data);
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
		$this->load->model('schedule_model', 'schedule_model');
		$data['systemRow1']=$this->schedule_model->get_system_production_days('WH');
		$calendar_month=date("m",$id);
		$calendar_year=date("Y",$id);
		$data['month_and_year']=date("F Y",$id);
		$data['production_units']=$this->calendar_model->get_all_production_units();
		$data['allDates']=$this->calendar_model->get_all_dates_list($calendar_month,$calendar_year);
		$data['view']='calendar/edit';
		$this->load->view('layout',$data);
	}
	
	//----------------------------------------------------------------------------------
	public function add(){
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
		//$data['production_units_managed']=$this->calendar_model->get_all_production_unit_managed_by();
		$data['production_units']=$this->calendar_model->get_all_production_units();
		$data['view']='calendar/add';
		$this->load->view('layout',$data);
	}
	//----------------------------------------------------------------------------------
	function reset_filter()
	{
		$this->session->unset_userdata('calendar_year');
		$this->session->unset_userdata('calendar_month');
		redirect('calendar/index');
	}
	//----------------------------------------------------------------------------------
	function filter()
	{
		$this->session->set_userdata('calendar_year',$this->input->post('calendar_year'));
		$this->session->set_userdata('calendar_month',$this->input->post('calendar_month'));
	}
	//----------------------------------------------------------------------------------
	public function index(){
		//echo $this->session->userdata('calendar_year');
		//echo $this->session->userdata('calendar_month');
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		$data['results'] = $this->calendar_model->get_all_calender_date();
		$data['accessArray']=$accessArray;
		$data['view']='calendar/index';
		$this->load->view('layout',$data);
		
	}
	//____________________________________end of calender ____________________________
	

	
}
