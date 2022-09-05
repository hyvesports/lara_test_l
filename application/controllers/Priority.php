<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Priority extends CI_Controller {
	
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
		$this->settings_model->delete_priority($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('priority/index');
	}

	public function index(){
		$data['title']="Basic Settings | Work Priority";
		$data['title_head']="Work Priority";
		$results = $this->settings_model->get_all_priority();
		//print_r($results);
		$data['results']=$results;
		$data['view']='priority/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('priority_name', 'Priority Name', 'trim|required');
			$this->form_validation->set_rules('priority_color_code', 'Priority Color Code', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				//echo '44';
				//echo validation_errors();
				$data['title']="Basic Settings |  Work Priority";
				$data['title_head']=" Work Priority";
				
				$data['view']='priority/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'priority_name' => $this->input->post('priority_name'),
					'priority_color_code' => $this->input->post('priority_color_code'),
					'priority_c_by' => $this->session->has_userdata('loginid'),
					'priority_c_date' =>date('Y-m-d'),
					'priority_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_priority_exist($data,'');
				if($dataExist['priority_id']==""){
					$result = $this->settings_model->insert_priority($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('priority/index');
				}else{
					$data['title']="Basic Settings |  Work Priority";
					$data['title_head']=" Work Priority";
					$this->session->set_flashdata('error', 'Priority name already exists...!');
					$data['view']='priority/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['title']="Basic Settings | Work Priority";
			$data['title_head']="Work Priority";
			$data['view']='priority/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('priority_name', 'Priority Name', 'trim|required');
			$this->form_validation->set_rules('priority_color_code', 'Priority Color Code', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']="Basic Settings | Work Priority";
				$data['title_head']="Work Priority";
				$data['row']= $this->settings_model->get_priority_data($id);
				$data['view'] = 'priority/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'priority_name' => $this->input->post('priority_name'),
					'priority_color_code' => $this->input->post('priority_color_code')
				);
				
				$dataExist = $this->settings_model->check_priority_exist($data,$this->input->post('priority_id'));
				if($dataExist['priority_id']==""){
					$result = $this->settings_model->update_priority($data,$this->input->post('priority_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Priority name already exists...!');
				}
				
				
				$data['title']="Basic Settings | Work Priority";
				$data['title_head']="Work Priority";
				$row = $this->settings_model->get_priority_data($id);
				$data['row']=$row;
				$data['view'] = 'priority/edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$data['title']="Basic Settings | Work Priority";
			$data['title_head']="Work Priority";
			$row = $this->settings_model->get_priority_data($id);
			//print_r($row);
			if($row==""){
				redirect('priority/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='priority/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
