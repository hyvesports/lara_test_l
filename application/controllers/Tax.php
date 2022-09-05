<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller {
	
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
		$this->rbac->check_operation_access(); // check opration permission
		$this->settings_model->delete_tax($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('tax/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_taxx();
		//print_r($results);
		$data['results']=$results;
		$data['view']='tax/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('taxclass_name', 'Tax name', 'trim|required');
			$this->form_validation->set_rules('taxclass_value', 'Tax value', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='tax/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'taxclass_name' => $this->input->post('taxclass_name'),
					'taxclass_value' => $this->input->post('taxclass_value'),
					'taxclass_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_tax_exist($data,'');
				if($dataExist['taxclass_id']==""){
					$result = $this->settings_model->insert_tax($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('tax/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Tax name already exists...!');
					$data['view']='tax/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['view']='tax/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('taxclass_name', 'Tax name', 'trim|required');
			$this->form_validation->set_rules('taxclass_value', 'Tax value', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['row']= $this->settings_model->get_tax_data($id);
				$data['view'] = 'tax/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'taxclass_name' => $this->input->post('taxclass_name'),
					'taxclass_value' => $this->input->post('taxclass_value')
				);
				
				$dataExist = $this->settings_model->check_tax_exist($data,$this->input->post('taxclass_id'));
				if($dataExist['taxclass_id']==""){
					$result = $this->settings_model->update_tax($data,$this->input->post('taxclass_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Tax name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_tax_data($id);
				$data['row']=$row;
				$data['view'] = 'tax/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_tax_data($id);
			//print_r($row);
			if($row==""){
				redirect('tax/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='tax/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
