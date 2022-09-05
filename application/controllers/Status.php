<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {
	
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
		//$this->rbac->check_operation_access(); // check opration permission
		$this->settings_model->delete_status($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('status/index');
	}

	public function index(){
		$data['title']="Basic Settings | Work Status";
		$data['title_head']="Work Status";
		$results = $this->settings_model->get_all_status();
		//print_r($results);
		$data['results']=$results;
		$data['view']='status/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('status_name', 'Status NAme', 'trim|required');
			$this->form_validation->set_rules('status_color_code', 'Status Color Code', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']="Basic Settings |  Work Status";
				$data['title_head']=" Work Status";
				
				$data['view']='status/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'status_name' => $this->input->post('status_name'),
					'status_color_code' => $this->input->post('status_color_code'),
					'status_c_by' => $this->session->has_userdata('loginid'),
					'status_c_date' =>date('Y-m-d'),
					'status_of_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_status_exist($data,'');
				if($dataExist['status_id']==""){
					$result = $this->settings_model->insert_status($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('status/index');
				}else{
					$data['title']="Basic Settings |  Work Status";
					$data['title_head']=" Work Status";
					$this->session->set_flashdata('error', 'Status name already exists...!');
					$data['view']='status/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['title']="Basic Settings | Work Status";
			$data['title_head']="Work Status";
			$data['view']='status/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('status_name', 'Status NAme', 'trim|required');
			$this->form_validation->set_rules('status_color_code', 'Status Color Code', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']="Basic Settings | Work Status";
				$data['title_head']="Work Status";
				$data['row']= $this->settings_model->get_status_data($id);
				$data['view'] = 'status/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'status_name' => $this->input->post('status_name'),
					'status_color_code' => $this->input->post('status_color_code'),
					'status_c_by' => $this->session->has_userdata('loginid'),
					'status_c_date' =>date('Y-m-d'),
					'status_of_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_status_exist($data,$this->input->post('status_id'));
				if($dataExist['status_id']==""){
					$result = $this->settings_model->update_status($data,$this->input->post('status_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Location name already exists...!');
				}
				
				
				$data['title']="Basic Settings | Work Status";
				$data['title_head']="Work Status";
				$row = $this->settings_model->get_status_data($id);
				$data['row']=$row;
				$data['view'] = 'status/edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$data['title']="Basic Settings | Work Status";
			$data['title_head']="Work Status";
			$row = $this->settings_model->get_status_data($id);
			//print_r($row);
			if($row==""){
				redirect('status/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='status/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
