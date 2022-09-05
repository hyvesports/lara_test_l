<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sleevetype extends CI_Controller {
	
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
		$this->settings_model->delete_sleevetype($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('sleevetype/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_sleevetypes();
		//print_r($results);
		$data['results']=$results;
		$data['view']='sleevetype/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('sleeve_type_name', 'Sleeve Type Name', 'trim|required');
			$this->form_validation->set_rules('sleeve_type_amount', 'Sleeve Amount', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='sleevetype/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'sleeve_type_name' => $this->input->post('sleeve_type_name'),
					'sleeve_type_amount' => $this->input->post('sleeve_type_amount'),
					'sleeve_making_time' => $this->input->post('sleeve_making_time'),
					'sleeve_type_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_sleevetype_exist($data,'');
				if($dataExist['sleeve_type_id']==""){
					$result = $this->settings_model->insert_sleevetype($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('sleevetype/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Sleeve type name already exists...!');
					$data['view']='sleevetype/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='sleevetype/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('sleeve_type_name', 'Sleeve Type Name', 'trim|required');
			$this->form_validation->set_rules('sleeve_type_amount', 'Sleeve Amount', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_sleevetype_data($id);
				$data['view'] = 'sleevetype/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'sleeve_type_name' => $this->input->post('sleeve_type_name'),
					'sleeve_making_time' => $this->input->post('sleeve_making_time'),
					'sleeve_type_amount' => $this->input->post('sleeve_type_amount')
				);
				
				$dataExist = $this->settings_model->check_sleevetype_exist($data,$this->input->post('sleeve_type_id'));
				if($dataExist['sleeve_type_id']==""){
					$result = $this->settings_model->update_sleevetype($data,$this->input->post('sleeve_type_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Sleeve type name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_sleevetype_data($id);
				$data['row']=$row;
				$data['view'] = 'sleevetype/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_sleevetype_data($id);
			//print_r($row);
			if($row==""){
				redirect('sleevetype/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='sleevetype/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
