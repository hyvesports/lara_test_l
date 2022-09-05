<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productsize extends CI_Controller {
	
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
		$this->settings_model->delete_productsize($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('productsize/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		$results = $this->settings_model->get_all_product_size();
		//print_r($results);
		$data['results']=$results;
		$data['view']='productsize/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('product_size_name', 'Product size', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='productsize/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'product_size_name' => $this->input->post('product_size_name'),
					'product_size_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_productsize_exist($data,'');
				if($dataExist['product_size_id']==""){
					$result = $this->settings_model->insert_productsize($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('productsize/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Product size already exists...!');
					$data['view']='productsize/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='productsize/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('product_size_name', 'Product size', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_productsize_data($id);
				$data['view'] = 'productsize/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'product_size_name' => $this->input->post('product_size_name')
				);
				
				$dataExist = $this->settings_model->check_productsize_exist($data,$this->input->post('product_size_id'));
				if($dataExist['product_size_id']==""){
					$result = $this->settings_model->update_productsize($data,$this->input->post('product_size_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Product size already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_productsize_data($id);
				$data['row']=$row;
				$data['view'] = 'productsize/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_productsize_data($id);
			//print_r($row);
			if($row==""){
				redirect('productsize/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='productsize/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
