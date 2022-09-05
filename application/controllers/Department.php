<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('settings_model', 'settings_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	function delete($id='')
	{   
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("delete",$accessArray)){
			redirect('access/access_denied');
			}}
		}

		$this->settings_model->delete($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('department/index');
	}

	public function index(){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}
		//print_r($accessArray);
		$data['title']="Basic Settings | Departments";
		$results = $this->settings_model->get_all_departments();
		//print_r($results);
		$data['results']=$results;
		$data['accessArray']=$accessArray;
		$data['view']='department/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("add",$accessArray)){
			redirect('access/access_denied');
			}}
		}

		//echo $id;
		$data['parent_dept']= $this->settings_model->get_parent_departments();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']="Basic Settings | Departments";
				$data['view']='department/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'department_name' => $this->input->post('department_name'),
					'department_parent' => $this->input->post('department_parent'),
					'department_c_by' => $this->session->has_userdata('loginid'),
					'department_c_date' =>date('Y-m-d'),
					'department_status' => '1',
					'is_dynamic' => '1'
				);
				
				$dataExist = $this->settings_model->check_exist($this->input->post('department_name'),'');
				if($dataExist['department_id']==""){
					$result = $this->settings_model->insert_department($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('department/index');
				}else{
					$this->session->set_flashdata('error', 'Department name already exists...!');
					$data['title']="Basic Settings | Departments";
					$data['view']='department/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['title']="Basic Settings | Departments";
			$data['view']='department/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		if($accessArray==""){
			redirect('access/not_found');
		}else{
			if($accessArray){if(!in_array("edit",$accessArray)){
			redirect('access/access_denied');
			}}
		}

		$data['parent_dept']= $this->settings_model->get_parent_departments();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']="Basic Settings | Departments";
				$row = $this->settings_model->get_department_data($id);
				$data['row']=$row;
				$data['view'] = 'department/add_edit';
				$this->load->view('layout', $data);
			}else{
				
				$dataExist = $this->settings_model->check_exist($this->input->post('department_name'),$this->input->post('department_id'));
				if($dataExist['department_id']==""){
					$data = array(
						'department_name' => $this->input->post('department_name'),
						'department_parent' => $this->input->post('department_parent'),
					);
					$result = $this->settings_model->update_department($data,$this->input->post('department_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Department name already exists...!');
				}
				$data['title']="Basic Settings | Departments";
				$row = $this->settings_model->get_department_data($id);
				$data['row']=$row;
				$data['view'] = 'department/add_edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$row = $this->settings_model->get_department_data($id);
			$data['title']="Basic Settings | Departments";
			$data['view']='department/add_edit';
			$data['row']=$row;
			$this->load->view('layout',$data);
		}
	}
	

	
}
