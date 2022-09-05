<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Formdata_model extends CI_Model{
	//
	public function get_all_wo_addons(){
		$sql="SELECT * FROM wo_order_summary WHERE wo_addon_id!='0' ";    
		$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function drop_orginal_order_option_item($order_summary_id,$wo_order_id){
		$this->db->where('order_summary_id ',$order_summary_id);
		$this->db->where('wo_order_id ',$wo_order_id);
		$this->db->delete('wo_order_options');
		return true;
	}
	public function update_work_summary_one_by_one($data, $order_summary_id){
		$this->db->where('order_summary_id', $order_summary_id);
		$this->db->update('wo_order_summary', $data);
		return true;

	}
	public function get_all_summary_options_latest($order_summary_id,$wo_order_id){
			$this->db->select('wo_order_options.*,wo_product_fit_type.fit_type_name');
	    	$this->db->from('wo_order_options');
			$this->db->join('wo_product_fit_type', 'wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id', 'Left');
			$this->db->where('order_summary_id',$order_summary_id);
			$this->db->where('wo_order_id',$wo_order_id);
			$this->db->where('data_from','offline');
		
	    	$query = $this->db->get();	//echo $this->db->last_query();			 
			return $query->result_array();

	}
	public function remove_orginal_order_option_item($order_summary_id,$wo_order_id,$option_login_id){
		$this->db->where('order_summary_id ',$order_summary_id);
		$this->db->where('wo_order_id ',$wo_order_id);
		$this->db->where('option_login_id ',$option_login_id);
		$this->db->delete('wo_order_options');
		return true;
	}
	public function remove_orginal_summary_item($order_summary_id){
		$this->db->where('order_summary_id ',$order_summary_id);
		$this->db->delete('wo_order_summary');
		return true;
	}
	public function get_summary_of_online_data($order_summary_id){
		$sql="SELECT * FROM wo_order_summary WHERE order_summary_id='$order_summary_id' ";    
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function remove_offline_draft_one_by_one($offline_draft_id){
		$this->db->where('offline_draft_id',$offline_draft_id);
		$this->db->delete('wo_offline_draft');
		return true;
	}
	public function remove_offline_draft($current_form_id,$current_login_id){
		$this->db->where('current_form_id',$current_form_id);
		$this->db->where('current_login_id',$current_login_id);
		$this->db->delete('wo_offline_draft');
		return true;
	}
	public function get_wo_order_summary_sum($wo_order_id){
		$sql="Select sum(wo_qty) as totalQty,sum(wo_rate) as totalRate,sum(wo_discount)as totalDiscount from wo_order_summary  where wo_order_id='$wo_order_id' ";    
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function update_offline_draft_data($data, $offline_draft_id){
		$this->db->where('offline_draft_id', $offline_draft_id);
		$this->db->update('wo_offline_draft', $data);
		return true;

	}
	public function get_any_draft_data($wo_current_form_no,$option_login_id){
			$this->db->select('wo_order_options.*,wo_product_fit_type.fit_type_name');
	    	$this->db->from('wo_order_options');
			$this->db->join('wo_product_fit_type', 'wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id', 'Left');
			$this->db->where('wo_current_form_no',$wo_current_form_no);
			$this->db->where('option_login_id',$option_login_id);
			$this->db->where('online_draft_id',$offline_draft_id);
			$this->db->where('data_from','offline');
	    	$query = $this->db->get();	//echo $this->db->last_query();exit;				 
			return $query->result_array();

	}

	public function get_all_order_options_latest($wo_current_form_no,$option_login_id,$offline_draft_id){
			$this->db->select('wo_order_options.*,wo_product_fit_type.fit_type_name');
	    	$this->db->from('wo_order_options');
			$this->db->join('wo_product_fit_type', 'wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id', 'Left');
			$this->db->where('wo_current_form_no',$wo_current_form_no);
			$this->db->where('option_login_id',$option_login_id);
			$this->db->where('online_draft_id',$offline_draft_id);
			$this->db->where('data_from','offline');
		
	    	$query = $this->db->get();	//echo $this->db->last_query();exit;				 
			return $query->result_array();

	}
	public function remove_order_option_item($offline_draft_id,$wo_current_form_no){
		$this->db->where('online_draft_id ',$offline_draft_id);
		$this->db->where('wo_current_form_no',$wo_current_form_no);
		$this->db->where('data_from','offline');
		$this->db->delete('wo_order_options');
		return true;
	}
	public function remove_order_option_item_by_summary_id($order_summary_id){
		$this->db->where('order_summary_id ',$order_summary_id);
		$this->db->where('data_from','offline');
		$this->db->delete('wo_order_options');
		return true;
	}
	public function remove_summary_item($id){
		$this->db->where('offline_draft_id',$id);
		$this->db->delete('wo_offline_draft');
		return true;
	}
	public function get_summary_draft_data($offline_draft_id){
			$this->db->select('wo_offline_draft.*,wo_product_types.product_type_name,wo_collar_types.collar_type_name,wo_sleeve_types.sleeve_type_name,wo_fabric_types.fabric_type_name');	    	$this->db->from('wo_offline_draft');
			$this->db->join('wo_product_types', 'wo_product_types.product_type_id=wo_offline_draft.wo_product_type_id', 'Left');
			$this->db->join('wo_collar_types', 'wo_collar_types.collar_type_id=wo_offline_draft.wo_collar_type_id', 'Left');
			$this->db->join('wo_sleeve_types', 'wo_sleeve_types.sleeve_type_id=wo_offline_draft.wo_sleeve_type_id', 'Left');
			$this->db->join('wo_fabric_types', 'wo_fabric_types.fabric_type_id=wo_offline_draft.wo_fabric_type_id', 'Left');
			$this->db->where('wo_offline_draft.offline_draft_id',$offline_draft_id);
			//$this->db->where('wo_offline_draft.current_login_id',$loginid);
			//$this->db->order_by('wo_online_draft.offline_draft_id', 'asc');
			//$this->db->group_by('wo_online_draft.wo_ref_no');
	    	$query = $this->db->get();	
			//echo $this->db->last_query();
			return $query->row_array();

	}
	public function get_offline_order_draft($current_form_id,$loginid){
			$this->db->select('wo_offline_draft.*,wo_product_types.product_type_name,wo_collar_types.collar_type_name,wo_sleeve_types.sleeve_type_name,wo_fabric_types.fabric_type_name');	    	$this->db->from('wo_offline_draft');
			$this->db->join('wo_product_types', 'wo_product_types.product_type_id=wo_offline_draft.wo_product_type_id', 'Left');
			$this->db->join('wo_collar_types', 'wo_collar_types.collar_type_id=wo_offline_draft.wo_collar_type_id', 'Left');
			$this->db->join('wo_sleeve_types', 'wo_sleeve_types.sleeve_type_id=wo_offline_draft.wo_sleeve_type_id', 'Left');
			$this->db->join('wo_fabric_types', 'wo_fabric_types.fabric_type_id=wo_offline_draft.wo_fabric_type_id', 'Left');
			$this->db->where('wo_offline_draft.current_form_id',$current_form_id);
			$this->db->where('wo_offline_draft.current_login_id',$loginid);
			//$this->db->order_by('wo_online_draft.offline_draft_id', 'asc');
			//$this->db->group_by('wo_online_draft.wo_ref_no');
	    	$query = $this->db->get();	
			//echo $this->db->last_query();
			return $query->result_array();

	}
	public function insert_offline_draft_data($data){
		$this->db->insert('wo_offline_draft', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
		//return true;
	}
	
}
?>