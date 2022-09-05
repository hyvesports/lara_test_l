<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
	}
	public function index()
	{
		if($this->session->has_userdata('loginid'))
		{
			redirect('myaccount/index');
		}else{
			$data['title']="Login";
			$this->load->view('auth/login',$data);
		}
	}
	public function login(){
		$data['title']="Login";
		if($this->input->post('submit')){
			$this->form_validation->set_rules('userid', 'Username', 'trim|required');
			$this->form_validation->set_rules('userpwd', 'Password', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('auth/login',$data);
			}
			else {
				$pwd=$this->input->post('userpwd');
				$pwd=md5($pwd);
				$data = array(
					'log_username' => $this->input->post('userid'),
					'log_password' => $pwd
				);
				$result = $this->auth_model->login($data);
				//print_r($result);exit;
				if($result){
					//$this->auth_model->update_log_session($result['login_master_id']);
					$session_id=session_id();
					$department_parent=0;
					$staff_id=0;
					if($result['user_role_id']==3){
						$resultStaff= $this->auth_model->get_staff_info($result['login_master_id']);
						$department_parent=$resultStaff['department_parent'];
						$staff_id=$resultStaff['staff_id'];
						if(!isset($resultStaff)){
							$this->session->set_flashdata('error', 'Account is invalid!');
							redirect(base_url('auth/login'));
							exit;
						}
					}
					if($result['log_status'] == 1){
						$logdata = array(
							'loginid' => $result['login_master_id'],
							'log_session_id'=> $session_id,
							'department_parent'=> $department_parent,
							'staff_id'=> $staff_id,
							'username' => $result['log_full_name'],
							'role_id' => $result['user_role_id'],
							'role_name' => $result['role_name'],
							'date_now' => date('Y-m-d'),
							'is_admin_login' => TRUE
						);
						//print_r($logdata);exit;
						$this->session->set_userdata($logdata);
						//$this->rbac->set_access_in_session(); // set access in session
						redirect(base_url('myaccount/index'), 'refresh');
					}else{
						$this->session->set_flashdata('error', 'Account is disabled by Admin!');
						redirect(base_url('auth/login'));
						exit;
					}
					
				}else{
					$this->session->set_flashdata('error', 'Invalid Username or Password!');
					redirect(base_url('auth/login'));
				}
				//print_r($data);
			}
		}else{
			$this->load->view('auth/login',$data);
		}
	}

	public function logout(){
			$this->session->sess_destroy();
			redirect(base_url('auth/login'), 'refresh');
	}

}

