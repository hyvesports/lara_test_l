<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadstage extends CI_Controller {
	
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
		$this->settings_model->delete_lead_stage($id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('leadstage/index');
	}

	public function index(){
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		$results = $this->settings_model->get_all_lead_stages();
		//print_r($results);
		$data['results']=$results;
		$data['view']='leadstage/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		
		$moduleData=$this->rbac->check_operation_access(); // check opration permission
		$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
		$data['title_head']=$moduleData['menu_name'];
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('lead_stage_name', 'Stage Name', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['view']='leadstage/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'lead_stage_name' => $this->input->post('lead_stage_name'),
					'lead_stage_status' =>$this->input->post('lead_stage_status')
				);
				
				$dataExist = $this->settings_model->check_lead_stage_exist($data,'');
				if($dataExist['lead_stage_id']==""){
					$result = $this->settings_model->insert_lead_stage($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('leadstage/index');
				}else{
					$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
					$data['title_head']=$moduleData['menu_name'];
					$this->session->set_flashdata('error', 'Stage name already exists...!');
					$data['view']='leadstage/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
		
			$data['view']='leadstage/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		 // check opration permission
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('lead_stage_name', 'Stage name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$data['row']= $this->settings_model->get_lead_stage_data($id);
				$data['view'] = 'leadstage/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'lead_stage_name' => $this->input->post('lead_stage_name'),
					'lead_stage_status' =>$this->input->post('lead_stage_status')
				);
				
				$dataExist = $this->settings_model->check_lead_stage_exist($data,$this->input->post('lead_stage_id'));
				if($dataExist['lead_stage_id']==""){
					$result = $this->settings_model->update_lead_stage($data,$this->input->post('lead_stage_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Stage name already exists...!');
				}
				
				$moduleData=$this->rbac->check_operation_access();
				$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
				$data['title_head']=$moduleData['menu_name'];
				$row = $this->settings_model->get_lead_stage_data($id);
				$data['row']=$row;
				$data['view'] = 'leadstage/edit';
				$this->load->view('layout', $data);
			}
		}else{
			$moduleData=$this->rbac->check_operation_access();
			$data['title']=$moduleData['module_parent']." | ".$moduleData['menu_name'];
			$data['title_head']=$moduleData['menu_name'];
			$row = $this->settings_model->get_lead_stage_data($id);
			//print_r($row);
			if($row==""){
				redirect('leadstage/index');
				exit;
			}
			$data['row']=$row;
			$data['view']='leadstage/edit';
			$this->load->view('layout',$data);
		}
	}
	

	
}
