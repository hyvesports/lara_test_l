<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model{
	
	public function get_any_dispatch_row($dispatch_order_item_id){
			$sql="SELECT count(*) as dispatch_counts FROM  tbl_dispatch WHERE dispatch_order_item_id='$dispatch_order_item_id'  ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_last_department_updation_row($schedule_id,$summary_item_id){
			$sql="SELECT * FROM  rs_design_departments WHERE schedule_id='$schedule_id' and summary_item_id='$summary_item_id' ORDER BY  rs_design_id DESC LIMIT 1 ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	public function get_any_rejection_now($schedule_id,$summary_item_id,$dep){
			$sql="SELECT * FROM  sh_schedule_department_rejections WHERE schedule_id='$schedule_id' and summary_id='$summary_item_id' and FIND_IN_SET(".$dep.",rejected_to_departments) ORDER BY  rejection_id DESC LIMIT 1 ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function get_schedule_numbers_wo($did,$order_id){
			$sql="SELECT group_concat(schedule_department_id) as TOTAL_SCHEDULES FROM sh_schedule_departments WHERE FIND_IN_SET(".$did.",department_ids) and order_id='$order_id' group by order_id ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_schedule_numbers($did,$unit_managed,$order_id){
			$sql="SELECT group_concat(schedule_department_id) as TOTAL_SCHEDULES FROM sh_schedule_departments WHERE FIND_IN_SET(".$did.",department_ids) AND unit_id IN(".$unit_managed.")  and order_id='$order_id' group by order_id ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_tracking_row($tracking_id){
			$sql="SELECT * FROM  tbl_dispatch_tracking WHERE dispatch_tracking_id='$tracking_id'  ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_item_from_completed_without_schedule($order_id,$summary_id){
			$sql="SELECT wo_completed.*,SUM(wo_completed.qc_approved_qty) as QC_APPROVED_QTY FROM  wo_completed WHERE order_id='$order_id' and summary_id='$summary_id' ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	
	public function get_order_summary_group_by_refno($wo_order_id){
//			$sql="SELECT * FROM wo_order_summary WHERE wo_order_summary.wo_order_id='$wo_order_id' GROUP BY wo_order_summary.wo_ref_no ";    
$sql="SELECT * FROM wo_order_summary LEFT JOIN tbl_dispatch ON tbl_dispatch.dispatch_order_id=wo_order_summary.wo_order_id AND tbl_dispatch.dispatch_order_item_id=wo_order_summary.order_summary_id WHERE wo_order_summary.wo_order_id='$wo_order_id' GROUP BY wo_order_summary.wo_ref_no ";
//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function get_order_summary_by_refno($wo_order_id,$wo_ref_no){
			$sql="SELECT * FROM wo_order_summary WHERE wo_order_id='$wo_order_id' and wo_ref_no='$wo_ref_no' ";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function get_dispatched_data_by_tracking($tracking_id,$dispatch_order_item_id){
			$sql="SELECT * FROM  tbl_dispatch WHERE tracking_id='$tracking_id' and dispatch_order_item_id='$dispatch_order_item_id' ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function get_dispatched_data($dispatch_order_id,$dispatch_order_item_id){
			$sql="SELECT SUM(tbl_dispatch.shipping_qty) as DISPATCH_QTY FROM  tbl_dispatch WHERE dispatch_order_id='$dispatch_order_id' and dispatch_order_item_id='$dispatch_order_item_id' ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_item_from_completed_with_schedule_dep_id($order_id,$schedule_dept_id,$summary_id){
			$sql="SELECT wo_completed.*,SUM(wo_completed.qc_approved_qty) as QC_APPROVED_QTY FROM  wo_completed WHERE order_id='$order_id' and summary_id='$summary_id' and schedule_dept_id='$schedule_dept_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	public function get_item_from_completed($order_id,$schedule_id,$summary_id){
			$sql="SELECT wo_completed.*,SUM(wo_completed.qc_approved_qty) as QC_APPROVED_QTY FROM  wo_completed WHERE order_id='$order_id' and summary_id='$summary_id' and schedule_id='$schedule_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	
	public function qc_approved_qty_by_field($response_id,$summary_id){
			$sql="SELECT qc_approved_qty FROM  wo_completed WHERE response_id='$response_id' and summary_id='$summary_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	public function check_is_a_completed_by_field($response_id,$summary_id){
			$sql="SELECT qc_approved_qty FROM  wo_completed WHERE response_id='$response_id' and summary_id='$summary_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	public function check_is_a_completed($response_id,$summary_id){
			$sql="SELECT * FROM  wo_completed WHERE response_id='$response_id' and summary_id='$summary_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	
	public function get_qc_uploaded_images($order_id,$order_item_id){
			$sql="SELECT * FROM  sh_qc_images WHERE order_id='$order_id' and order_item_id='$order_item_id'";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function update_wo_completion_status($data, $order_id){
		$this->db->where('order_id', $order_id);
		$this->db->update('wo_work_orders', $data);
		return true;

	}
	public function insert_completion_data($data){
		$this->db->insert('wo_completed', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function check_wo_is_completed($order_id){
			$sql="SELECT * FROM  wo_work_orders WHERE order_id='$order_id' and production_completed_status=1";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function get_wo_documents($wo_order_id,$document_type){
			$sql="Select * from wo_work_order_documents WHERE wo_order_id='$wo_order_id' AND document_type='$document_type' ";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	function removeItemString($str, $item) {
		$parts = explode(',', $str);
		while(($i = array_search($item, $parts)) !== false) {
			unset($parts[$i]);
		}
		return implode(',', $parts);
	}
	
	public function get_order_data_from_schedule($order_id){    
    	$sql="SELECT * FROM sh_schedules WHERE order_id='$order_id' LIMIT 1";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	//check_is_rejected_new
	public function check_is_rejected_new($schedule_department_id,$rej_summary_item_id){    
    	$sql="SELECT * FROM sh_schedule_departments WHERE schedule_department_id='$schedule_department_id' and FIND_IN_SET(".$rej_summary_item_id.",sh_schedule_departments.rej_items) ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function check_is_rejected($order_id,$rej_summary_item_id){    
    	$sql="SELECT * FROM rj_scheduled_orders WHERE order_id='$order_id' and rej_summary_item_id='$rej_summary_item_id' and re_schedule_status=0 LIMIT 1";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_order_attachments($wo_order_id){
		$sql="Select * from wo_work_order_documents WHERE wo_order_id='$wo_order_id' ";    
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	public function check_is_dispatched($dispatch_order_id,$dispatch_order_item_id){    
    	$sql="SELECT * FROM tbl_dispatch WHERE dispatch_order_id='$dispatch_order_id' and dispatch_order_item_id='$dispatch_order_item_id' LIMIT 1";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}

	public function get_order_final_dispatch_date_by_field($schedule_id){    
    	$sql="SELECT sh_schedule_departments.department_schedule_date FROM sh_schedule_departments WHERE schedule_id='$schedule_id' and FIND_IN_SET(10,sh_schedule_departments.department_ids) ORDER BY schedule_department_id DESC limit 1  ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_order_final_dispatch_date($schedule_id){    
    	$sql="SELECT sh_schedule_departments.* FROM sh_schedule_departments WHERE schedule_id='$schedule_id' and FIND_IN_SET(10,sh_schedule_departments.department_ids) ORDER BY schedule_department_id DESC limit 1  ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}

}
?>