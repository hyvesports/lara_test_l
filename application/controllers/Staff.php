<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('staff_model', 'staff_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	//-----------------------------------------------------------
	function set_access()
	{   
		$this->staff_model->set_access();
	}
	
	
	public function save_resetpwd(){
		if($this->input->post('Submit')){
			$this->form_validation->set_rules('new_pwd', 'New password', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg='<div class="alert alert-warning alert-dismissible" style="width:100%;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<h4><i class="icon fa fa-warning"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode'=>"F",'responseMsg'=>$msg));
				exit;
			}else{
				$new_pwd=$this->input->post('new_pwd');
				$slid=$this->input->post('slid');
				
				$u2="UPDATE login_master SET log_password='".md5($new_pwd)."' WHERE login_master_id='$slid'   ";
				$this->db->query($u2);
				$message='<div class="alert alert-success alert-dismissible" style="width:100%;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<h4>Success!</h4>
						<p>Password reset successfully...!</p>
						</div>';
						echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
						exit;
			}
		}
	}
	
	public function resetpwd(){
		$this->load->view('staff/reset_pwd');
	}
	
	//--------------------------------------------------
	public function permission($id=0){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$data['MainModules']= $this->auth_model->menu_master_data('0');
		$data['result'] = $this->staff_model->get_staff_data($id);
		$data['view']='staff/permission';
		$this->load->view('layout',$data);
	}
	//--------------------------------------------------
	
	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		if($moduleData==""){
			$this->load->view('not_found');
		}else{
		//print_r($moduleData);
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		$results = $this->staff_model->get_all_staffs();
		//print_r($results);
		$data['results']=$results;
		$data['accessArray']=$moduleData;
		$data['view']='staff/index';
		$this->load->view('layout',$data);
		}
	}
	
	
	public function chk_staff_code($code = ""){
		//echo $pno;
		$datachk = array(
			'staff_code' => $code
		);
		$row = $this->staff_model->check_staffcode_exist($datachk,'');
		if($row){
			echo json_encode(array('responseCode' =>"valid",'responseMsg'=>''));
		}else{
			echo json_encode(array('responseCode' =>"invalid",'responseMsg'=>'Invalid staff code'));
		}
		
	}
	
	public function chk_staff_logid($code = ""){
		//echo $pno;
		$datachk = array(
			'log_username' => $code
		);
		$row = $this->staff_model->check_staff_logid_exist($datachk,'');
		if($row){
			echo json_encode(array('responseCode' =>"exist",'responseMsg'=>'Username already taken'));
		}else{
			echo json_encode(array('responseCode' =>"available",'responseMsg'=>'Username available'));
		}
		
	}
	
	public function add(){
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('staff_code', 'Staff Code', 'trim|required');
			$this->form_validation->set_rules('log_username', 'Username', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['password']= $this->auth_model->random_password();
				$this->load->model('settings_model', 'settings_model');
				$data['parent_desi']= $this->settings_model->get_active_designation(0);
				$data['parent_dept']= $this->settings_model->get_active_department(0);
				$data['work_locations']= $this->settings_model->get_active_locations();
				$data['view']='staff/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'staff_code' => $this->input->post('staff_code'),
					'log_username' => $this->input->post('log_username')
				);
				
				$md_id=$this->input->post('department_id');
				if(isset($_POST['department_managed'])){
				if($_POST['department_managed']){
					foreach($_POST['department_managed'] as $md){
						$md_id.=','.$md;
					}
				}
				}
				$unit_m="0";
				if(isset($_POST['unit_managed'])){
				if($_POST['unit_managed']){
					foreach($_POST['unit_managed'] as $unit){
						$unit_m.=','.$unit;
					}
					//$unit_m = rtrim($unit_m, ", ");
				}
				}
				
				$data_staff = array(
					'staff_code' => $this->input->post('staff_code'),
					'staff_name' => $this->input->post('staff_name'),
					'designation_id' => $this->input->post('designation_id'),
					'department_id' => $this->input->post('department_id'),
					'location_id' => $this->input->post('location_id'),
					'staff_c_by' => $this->session->has_userdata('loginid'),
					'staff_c_date' =>date('Y-m-d'),
					'staff_u_by' => $this->session->has_userdata('loginid'),
					'staff_u_date' =>date('Y-m-d'),
					'staff_status' => '1',
					'department_managed' => $md_id,
					'unit_managed'=>$unit_m,
					'dashboard_category' => $this->input->post('dashboard_category'),
				);
				
				//department_managed
				
				
				$data_login = array(
					'user_role_id' => '3',
					'log_username' => $this->input->post('log_username'),
					'log_password' => md5($this->input->post('log_password')),
					'log_full_name' => $this->input->post('staff_name'),
					'log_email' => $this->input->post('log_email'),
					'log_phone_number' => $this->input->post('log_phone_number'),
					'log_status' => '1'
				);
				
				$dataExist = $this->staff_model->check_username_exist($data,'');
				if($dataExist['login_master_id']==""){
					$dataExist2 = $this->staff_model->check_staffcode_exist($data,'');
					if($dataExist2['staff_id']==""){
						$login_master_id = $this->staff_model->insert_login_data($data_login);
						if($login_master_id){
							$staffid = $this->staff_model->insert_staff_data($data_staff,$login_master_id);
							$this->session->set_flashdata('success','Saved successfully');
							redirect('staff/index');
						}else{
							$this->session->set_flashdata('error', 'Something wrong...!');
							
							$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
							$data['title_head']=$moduleData['menu_name'];
							
							$data['password']= $this->auth_model->random_password();
							$this->load->model('settings_model', 'settings_model');
							$data['parent_desi']= $this->settings_model->get_active_designation(0);
							$data['parent_dept']= $this->settings_model->get_active_department(0);
							$data['work_locations']= $this->settings_model->get_active_locations();
							$data['units']= $this->settings_model->get_active_units();
							//$this->session->set_flashdata('error', 'Staff code already exists...!');
							$data['view']='staff/add';
							$this->load->view('layout',$data);
						}
						
					}else{
						$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
						$data['title_head']=$moduleData['menu_name'];
						
						$data['password']= $this->auth_model->random_password();
						$this->load->model('settings_model', 'settings_model');
						$data['parent_desi']= $this->settings_model->get_active_designation(0);
						$data['parent_dept']= $this->settings_model->get_active_department(0);
						$data['work_locations']= $this->settings_model->get_active_locations();
						$data['units']= $this->settings_model->get_active_units();
						$this->session->set_flashdata('error', 'Staff code already exists...!');
						$data['view']='staff/add';
						$this->load->view('layout',$data);
					}
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					
					$data['password']= $this->auth_model->random_password();
					$this->load->model('settings_model', 'settings_model');
					$data['parent_desi']= $this->settings_model->get_active_designation(0);
					$data['parent_dept']= $this->settings_model->get_active_department(0);
					$data['work_locations']= $this->settings_model->get_active_locations();
					$data['units']= $this->settings_model->get_active_units();
					$this->session->set_flashdata('error', 'Username already exists...!');
					$data['view']='staff/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			
			$data['password']= $this->auth_model->random_password();
			$this->load->model('settings_model', 'settings_model');
			$data['parent_desi']= $this->settings_model->get_active_designation(0);
			$data['parent_dept']= $this->settings_model->get_active_department(0);
			$data['work_locations']= $this->settings_model->get_active_locations();
			$data['units']= $this->settings_model->get_active_units();
			
			
			$data['view']='staff/add';
			$this->load->view('layout',$data);
		}
	}


	public function edit($id = 0){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('staff_code', 'Staff Code', 'trim|required');
			//$this->form_validation->set_rules('log_username', 'Username', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$this->load->model('settings_model', 'settings_model');
				$data['parent_desi']= $this->settings_model->get_active_designation(0);
				$data['parent_dept']= $this->settings_model->get_active_department(0);
				$data['work_locations']= $this->settings_model->get_active_locations();
				$data['units']= $this->settings_model->get_active_units();
				$data['view'] = 'staff/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'staff_code' => $this->input->post('staff_code')
				);
			
				$dataExist = $this->staff_model->check_staffcode_exist($data,$this->input->post('staff_id'));
				if($dataExist['staff_id']==""){
					
					$md_id=$this->input->post('department_id');
					if(isset($_POST['department_managed'])){
					if($_POST['department_managed']!=""){
						foreach($_POST['department_managed'] as $md){
							$md_id.=','.$md;
						}
					}
					}
					$umid='0';
					if(isset($_POST['unit_managed'])){
					if($_POST['unit_managed']!=""){
						foreach($_POST['unit_managed'] as $unit){
							$umid.=','.$unit;
						}
						//$umid= rtrim($umid, ", ");
					}
					}
					
					
					$data_staff = array(
					'staff_code' => $this->input->post('staff_code'),
					'staff_name' => $this->input->post('staff_name'),
					'designation_id' => $this->input->post('designation_id'),
					'department_id' => $this->input->post('department_id'),
					'location_id' => $this->input->post('location_id'),
					'staff_u_by' => $this->session->has_userdata('loginid'),
					'staff_u_date' =>date('Y-m-d'),
					'department_managed' => $md_id,
					'unit_managed' => $umid,
					'dashboard_category' => $this->input->post('dashboard_category'),
					);
					
					$result = $this->staff_model->update_staff_data($data_staff,$this->input->post('staff_id'));
					if($result){
						$data_login = array(
							'log_full_name' => $this->input->post('staff_name'),
							'log_email' => $this->input->post('log_email'),
							'log_phone_number' => $this->input->post('log_phone_number'),
							'log_status' => '1'
						);
						$result2 = $this->staff_model->update_login_data($data_login,$this->input->post('login_master_id'));
						if($result2){
							$this->session->set_flashdata('success1','Saved successfully');
						}else{
							$this->session->set_flashdata('error1', 'Something wrong...!');
						}
						
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Staff name already exists...!');
				}
				
				
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->staff_model->get_staff_data($id);
				$this->load->model('settings_model', 'settings_model');
				$data['parent_desi']= $this->settings_model->get_active_designation(0);
				$data['parent_dept']= $this->settings_model->get_active_department(0);
				$data['work_locations']= $this->settings_model->get_active_locations();
				$data['units']= $this->settings_model->get_active_units();
				$data['row']=$row;
				$data['view'] = 'staff/edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			
			$this->load->model('settings_model', 'settings_model');
			$data['parent_desi']= $this->settings_model->get_active_designation(0);
			$data['parent_dept']= $this->settings_model->get_active_department(0);
			$data['work_locations']= $this->settings_model->get_active_locations();
			$data['units']= $this->settings_model->get_active_units();
			$row = $this->staff_model->get_staff_data($id);
			//print_r($row);
			if($row==""){
				redirect('staff/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='staff/edit';
			$this->load->view('layout',$data);
		}
	}
	function delete($uuid='')
	{   
		$this->rbac->check_operation_access(); // check opration permission
		$staffRow=$this->staff_model->get_staff_data($uuid);
		$this->staff_model->delete_staff_login_data($staffRow['login_id']);
		$this->staff_model->delete_staff_data($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('staff/index');
	}

	
}
