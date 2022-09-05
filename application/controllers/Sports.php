<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sports extends CI_Controller {
	
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
		$this->settings_model->delete_sportstype($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('sports/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_sportstypes();
		//print_r($results);
		$data['results']=$results;
		$data['view']='sports/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('sports_type_name', 'Sports Type Name', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='sports/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'sports_type_name' => $this->input->post('sports_type_name'),
					'sports_type_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_sportstype_exist($data,'');
				if($dataExist['sports_type_id']==""){
					$result = $this->settings_model->insert_sportstype($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('sports/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Sports type name already exists...!');
					$data['view']='sports/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='sports/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('sports_type_name', 'Sports Type Name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_sportstype_data($id);
				$data['view'] = 'sports/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'sports_type_name' => $this->input->post('sports_type_name'),
					'sports_type_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_sportstype_exist($data,$this->input->post('sports_type_id'));
				if($dataExist['sports_type_id']==""){
					$result = $this->settings_model->update_sportstype($data,$this->input->post('sports_type_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Sports type name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_sportstype_data($id);
				$data['row']=$row;
				$data['view'] = 'sports/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_sportstype_data($id);
			//print_r($row);
			if($row==""){
				redirect('sports/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='sports/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
