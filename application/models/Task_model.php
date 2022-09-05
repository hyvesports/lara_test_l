<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Task_model extends CI_Model{

	public function get_my_previous_tasks($login_id){
		//$current_date=date('Y-m-d');
		$current_date=date('Y-m-d', strtotime(' -1 day'));
			$wh =array();
			$SQL='SELECT 
				tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email
			FROM
				tasks 
			left join leads_master on leads_master.lead_id=tasks.lead_id
			LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id ';
			//echo $SQL;
			$wh[] = 'tasks.task_owner_id ="'.$login_id.'"  and tasks.reminder_date="'.$current_date.'"';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	
	public function get_my_next_tasks($login_id){
		//$current_date=date('Y-m-d');
		$current_date=date('Y-m-d', strtotime(' +1 day'));
			$wh =array();
			$SQL='SELECT 
				tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email
			FROM
				tasks 
			left join leads_master on leads_master.lead_id=tasks.lead_id
			LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id ';
			//echo $SQL;
			$wh[] = 'tasks.task_owner_id ="'.$login_id.'"  and tasks.reminder_date="'.$current_date.'"';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	
	public function get_my_today_tasks($login_id){
		$current_date=date('Y-m-d');
		//$nxt_date=date('Y-m-d', strtotime(' +1 day'));
			$wh =array();
			$SQL='SELECT 
				tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email
			FROM
				tasks 
			left join leads_master on leads_master.lead_id=tasks.lead_id
			LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id ';
			//echo $SQL;
			$wh[] = 'tasks.task_owner_id ="'.$login_id.'"  and tasks.reminder_date="'.$current_date.'"';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_my_all_tasks($login_id){
		//$current_date=date('Y-m-d');
		//$nxt_date=date('Y-m-d', strtotime(' +1 day'));
			$wh =array();
			$SQL='SELECT 
				tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email
			FROM
				tasks 
			left join leads_master on leads_master.lead_id=tasks.lead_id
			LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id ';
			//echo $SQL;
			$wh[] = 'tasks.task_owner_id ="'.$login_id.'" ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}

	

	public function delete_task_data($uuid){

		$this->db->where('task_uuid',$uuid);

		$this->db->delete('tasks');

		return true;

	}



	public function update_task_data($data, $task_id){

		$this->db->where('task_id', $task_id);

		$this->db->update('tasks', $data);

		return true;

	}

	public function get_my_task_by_uuid($task_uuid){

			$sql="Select * from tasks WHERE task_uuid='$task_uuid' ";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}



	public function get_my_tasks($lead_id,$task_owner_id){

			$sql="Select * from tasks WHERE lead_id='$lead_id' and task_owner_id='$task_owner_id' ORDER BY task_id DESC";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	

	public function insert_task_data($data){

		$this->db->set('task_uuid', 'UUID()', FALSE);

		$this->db->insert('tasks', $data);

		$insert_id = $this->db->insert_id();

		return true;

	}

	//____________________end of leads



	

}

?>