<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model{
	
	//check_priority_exist  	
	public function get_customer_leads($lead_client_id){
			$this->db->select('leads_master.*,lead_types.lead_type_name,lead_types.color_code,wo_work_orders.orderform_number,wo_work_orders.order_uuid as wo_order_uuid');
	    	$this->db->from('leads_master');
			$this->db->join('lead_types', 'lead_types.lead_type_id = leads_master.lead_type_id', 'Left');
			$this->db->join('wo_work_orders', 'wo_work_orders.lead_id = leads_master.lead_id', 'Left');
			$this->db->where('lead_client_id',$lead_client_id);
			$this->db->order_by("lead_id", "desc");
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	public function delete_customer_data($uuid){
		$this->db->where('customer_uuid',$uuid);
		$this->db->delete('customer_master');
		return true;
	}

	public function update_customer_data($data, $id){
		$this->db->where('customer_id', $id);
		$this->db->update('customer_master', $data);
		return true;
	}
	
	
	public function get_customer_data_by_code($customer_code){
			$this->db->select('customer_id');
	    	$this->db->from('customer_master');
			$this->db->where('customer_code',$customer_code);
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function get_customer_data_by_id($customer_id){
			$this->db->select('customer_master.*');
	    	$this->db->from('customer_master');
			$this->db->where('customer_id',$customer_id);
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function get_customer_data($uuid){
			$this->db->select('customer_master.*');
	    	$this->db->from('customer_master');
			$this->db->where('customer_uuid',$uuid);
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function get_all_customers(){
			$this->db->select('customer_master.*');
	    	$this->db->from('customer_master');
			$this->db->order_by("customer_master.customer_id", "DESC");
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	
	public function insert_customer_data_from_lead($data){	
		
		$this->db->set('customer_uuid', 'UUID()', FALSE);
		$this->db->insert('customer_master', $data);
		$insert_id = $this->db->insert_id();
		$inc=1000;
		$code=$inc+$insert_id;
		$customer_code="C".$code;
		$dataup = [
            'customer_code' =>$customer_code,
        ];
        $this->db->where('customer_id', $insert_id);
        $this->db->update('customer_master', $dataup);
		return $insert_id;
	}
	
	public function insert_customer_data($data){	
		
		$this->db->set('customer_uuid', 'UUID()', FALSE);
		$this->db->insert('customer_master', $data);
		$insert_id = $this->db->insert_id();
		$inc=1000;
		$code=$inc+$insert_id;
		$customer_code="C".$code;
		$dataup =array(
            'customer_code' =>$customer_code,
        );
        $this->db->where('customer_id', $insert_id);
        $this->db->update('customer_master', $dataup);
		return $customer_code;
	}
	public function check_customer_mobile_exist($data,$condition){
			//print_r($data);
			$customer_mobile_no=$data['customer_mobile_no'];
			$this->db->select('customer_master.*');
	    	$this->db->from('customer_master');
			$this->db->where('customer_mobile_no',$customer_mobile_no);
			$this->db->limit(1);
			if($condition!=""){
			$this->db->where('customer_id!=',$condition);
			}
	    	$query = $this->db->get();
			//echo $this->db->last_query();;					 
			return $query->row_array();
	}
	
	public function check_customer_email_exist($data,$condition){
			//print_r($data);
			$customer_email=$data['customer_email'];
			$this->db->select('customer_master.*');
	    	$this->db->from('customer_master');
			$this->db->where('customer_email',$customer_email);
			$this->db->limit(1);
			if($condition!=""){
			$this->db->where('customer_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function check_customer_mobileno_exist($data,$condition){
			//print_r($data);
			$customer_mobile_no=$data['customer_mobile_no'];
			$this->db->select('customer_master.*');
	    	$this->db->from('customer_master');
			$this->db->where('customer_mobile_no',$customer_mobile_no);
			$this->db->limit(1);
			if($condition!=""){
			$this->db->where('customer_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	
	//____________________end of staff___

	
}
?>