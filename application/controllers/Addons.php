<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addons extends CI_Controller {
	
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
		$this->settings_model->delete_addons($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('addons/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_addonss();
		//print_r($results);
		$data['results']=$results;
		$data['view']='addons/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('addon_name', 'Add-On Name', 'trim|required');
			$this->form_validation->set_rules('addon_amount', 'Add-On Amount', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='addons/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'addon_name' => $this->input->post('addon_name'),
					'addon_amount' => $this->input->post('addon_amount'),
					'addon_desc' => $this->input->post('addon_desc'),
					'addon_making_min' => $this->input->post('addon_making_min'),
					'addon_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_addons_exist($data,'');
				if($dataExist['addon_id']==""){
					$result = $this->settings_model->insert_addons($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('addons/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Add-on name already exists...!');
					$data['view']='addons/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='addons/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('addon_name', 'Add-On Name', 'trim|required');
			$this->form_validation->set_rules('addon_amount', 'Add-On Amount', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_addons_data($id);
				$data['view'] = 'addons/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'addon_name' => $this->input->post('addon_name'),
					'addon_amount' => $this->input->post('addon_amount'),
					'addon_desc' => $this->input->post('addon_desc'),
					'addon_making_min' => $this->input->post('addon_making_min'),
				);
				
				$dataExist = $this->settings_model->check_addons_exist($data,$this->input->post('addon_id'));
				if($dataExist['addon_id']==""){
					$result = $this->settings_model->update_addons($data,$this->input->post('addon_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Add-on name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_addons_data($id);
				$data['row']=$row;
				$data['view'] = 'addons/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_addons_data($id);
			//print_r($row);
			if($row==""){
				redirect('addons/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='addons/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
