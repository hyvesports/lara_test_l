<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping extends CI_Controller {
	
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
		$this->rbac->check_operation_access(); // check opration permission
		$this->settings_model->delete_shipping($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('shipping/index');
	}

	public function index(){
		$moduleData=$this->rbac->check_operation_access();
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_shippings();
		//print_r($results);
		$data['results']=$results;
		$data['view']='shipping/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		$moduleData=$this->rbac->check_operation_access();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('shipping_mode_name', 'Shipping mode', 'trim|required');
			$this->form_validation->set_rules('shipping_mode_desc', 'Shipping mode description', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='shipping/add';
				$this->load->view('layout', $data);
			}else{
				$data = array(
					'shipping_mode_name' => $this->input->post('shipping_mode_name'),
					'shipping_mode_desc' => $this->input->post('shipping_mode_desc'),
					'shipping_mode_status' =>1
				);
				$dataExist = $this->settings_model->check_shipping_exist($data,'');
				if($dataExist['shipping_mode_id']==""){
					$result = $this->settings_model->insert_shipping($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('shipping/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Shipping method already exists...!');
					$data['view']='shipping/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$data['view']='shipping/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access();
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('shipping_mode_name', 'Shipping mode', 'trim|required');
			$this->form_validation->set_rules('shipping_mode_desc', 'Shipping mode description', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['row']= $this->settings_model->get_shipping_data($id);
				$data['view'] = 'shipping/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'shipping_mode_name' => $this->input->post('shipping_mode_name'),
					'shipping_mode_desc' => $this->input->post('shipping_mode_desc')
				);
				
				$dataExist = $this->settings_model->check_shipping_exist($data,$this->input->post('shipping_mode_id'));
				if($dataExist['shipping_mode_id']==""){
					$result = $this->settings_model->update_shipping($data,$this->input->post('shipping_mode_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Shipping mode already exists...!');
				}
				
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
			
				$row = $this->settings_model->get_shipping_data($id);
				$data['row']=$row;
				$data['view'] = 'shipping/edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_shipping_data($id);
			//print_r($row);
			if($row==""){
				redirect('shipping/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='shipping/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
