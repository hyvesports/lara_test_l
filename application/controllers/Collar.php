<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collar extends CI_Controller {
	
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
		$this->settings_model->delete_collartype($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('collar/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_collartypes();
		//print_r($results);
		$data['results']=$results;
		$data['view']='collar/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('collar_type_name', 'Collar Type Name', 'trim|required');
			$this->form_validation->set_rules('collar_amount', 'Collar Amount', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='collar/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'collar_type_name' => $this->input->post('collar_type_name'),
					'collar_amount' => $this->input->post('collar_amount'),
					'collar_making_min' => $this->input->post('collar_making_min'),
					'collar_type_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_collartype_exist($data,'');
				if($dataExist['collar_type_id']==""){
					$result = $this->settings_model->insert_collartype($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('collar/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Collar type name already exists...!');
					$data['view']='collar/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='collar/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('collar_type_name', 'Collar Type Name', 'trim|required');
			$this->form_validation->set_rules('collar_amount', 'Collar Amount', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_collartype_data($id);
				$data['view'] = 'collar/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'collar_type_name' => $this->input->post('collar_type_name'),
					'collar_amount' => $this->input->post('collar_amount'),
					'collar_making_min' => $this->input->post('collar_making_min'),
					
				);
				
				$dataExist = $this->settings_model->check_collartype_exist($data,$this->input->post('collar_type_id'));
				if($dataExist['collar_type_id']==""){
					$result = $this->settings_model->update_collartype($data,$this->input->post('collar_type_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Collar type name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_collartype_data($id);
				$data['row']=$row;
				$data['view'] = 'collar/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_collartype_data($id);
			//print_r($row);
			if($row==""){
				redirect('collar/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='collar/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
