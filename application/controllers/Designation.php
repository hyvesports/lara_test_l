<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designation extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('settings_model', 'settings_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	function delete($uuid='')
	{   
		//$this->rbac->check_operation_access(); // check opration permission
		$this->settings_model->delete_designation($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('designation/index');
	}

	public function index(){
		$data['title']="Basic Settings | Designation";
		$data['title_head']="Designations";
		$results = $this->settings_model->get_all_designations();
		//print_r($results);
		$data['results']=$results;
		$data['view']='designation/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		$data['title']="Basic Settings | Departments";
		$data['title_head']="Designations";
		
		$data['parent_desi']= $this->settings_model->get_parent_designations('0');
		if($this->input->post('submit')){
			$this->form_validation->set_rules('designation_name', 'Designation Name', 'trim|required');
			$this->form_validation->set_rules('designation_parent', 'Designation Parent', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['view']='designation/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'designation_name' => $this->input->post('designation_name'),
					'designation_parent' => $this->input->post('designation_parent'),
					'designation_c_by' => $this->session->has_userdata('loginid'),
					'designation_c_date' =>date('Y-m-d'),
					'designation_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_designation_exist($this->input->post('designation_name'),'');
				if($dataExist['designation_id']==""){
					$result = $this->settings_model->insert_designation($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('designation/index');
				}else{
					$this->session->set_flashdata('error', 'Designation name already exists...!');
					$data['view']='designation/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			
			$data['view']='designation/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		$data['title']="Basic Settings | Designations";
		$data['title_head']="Designations";
		
		$data['parent_desi']= $this->settings_model->get_parent_designations('0');
		if($this->input->post('submit')){
			$this->form_validation->set_rules('designation_name', 'Designation Name', 'trim|required');
			$this->form_validation->set_rules('designation_parent', 'Designation Parent', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$row = $this->settings_model->get_department_data($id);
				$data['row']=$row;
				$data['view'] = 'designation/add_edit';
				$this->load->view('layout', $data);
			}else{
				
				$dataExist = $this->settings_model->check_designation_exist($this->input->post('designation_name'),$this->input->post('designation_id'));
				if($dataExist['designation_id']==""){
					$data = array(
						'designation_name' => $this->input->post('designation_name'),
						'designation_parent' => $this->input->post('designation_parent'),
					);
					$result = $this->settings_model->update_designation($data,$this->input->post('designation_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Department name already exists...!');
				}
				
				$data['title']="Basic Settings | Designations";
		$data['title_head']="Designations";
				
				$row = $this->settings_model->get_designation_data($id);
				$data['row']=$row;
				$data['view'] = 'designation/edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$row = $this->settings_model->get_designation_data($id);
			if($row==""){
				redirect('designation/index');exit;
			}
			$data['view']='designation/edit';
			$data['row']=$row;
			$this->load->view('layout',$data);
		}
	}
	

	
}
