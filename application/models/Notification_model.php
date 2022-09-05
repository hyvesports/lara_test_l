<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model{
	//
	public function get_wo_info($order_id){
		$sql="SELECT wo_work_orders.* FROM wo_work_orders WHERE order_id='$order_id' ";
		$query = $this->db->query($sql);					 
		return $query->row_array();

	}
	public function get_wo_sales_person($order_id){
		$sql="SELECT wo_work_orders.* FROM wo_work_orders WHERE order_id='$order_id' ";
		$query = $this->db->query($sql);					 
		return $query->row_array();

	}
	public function get_users_form_production(){
		echo $sql="SELECT GROUP_CONCAT(staff_id) as ph_users FROM staff_master WHERE dashboard_category='PH' ";
		$query = $this->db->query($sql);					 
		return $query->row_array();

	}
	public function insert_notification($data){
		$this->db->insert('notification_master', $data);
		//echo $this->db->last_query();;
		return true;
	}

}
?>