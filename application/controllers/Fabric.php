<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fabric extends CI_Controller {
	
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
		//$this->rbac->check_operation_access(); // check opration permission
		$this->settings_model->delete_fabrictype($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('fabric/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_fabrictypes();
		//print_r($results);
		$data['results']=$results;
		$data['view']='fabric/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('fabric_type_name', 'Fabric Type Name', 'trim|required');
			$this->form_validation->set_rules('fabric_amount', 'Fabric Amount', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='fabric/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'fabric_type_name' => $this->input->post('fabric_type_name'),
					'fabric_amount' => $this->input->post('fabric_amount'),
					'fabric_making_hr' => $this->input->post('fabric_making_hr'),
					'fabric_making_min' => $this->input->post('fabric_making_min'),
					'fabric_type_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_fabrictype_exist($data,'');
				if($dataExist['fabric_type_id']==""){
					$result = $this->settings_model->insert_fabrictype($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('fabric/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Fabric type name already exists...!');
					$data['view']='fabric/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='fabric/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('fabric_type_name', 'Fabric Type Name', 'trim|required');
			$this->form_validation->set_rules('fabric_amount', 'Fabric Amount', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_fabrictype_data($id);
				$data['view'] = 'fabric/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'fabric_type_name' => $this->input->post('fabric_type_name'),
					'fabric_amount' => $this->input->post('fabric_amount'),
					'fabric_making_hr' => $this->input->post('fabric_making_hr'),
					'fabric_making_min' => $this->input->post('fabric_making_min'),
					
				);
				
				$dataExist = $this->settings_model->check_fabrictype_exist($data,$this->input->post('fabric_type_id'));
				if($dataExist['fabric_type_id']==""){
					$result = $this->settings_model->update_fabrictype($data,$this->input->post('fabric_type_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Fabric type name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_fabrictype_data($id);
				$data['row']=$row;
				$data['view'] = 'fabric/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_fabrictype_data($id);
			//print_r($row);
			if($row==""){
				redirect('fabric/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='fabric/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
