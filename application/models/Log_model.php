<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model{
	
	//check_priority_exist 
	
	public function get_my_logs($log_updated_by){    // and FIND_IN_SET(".$log_updated_by.",log_master.log_viewed)
    	$sql="SELECT
			*,staff_master.staff_code,staff_master.staff_name 
		FROM log_master
			LEFT JOIN staff_master ON staff_master.staff_id = log_master.log_updated_by
		WHERE 
			log_updated_by='$log_updated_by' order by log_master_id desc limit 10";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	public function get_my_logs_count($log_updated_by){    
    	$sql="SELECT * FROM log_master WHERE log_updated_by='$log_updated_by' and !FIND_IN_SET(".$log_updated_by.",log_master.log_viewed) order by log_master_id desc ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	public function insert_log_data($data){
		
		date_default_timezone_set('Asia/Kolkata'); # add your city to set local time zone
		$now = date('d-m-Y H:i');
		//$this->db->set('log_timestamp', $now, FALSE);
		$this->db->insert('log_master', $data);
		$insert_id = $this->db->insert_id();
		
		$dataup = [
            'log_timestamp' =>$now,
        ];
		$this->db->where('log_master_id', $insert_id);
        $this->db->update('log_master', $dataup);
		
		return true;
	}
	//____________________end of leads Lead updated  social media, successfully

	
}
?>