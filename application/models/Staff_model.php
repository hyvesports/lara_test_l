<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Staff_model extends CI_Model{

	
	public function delete_staff_login_data($login_master_id){
		$this->db->where('login_master_id',$login_master_id);
		$this->db->delete('login_master');
		return true;
	}
	public function check_access($staff_login_id,$main_module_id,$sub_module_id,$permission_operation){

			//print_r($data);

			//$staff_code=$data['staff_code'];

			$sql="Select staff_permission_id from staff_permissions WHERE staff_login_id='$staff_login_id' AND main_module_id='$main_module_id' AND sub_module_id='$sub_module_id' AND permission_operation='$permission_operation' ";   

			//echo $sql;exit;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	//-----------------------------------------------------

	function set_access()

	{

		if($this->input->post('status')==1)

		{

			$this->db->set('staff_login_id',$this->input->post('staff_login_id'));

			$this->db->set('main_module_id',$this->input->post('main_module_id'));

			$this->db->set('sub_module_id',$this->input->post('sub_module_id'));

			$this->db->set('permission_module',$this->input->post('permission_module'));

			$this->db->set('permission_operation',$this->input->post('permission_operation'));

			$this->db->insert('staff_permissions');

		}

		else

		{

			$this->db->where('staff_login_id',$this->input->post('staff_login_id'));

			$this->db->where('main_module_id',$this->input->post('main_module_id'));

			$this->db->where('sub_module_id',$this->input->post('sub_module_id'));

			$this->db->where('permission_module',$this->input->post('permission_module'));

			$this->db->where('permission_operation',$this->input->post('permission_operation'));

			$this->db->delete('staff_permissions');

		}

	}

	

	//-----------------------------------------------------

	public function get_staffdata_by_staff_id($staff_id){

			//print_r($data);

			//$staff_code=$data['staff_code'];

			$sql="Select * from staff_master WHERE staff_id='$staff_id' LIMIT 1";   

			//echo $sql;exit;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function get_staffdata_by_id($staff_code){

			//print_r($data);

			//$staff_code=$data['staff_code'];

			$sql="Select * from staff_master WHERE staff_code='$staff_code' LIMIT 1";   

			//echo $sql;exit;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	

	

	public function check_staffdata_exist($staff_code){

			//print_r($data);

			//$staff_code=$data['staff_code'];

			$sql="Select * from staff_master WHERE staff_code='$staff_code' LIMIT 1";   

			//echo $sql;exit;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function delete_staff_data($uuid){
		$this->db->where('staff_uuid',$uuid);
		$this->db->delete('staff_master');
		return true;
	}

	public function update_login_data($data, $id){
		$this->db->where('login_master_id', $id);
		$this->db->update('login_master', $data);
		return true;
	}

	public function update_staff_data($data, $id){

		$this->db->where('staff_id', $id);

		$this->db->update('staff_master', $data);

		return true;

	}

	

	public function get_staff_data($uuid){

			$this->db->select('staff_master.*,department_master.department_name,designation_master.designation_name,location_master.location_name,login_master.log_full_name,login_master.log_email,login_master.log_phone_number,login_master.login_master_id');

	    	$this->db->from('staff_master');

			$this->db->join('department_master', 'department_master.department_id = staff_master.department_id', 'Left');

			$this->db->join('designation_master', 'designation_master.designation_id = staff_master.designation_id', 'Left');

			$this->db->join('location_master', 'location_master.location_id = staff_master.location_id', 'Left');

			$this->db->join('login_master', 'login_master.login_master_id = staff_master.login_id', 'Left');

			$this->db->where('staff_uuid',$uuid);

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	

	public function get_all_staffs(){

			$this->db->select('staff_master.*,department_master.department_name,designation_master.designation_name,location_master.location_name,login_master.log_username,login_master.login_master_id');

	    	$this->db->from('staff_master');

			$this->db->join('department_master', 'department_master.department_id = staff_master.department_id', 'Left');

			$this->db->join('designation_master', 'designation_master.designation_id = staff_master.designation_id', 'Left');

			$this->db->join('location_master', 'location_master.location_id = staff_master.location_id', 'Left');

			$this->db->join('login_master', 'login_master.login_master_id= staff_master.login_id', 'Left');

			$this->db->order_by("staff_master.staff_id", "DESC");

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function insert_staff_data($data,$login_master_id){

		$this->db->set('staff_uuid', 'UUID()', FALSE);

		$this->db->set('login_id', $login_master_id, FALSE);

		$this->db->insert('staff_master', $data);

		//$insert_id = $this->db->insert_id();

		return true;

	}

	public function insert_login_data($data){

		$this->db->set('log_uuid', 'UUID()', FALSE);

		$this->db->insert('login_master', $data);

		$insert_id = $this->db->insert_id();

		return $insert_id;

	}

	

	

	public function check_staff_logid_exist($data,$condition){

			//print_r($data);

			$log_username=$data['log_username'];

			$this->db->select('login_master.*');

	    	$this->db->from('login_master');

			$this->db->where('log_username',$log_username);

			if($condition!=""){

			$this->db->where('login_master_id!=',$condition);

			}

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	

	public function check_staffcode_exist($data,$condition){

			//print_r($data);

			$staff_code=$data['staff_code'];

			$this->db->select('staff_master.*');

	    	$this->db->from('staff_master');

			$this->db->where('staff_code',$staff_code);

			if($condition!=""){

			$this->db->where('staff_id!=',$condition);

			}

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function check_username_exist($data,$condition){

			//print_r($data);

			$log_username=$data['log_username'];

			$this->db->select('login_master.*');

	    	$this->db->from('login_master');

			$this->db->where('log_username',$log_username);

			if($condition!=""){

			$this->db->where('login_master_id!=',$condition);

			}

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	

	

	//____________________end of staff___



	

}

?>