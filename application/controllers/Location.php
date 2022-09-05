<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('settings_model', 'settings_model');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		
	}

	function states_ajax($lid='')
	{   
		//$this->rbac->check_operation_access(); // check opration permission
		$results=$this->settings_model->get_states_by_country($lid);
		echo json_encode($results);
	}
	function delete($uuid='')
	{   
		//$this->rbac->check_operation_access(); // check opration permission
		$this->settings_model->delete_location($uuid);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('location/index');
	}

	public function index(){
		$data['title']="Basic Settings | Locations";
		$data['title_head']="Locations";
		$results = $this->settings_model->get_all_locations();
		//print_r($results);
		$data['results']=$results;
		$data['view']='location/index';
		$this->load->view('layout',$data);
	}
	
	public function add(){
		//echo $id;
		if($this->input->post('submit')){
			$this->form_validation->set_rules('location_country_id', 'Country', 'trim|required');
			$this->form_validation->set_rules('location_state_id', 'State', 'trim|required');
			$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['title']="Basic Settings | Locations";
				$data['title_head']="Locations";
				$data['countries']=$this->settings_model->get_all_countries();
				$data['view']='location/add';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'location_country_id' => $this->input->post('location_country_id'),
					'location_state_id' => $this->input->post('location_state_id'),
					'location_name' => $this->input->post('location_name'),
					'location_c_by' => $this->session->has_userdata('loginid'),
					'location_c_date' =>date('Y-m-d'),
					'location_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_location_exist($data,'');
				if($dataExist['location_id']==""){
					$result = $this->settings_model->insert_location($data);
					if($result){
						$this->session->set_flashdata('success','Saved successfully');
					}else{
						$this->session->set_flashdata('error', 'Something wrong...!');
					}
					redirect('location/index');
				}else{
					$data['title']="Basic Settings | Locations";
					$data['title_head']="Locations";
					$data['countries']=$this->settings_model->get_all_countries();
					$this->session->set_flashdata('error', 'Location name already exists...!');
					$data['view']='location/add';
					$this->load->view('layout',$data);
				}
			}
		}else{
			$data['title']="Basic Settings | Locations";
			$data['title_head']="Locations";
			$data['countries']=$this->settings_model->get_all_countries();
			$data['view']='location/add';
			$this->load->view('layout',$data);
		}
	}
	
	public function edit($id = 0){
		//echo $id;
		
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('location_country_id', 'Country', 'trim|required');
			$this->form_validation->set_rules('location_state_id', 'State', 'trim|required');
			$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				
				$data['title']="Basic Settings | Locations";
				$data['title_head']="Locations";
				$data['countries']=$this->settings_model->get_all_countries();
				$data['states']=$this->settings_model->get_states_by_country($row['location_country_id']);
				$data['row']= $this->settings_model->get_location_data($id);
				$data['view'] = 'location/edit';
				$this->load->view('layout', $data);
			}else{
				
				$data = array(
					'location_country_id' => $this->input->post('location_country_id'),
					'location_state_id' => $this->input->post('location_state_id'),
					'location_name' => $this->input->post('location_name'),
					'location_c_by' => $this->session->has_userdata('loginid'),
					'location_c_date' =>date('Y-m-d'),
					'location_status' => '1'
				);
				
				$dataExist = $this->settings_model->check_location_exist($data,$this->input->post('location_id'));
				if($dataExist['location_id']==""){
				
					$result = $this->settings_model->update_location($data,$this->input->post('location_id'));
					if($result){
						$this->session->set_flashdata('success1','Saved successfully');
					}else{
						$this->session->set_flashdata('error1', 'Something wrong...!');
					}
					
				}else{
					$this->session->set_flashdata('error1', 'Location name already exists...!');
				}
				
				
				$data['title']="Basic Settings | Locations";
				$data['title_head']="Locations";
				$row = $this->settings_model->get_location_data($id);
				$data['countries']=$this->settings_model->get_all_countries();
				$data['states']=$this->settings_model->get_states_by_country($row['location_country_id']);
				$data['row']=$row;
				$data['view'] = 'location/edit';
				$this->load->view('layout', $data);
			}
		}else{
		
			$data['title']="Basic Settings | Locations";
			$data['title_head']="Locations";
			$row = $this->settings_model->get_location_data($id);
			//print_r($row);
			if($row==""){
				redirect('location/index');
				exit;
			}
			$data['countries']=$this->settings_model->get_all_countries();
			$data['states']=$this->settings_model->get_states_by_country($row['location_country_id']);
			$data['row']=$row;
			$data['view']='location/edit';
			
			$this->load->view('layout',$data);
		}
	}
	

	
}
