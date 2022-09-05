<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model{
	public function update_log_session($login_master_id){
	$up="UPDATE login_master SET current_log_session=UUID() WHERE login_master_id='$login_master_id'";
	$query = $this->db->query($up);
	return true;
	}

	public function get_staff_info($login_id){
		$sql="Select staff_master.staff_id,department_master.department_parent FROM staff_master 
		LEFT JOIN department_master ON department_master.department_id=staff_master.department_id
		WHERE staff_master.login_id='$login_id' limit 1";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}

	public function check_any_task($login_id){
		$current_date=date('Y-m-d');
		$nxt_date=date('Y-m-d', strtotime(' +1 day'));
		$sql="Select tasks.task_id FROM tasks WHERE tasks.task_owner_id='$login_id' limit 1";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}

	

	public function get_staff_bio_data($login_id){

			$sql="SELECT 

				CONCAT(SM.staff_code,'-',SM.staff_name) as bio_person,CONCAT(DM.designation_name,',',DPM.department_name) as bio_role

			FROM 

				staff_master as SM

				LEFT JOIN designation_master as DM on DM.designation_id=SM.designation_id

				LEFT JOIN department_master as DPM on DPM.department_id=SM.department_id 

			WHERE 

				SM.login_id='$login_id' ";   

			//echo $sql;

			$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function get_staff_bio_data_by_staff_id($staff_id){

			$sql="SELECT 

				CONCAT(SM.staff_code,'-',SM.staff_name) as bio_person,CONCAT(DM.designation_name,',',DPM.department_name) as bio_role

			FROM 

				staff_master as SM

				LEFT JOIN designation_master as DM on DM.designation_id=SM.designation_id

				LEFT JOIN department_master as DPM on DPM.department_id=SM.department_id 

			WHERE 

				SM.staff_id='$staff_id' ";   

			//echo $sql;

			$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function get_staff_profile_data($login_id){

			$sql="SELECT * FROM staff_master WHERE login_id='$login_id' ";   

			//echo $sql;

			$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	public function staff_sub_menu_master_data($main_module_id){

			$sql="SELECT DISTINCT menu_master.* FROM staff_permissions LEFT JOIN menu_master ON menu_master.menu_master_id=staff_permissions.sub_module_id WHERE main_module_id='$main_module_id' AND staff_login_id='".$this->session->userdata('loginid')."' ";   

			

			//echo $sql;

			$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	

	public function staff_menu_master_data($staff_login_id){

			$sql="SELECT DISTINCT menu_master.* FROM staff_permissions LEFT JOIN menu_master ON menu_master.menu_master_id=staff_permissions.main_module_id WHERE staff_login_id='$staff_login_id'  ";   

			$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	public function update_new_password($data,$login_master_id){

    	$this->db->where('login_master_id', $login_master_id);

    	$this->db->update('login_master', $data);

    }

	public function check_password_is_correct($login_master_id,$log_password){

	    	$this->db->from('login_master');

			$this->db->where('login_master.login_master_id', $login_master_id);

			$this->db->where('login_master.log_password', $log_password);

	    	$query = $this->db->get();	

			//echo $this->db->last_query();;

			return $query->row_array();

	}

	public function random_password() {

		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

		$password = array(); 

		$alpha_length = strlen($alphabet) - 1; 

		for ($i = 0; $i < 6; $i++) 

		{

			$n = rand(0, $alpha_length);

			$password[] = $alphabet[$n];

		}

		return implode($password); 

	}

		

	public function menu_master_data($parent){

	    	$this->db->from('menu_master');

	    	$this->db->where('menu_master.menu_status', '1');

			$this->db->where('menu_master.menu_parent', $parent);

			$this->db->order_by("menu_order", "desc");

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	

	public function login($data){
		$this->db->from('login_master');
		$this->db->join('user_roles','user_roles.role_id = login_master.user_role_id');
		$this->db->where('login_master.log_username', $data['log_username']);
		$this->db->where('login_master.log_password', $data['log_password']);
		$query = $this->db->get();
		if ($query->num_rows() == 0){
			return false;
		}
		else{
			//Compare the password attempt with the password we have stored.
			  return $result = $query->row_array();
		}

	}



	//---------------------------------- end of work----------------------------------

	public function register($data){

		$this->db->insert('ci_admin', $data);

		return true;

	}



	//--------------------------------------------------------------------

	public function email_verification($code){

		$this->db->select('email, token, is_active');

		$this->db->from('ci_admin');

		$this->db->where('token', $code);

		$query = $this->db->get();

		$result= $query->result_array();

		$match = count($result);

		if($match > 0){

			$this->db->where('token', $code);

			$this->db->update('ci_admin', array('is_verify' => 1, 'token'=> ''));

			return true;

		}

		else{

			return false;

			}

	}



	//============ Check User Email ============

    function check_user_mail($email)

    {

    	$result = $this->db->get_where('ci_admin', array('email' => $email));



    	if($result->num_rows() > 0){

    		$result = $result->row_array();

    		return $result;

    	}

    	else {

    		return false;

    	}

    }



    //============ Update Reset Code Function ===================

    public function update_reset_code($reset_code, $user_id){

    	$data = array('password_reset_code' => $reset_code);

    	$this->db->where('admin_id', $user_id);

    	$this->db->update('ci_admin', $data);

    }



    //============ Activation code for Password Reset Function ===================

    public function check_password_reset_code($code){



    	$result = $this->db->get_where('ci_admin',  array('password_reset_code' => $code ));

    	if($result->num_rows() > 0){

    		return true;

    	}

    	else{

    		return false;

    	}

    }

    

    //============ Reset Password ===================

    public function reset_password($id, $new_password){

	    $data = array(

			'password_reset_code' => '',

			'password' => $new_password

	    );

		$this->db->where('password_reset_code', $id);

		$this->db->update('ci_admin', $data);

		return true;

    }



    //--------------------------------------------------------------------

	public function get_admin_detail(){

		$id = $this->session->userdata('admin_id');

		$query = $this->db->get_where('ci_admin', array('admin_id' => $id));

		return $result = $query->row_array();

	}



	//--------------------------------------------------------------------

	public function update_admin($data){

		$id = $this->session->userdata('admin_id');

		$this->db->where('admin_id', $id);

		$this->db->update('ci_admin', $data);

		return true;

	}



	//--------------------------------------------------------------------

	public function change_pwd($data, $id){

		$this->db->where('admin_id', $id);

		$this->db->update('ci_admin', $data);

		return true;

	}



}



?>