<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producttype extends CI_Controller {
	
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
		$this->settings_model->delete_producttype($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('producttype/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_producttypes();
		//print_r($results);
		$data['results']=$results;
		$data['view']='producttype/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('product_type_name', 'Product Type Name', 'trim|required');
			$this->form_validation->set_rules('product_type_amount', 'Product Amount', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='producttype/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'product_type_name' => $this->input->post('product_type_name'),
					'product_type_amount' => $this->input->post('product_type_amount'),
					'product_making_time' => $this->input->post('product_making_time'),
					'product_type_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_producttype_exist($data,'');
				if($dataExist['product_type_id ']==""){
					$result = $this->settings_model->insert_producttype($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('producttype/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Product type name already exists...!');
					$data['view']='producttype/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='producttype/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('product_type_name', 'Product Type Name', 'trim|required');
			$this->form_validation->set_rules('product_type_amount', 'Product Amount', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				
				$data['row']= $this->settings_model->get_producttype_data($id);
				$data['view'] = 'producttype/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'product_type_name' => $this->input->post('product_type_name'),
					'product_making_time' => $this->input->post('product_making_time'),
					'product_type_amount' => $this->input->post('product_type_amount')
				);
				
				$dataExist = $this->settings_model->check_producttype_exist($data,$this->input->post('product_type_id'));
				if($dataExist['product_type_id']==""){
					$result = $this->settings_model->update_producttype($data,$this->input->post('product_type_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Product type name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_producttype_data($id);
				$data['row']=$row;
				$data['view'] = 'producttype/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_producttype_data($id);
			//print_r($row);
			if($row==""){
				redirect('producttype/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='producttype/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
