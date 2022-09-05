<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('customer_model', 'customer_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}
	
	
	
	public function profile($id = 0){
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$row = $this->customer_model->get_customer_data($id);
			//print_r($row);
			if($row==""){
				redirect('customer/index');
				exit;
			}
			$data['row']=$row;
		
		
		$data['view']='customer/profile';
		$this->load->view('layout',$data);
	}
	public function index(){
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		$results = $this->customer_model->get_all_customers();
		//print_r($results);
		$data['results']=$results;
		$data['view']='customer/index';
		$this->load->view('layout',$data);
	}
	
	public function add_old(){
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			
			$this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required');
			$this->form_validation->set_rules('customer_email', 'Customer email', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['view']='customer/add';
				$this->load->view('layout', $data);
			}else{

				$data = array(
					'customer_name' => $this->input->post('customer_name'),
					'customer_email' => $this->input->post('customer_email'),
					'customer_mobile_no' => $this->input->post('customer_mobile_no'),
					'customer_address' => $this->input->post('customer_address'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'customer_c_by' => $this->session->has_userdata('loginid'),
					'customer_c_date' =>date('Y-m-d'),
					'customer_status' => '1'
				);
				
				$dataExist = $this->customer_model->check_customer_email_exist($data,'');
				if($dataExist['customer_id']==""){
					$staffid = $this->customer_model->insert_customer_data($data);
					$this->session->set_flashdata('success','Customer ('.$staffid.') created  successfully');
					redirect('customer/index');
				}else{
					$this->session->set_flashdata('error', 'Customer email already exists...!');
					$data['view']='customer/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['view']='customer/add';
			$this->load->view('layout',$data);
		}
	}


	public function edit($id = 0){
		$accessArray=$this->rbac->check_operation_access(); // check opration permission
		  if($accessArray==""){
			  redirect('access/not_found');
		  }else{
			  if($accessArray){if(!in_array("edit",$accessArray)){
			  redirect('access/access_denied');
			  }}
		  }
		//$accessArray=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
		$data['title_head']=$accessArray['menu_name'];
		
		if($this->input->post('submit')){
			
			$this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required');
			$this->form_validation->set_rules('customer_email', 'Customer email', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
				$data['title_head']=$accessArray['menu_name'];
				$data['view'] = 'customer/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'customer_name' => $this->input->post('customer_name'),
					'customer_email' => $this->input->post('customer_email'),
					'customer_mobile_no' => $this->input->post('customer_mobile_no'),
					'customer_address' => $this->input->post('customer_address'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city')
				);
				//print_r($data);
				$dataExist = $this->customer_model->check_customer_mobile_exist($data,$this->input->post('customer_id'));
				//print_r($dataExist);
				//exit;
				if($dataExist['customer_id']==""){
					
					$result = $this->customer_model->update_customer_data($data,$this->input->post('customer_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
												
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Customer already exists with mobile number...!');
				}
				$data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
				$data['title_head']=$accessArray['menu_name'];
				$row = $this->customer_model->get_customer_data($id);
				$data['row']=$row;
				$data['view'] = 'customer/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$row = $this->customer_model->get_customer_data($id);
			//print_r($row);
			if($row==""){
				redirect('customer/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='customer/edit';
			$this->load->view('layout',$data);
		}
	}
	function delete_old($uuid='')
	{   
		$this->rbac->check_operation_access(); // check opration permission
		$this->customer_model->delete_customer_data($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('customer/index');
	}

	
}
