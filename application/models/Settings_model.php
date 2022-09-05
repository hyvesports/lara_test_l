<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model{
	//lead source module
	//get_active_lead_stages
	public function get_system_working_hours(){
			$sql="Select * from system_master  where system_master_code='WH' limit 1";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_active_lead_stages(){
			$sql="Select * from lead_stages  where lead_stage_status='1' ORDER BY lead_stage_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function delete_lead_stage($lead_stage_id){
		$this->db->where('lead_stage_id',$lead_stage_id);
		$this->db->delete('lead_stages');
		return true;
	}
	public function update_lead_stage($data, $id){
		$this->db->where('lead_stage_id ', $id);
		$this->db->update('lead_stages', $data);
		return true;
	}
	public function get_lead_stage_data($lead_stage_id){
			$sql="Select * from lead_stages where lead_stage_id='$lead_stage_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_lead_stages(){
			$sql="Select * from lead_stages ORDER BY lead_stage_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_lead_stage($data){
		$this->db->insert('lead_stages', $data);
		return true;
	}	
	public function check_lead_stage_exist($data,$condition){
			//print_r($data);
			$lead_stage_name=$data['lead_stage_name'];
			$this->db->select('lead_stages.*');
	    	$this->db->from('lead_stages');
			$this->db->where('lead_stage_name',$lead_stage_name);
			if($condition!=""){
			$this->db->where('lead_stage_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}	
	public function get_lead_categories(){
			$sql="Select * from lead_category WHERE lead_cat_status='1' ";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function update_lead_source($data, $id){
		$this->db->where('lead_source_id ', $id);
		$this->db->update('lead_sources', $data);
		return true;
	}
	//----------------------------------------------------------------------
	public function get_lead_source_data($lead_source_id){
			$sql="Select * from lead_sources where lead_source_id='$lead_source_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function insert_lead_sources($data){
		$this->db->insert('lead_sources', $data);
		return true;
	}
	public function check_lead_source_exist($data,$condition){
			//print_r($data);
			$lead_source_name=$data['lead_source_name'];
			$this->db->select('lead_sources.*');
	    	$this->db->from('lead_sources');
			$this->db->where('lead_source_name',$lead_source_name);
			if($condition!=""){
			$this->db->where('lead_source_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}	
	
	public function delete_lead_sources($lead_source_id){
		$this->db->where('lead_source_id',$lead_source_id);
		$this->db->delete('lead_sources');
		return true;
	}
	public function get_all_lead_sources(){
			$sql="Select * from lead_sources ORDER BY lead_source_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}

	//------------------------------------------------------------------------
	public function get_active_units(){
			$sql="Select * from pr_production_units WHERE production_unit_status='1'  ORDER BY production_unit_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function delete_productsize($product_size_id){
		$this->db->where('product_size_id',$product_size_id);
		$this->db->delete('wo_product_size');
		return true;
	}
	public function update_productsize($data, $id){
		$this->db->where('product_size_id', $id);
		$this->db->update('wo_product_size', $data);
		return true;
	}	
	public function get_productsize_data($product_size_id){
			$sql="Select * from wo_product_size where product_size_id='$product_size_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function insert_productsize($data){
		$this->db->insert('wo_product_size', $data);
		return true;
	}

	public function check_productsize_exist($data,$condition){
			//print_r($data);
			$product_size_name=$data['product_size_name'];
			$this->db->select('wo_product_size.*');
	    	$this->db->from('wo_product_size');
			$this->db->where('product_size_name',$product_size_name);
			if($condition!=""){
			$this->db->where('product_size_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}

	
	public function get_all_product_size(){
			$sql="Select * from wo_product_size ORDER BY product_size_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function get_all_taxx(){
			$sql="Select * from wo_taxclass ORDER BY taxclass_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function get_tax_data($taxclass_id){
			$sql="Select * from wo_taxclass where taxclass_id='$taxclass_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function delete_tax($taxclass_id){
		$this->db->where('taxclass_id',$taxclass_id);
		$this->db->delete('wo_taxclass');
		return true;
	}
	public function update_tax($data, $id){
		$this->db->where('taxclass_id', $id);
		$this->db->update('wo_taxclass', $data);
		return true;
	}
	public function insert_tax($data){
		$this->db->insert('wo_taxclass', $data);
		return true;
	}
	public function check_tax_exist($data,$condition){
			//print_r($data);
			$taxclass_name=$data['taxclass_name'];
			$taxclass_value=$data['taxclass_value'];
			$this->db->select('wo_taxclass.*');
	    	$this->db->from('wo_taxclass');
			$this->db->where('taxclass_name',$taxclass_name);
			$this->db->where('taxclass_value',$taxclass_value);
			if($condition!=""){
			$this->db->where('taxclass_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	//______________________
	public function update_shipping($data, $id){
		$this->db->where('shipping_mode_id', $id);
		$this->db->update('wo_shipping_mode', $data);
		return true;
	}
	public function get_shipping_data($shipping_mode_id){
			$sql="Select * from wo_shipping_mode where shipping_mode_id='$shipping_mode_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function delete_shipping($shipping_mode_id){
		$this->db->where('shipping_mode_id',$shipping_mode_id);
		$this->db->delete('wo_shipping_mode');
		return true;
	}
	public function get_all_shippings(){
			$sql="Select * from wo_shipping_mode ORDER BY shipping_mode_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function insert_shipping($data){
		$this->db->insert('wo_shipping_mode', $data);
		return true;
	}
	public function check_shipping_exist($data,$condition){
			//print_r($data);
			$shipping_mode_name=$data['shipping_mode_name'];
			$this->db->select('wo_shipping_mode.*');
	    	$this->db->from('wo_shipping_mode');
			$this->db->where('shipping_mode_name',$shipping_mode_name);
			if($condition!=""){
			$this->db->where('shipping_mode_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	//________________________ 
	public function delete_addons($addon_id){
		$this->db->where('addon_id',$addon_id );
		$this->db->delete('wo_addons');
		return true;
	}
	public function update_addons($data, $id){
		$this->db->where('addon_id', $id);
		$this->db->update('wo_addons', $data);
		return true;
	}
	public function get_addons_data($addon_id ){
			$sql="Select * from wo_addons where addon_id='$addon_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_addonss(){
			$sql="Select * from wo_addons ORDER BY addon_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_addons($data){
		$this->db->insert('wo_addons', $data);
		return true;
	}
	public function check_addons_exist($data,$condition){
			//print_r($data);
			$addon_name=$data['addon_name'];
			$this->db->select('wo_addons.*');
	    	$this->db->from('wo_addons');
			$this->db->where('addon_name',$addon_name);
			if($condition!=""){
			$this->db->where('addon_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	//________________________________
	public function delete_sleevetype($sleeve_type_id){
		$this->db->where('sleeve_type_id',$sleeve_type_id );
		$this->db->delete('wo_sleeve_types');
		return true;
	}
	public function update_sleevetype($data, $id){
		$this->db->where('sleeve_type_id', $id);
		$this->db->update('wo_sleeve_types', $data);
		return true;
	}
	public function get_sleevetype_data($sleeve_type_id ){
			$sql="Select * from wo_sleeve_types where sleeve_type_id='$sleeve_type_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_sleevetypes(){
			$sql="Select * from wo_sleeve_types ORDER BY sleeve_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_sleevetype($data){
		$this->db->insert('wo_sleeve_types', $data);
		return true;
	}
	public function check_sleevetype_exist($data,$condition){
			//print_r($data);
			$sleeve_type_name=$data['sleeve_type_name'];
			$this->db->select('wo_sleeve_types.*');
	    	$this->db->from('wo_sleeve_types');
			$this->db->where('sleeve_type_name',$sleeve_type_name);
			if($condition!=""){
			$this->db->where('sleeve_type_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	//_________________________________________________________

	public function delete_producttype($product_type_id){
		$this->db->where('product_type_id',$product_type_id );
		$this->db->delete('wo_product_types');
		return true;
	}
	public function update_producttype($data, $id){
		$this->db->where('product_type_id', $id);
		$this->db->update('wo_product_types', $data);
		return true;
	}
	public function get_producttype_data($product_type_id ){
			$sql="Select * from wo_product_types where product_type_id='$product_type_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_producttypes(){
			$sql="Select * from wo_product_types ORDER BY product_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_producttype($data){
		$this->db->insert('wo_product_types', $data);
		return true;
	}
	public function check_producttype_exist($data,$condition){
			//print_r($data);
			$product_type_name=$data['product_type_name'];
			$this->db->select('wo_product_types.*');
	    	$this->db->from('wo_product_types');
			$this->db->where('product_type_name',$product_type_name);
			if($condition!=""){
			$this->db->where('product_type_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	//_________________________________________________________
	public function get_sports_types(){
			$sql="Select * from sports_types WHERE sports_type_status='1' ORDER BY sports_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function get_lead_types(){
			$sql="Select * from lead_types WHERE lead_type_status='1' ORDER BY lead_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	
	public function delete_sportstype($sports_type_id){
		$this->db->where('sports_type_id',$sports_type_id);
		$this->db->delete('sports_types');
		return true;
	}
	public function update_sportstype($data, $id){
		$this->db->where('sports_type_id ', $id);
		$this->db->update('sports_types', $data);
		return true;
	}
	public function get_sportstype_data($sports_type_id){
			$sql="Select * from sports_types where sports_type_id='$sports_type_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_sportstypes(){
			$sql="Select * from sports_types ORDER BY sports_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_sportstype($data){
		$this->db->insert('sports_types', $data);
		return true;
	}
	public function check_sportstype_exist($data,$condition){
			//print_r($data);
			$sports_type_name=$data['sports_type_name'];
			$this->db->select('sports_types.*');
	    	$this->db->from('sports_types');
			$this->db->where('sports_type_name',$sports_type_name);
			if($condition!=""){
			$this->db->where('sports_type_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
//____________________________________________________________	
	
	public function delete_collartype($collar_type_id){
		$this->db->where('collar_type_id',$collar_type_id);
		$this->db->delete('wo_collar_types');
		return true;
	}
	public function update_collartype($data, $id){
		$this->db->where('collar_type_id ', $id);
		$this->db->update('wo_collar_types', $data);
		return true;
	}
	public function get_collartype_data($collar_type_id){
			$sql="Select * from wo_collar_types where collar_type_id='$collar_type_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_collartypes(){
			$sql="Select * from wo_collar_types ORDER BY collar_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_collartype($data){
		$this->db->insert('wo_collar_types', $data);
		return true;
	}
	public function check_collartype_exist($data,$condition){
			//print_r($data);
			$collar_type_name=$data['collar_type_name'];
			$this->db->select('wo_collar_types.*');
	    	$this->db->from('wo_collar_types');
			$this->db->where('collar_type_name',$collar_type_name);
			if($condition!=""){
			$this->db->where('collar_type_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	
	//_____________________________
	public function delete_fabrictype($fabric_type_id){
		$this->db->where('fabric_type_id',$fabric_type_id);
		$this->db->delete('wo_fabric_types');
		return true;
	}
	public function update_fabrictype($data, $id){
		$this->db->where('fabric_type_id ', $id);
		$this->db->update('wo_fabric_types', $data);
		return true;
	}
	public function get_fabrictype_data($fabric_type_id){
			$sql="Select * from wo_fabric_types where fabric_type_id='$fabric_type_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_fabrictypes(){
			$sql="Select * from wo_fabric_types ORDER BY fabric_type_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function insert_fabrictype($data){
		$this->db->insert('wo_fabric_types', $data);
		return true;
	}
	public function check_fabrictype_exist($data,$condition){
			//print_r($data);
			$fabric_type_name=$data['fabric_type_name'];
			$this->db->select('wo_fabric_types.*');
	    	$this->db->from('wo_fabric_types');
			$this->db->where('fabric_type_name',$fabric_type_name);
			if($condition!=""){
			$this->db->where('fabric_type_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}

	public function get_lead_sources(){
			$sql="Select * from lead_sources WHERE lead_source_status='1'  ORDER BY lead_source_name";   
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}

	public function get_active_locations(){
			$sql="Select * from location_master WHERE location_status='1'  ORDER BY location_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function get_active_department($department_parent){
			$sql="Select * from department_master WHERE department_status='1' AND department_parent='$department_parent' ORDER BY department_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function get_active_designation($designation_parent){
			$sql="Select * from designation_master WHERE designation_status='1' AND designation_parent='$designation_parent' ORDER BY designation_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	//______________ priority controller ____________________
	
	public function delete_priority($uuid){
		$this->db->where('priority_uuid',$uuid);
		$this->db->delete('priority_master');
		return true;
	}
	public function update_priority($data, $id){
		$this->db->where('priority_id ', $id);
		$this->db->update('priority_master', $data);
		return true;
	}
	public function get_priority_data($uuid){
			$sql="Select * from priority_master where priority_uuid='$uuid'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_priority(){
			$sql="Select * from priority_master ORDER BY priority_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function insert_priority($data){
		$this->db->set('priority_uuid', 'UUID()', FALSE);
		$this->db->insert('priority_master', $data);
		return true;
	}
	
	public function check_priority_exist($data,$condition){
			//print_r($data);
			$priority_name=$data['priority_name'];
			$this->db->select('priority_master.*');
	    	$this->db->from('priority_master');
			$this->db->where('priority_name',$priority_name);
			if($condition!=""){
			$this->db->where('priority_id !=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	
	//______________ Status controller ____________________
	
	public function delete_status($uuid){
		$this->db->where('status_uuid',$uuid);
		$this->db->delete('status_master');
		return true;
	}
	public function update_status($data, $id){
		$this->db->where('status_id', $id);
		$this->db->update('status_master', $data);
		return true;
	}
	public function get_status_data($uuid){
			$sql="Select * from status_master where status_uuid='$uuid'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_status(){
			$sql="Select * from status_master ORDER BY status_name";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function insert_status($data){
		$this->db->set('status_uuid', 'UUID()', FALSE);
		$this->db->insert('status_master', $data);
		return true;
	}
	
	public function check_status_exist($data,$condition){
			//print_r($data);
			$status_name=$data['status_name'];
			$this->db->select('status_master.*');
	    	$this->db->from('status_master');
			$this->db->where('status_name',$status_name);
			if($condition!=""){
			$this->db->where('status_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	//_______________________________________________
	
	public function delete_location($uuid){
		$this->db->where('location_uuid',$uuid);
		$this->db->delete('location_master');
		return true;
	}
	public function update_location($data, $id){
		$this->db->where('location_id', $id);
		$this->db->update('location_master', $data);
		return true;
	}
	public function get_location_data($uuid){
			$sql="Select * from location_master where location_uuid='$uuid'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_all_locations(){
			$this->db->select('location_master.*,tbl_countries.country_name,tbl_states.state_name');
	    	$this->db->from('location_master');
			$this->db->join('tbl_countries', 'tbl_countries.country_id = location_master.location_country_id', 'Left');
			$this->db->join('tbl_states', 'tbl_states.state_id = location_master.location_state_id', 'Left');
			$this->db->order_by("location_name", "");
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	public function insert_location($data){
		$this->db->set('location_uuid', 'UUID()', FALSE);
		$this->db->insert('location_master', $data);
		return true;
	}
	public function check_location_exist($data,$condition){
			//print_r($data);
			$location_country_id=$data['location_country_id'];
			$location_state_id=$data['location_state_id'];
			$location_name=$data['location_name'];
			$this->db->select('location_master.*');
	    	$this->db->from('location_master');
			$this->db->where('location_name',$location_name);
			$this->db->where('location_country_id',$location_country_id);
			$this->db->where('location_state_id',$location_state_id);
			if($condition!=""){
			$this->db->where('location_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function get_states_by_country($state_id){
			$sql="Select * from tbl_states where state_id='$state_id' AND state_status='1'";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function get_all_countries(){
			$sql="Select * from tbl_countries where country_status='1'";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function delete_designation($uuid){
		$this->db->where('designation_uuid',$uuid);
		$this->db->delete('designation_master');
		return true;
	}
	
	public function update_designation($data, $id){
		$this->db->where('designation_id', $id);
		$this->db->update('designation_master', $data);
		return true;
	}
	public function get_designation_data($designation_uuid){
			$sql="Select * from designation_master where designation_uuid='$designation_uuid'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_parent_designations($designation_parent){
			$sql="Select * from designation_master where designation_parent='$designation_parent'";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function get_all_designations(){
			$this->db->select('designation_master.*,dm.designation_name as parent_desi');
	    	$this->db->from('designation_master');
			$this->db->join('designation_master as dm', 'dm.designation_id = designation_master.designation_parent ', 'Left');
			$this->db->order_by("designation_name", "");
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	public function insert_designation($data){
		$this->db->set('designation_uuid', 'UUID()', FALSE);
		$this->db->insert('designation_master', $data);
		return true;
	}
	
	public function check_designation_exist($chkvalue,$condition){
			$this->db->select('designation_master.*');
	    	$this->db->from('designation_master');
			$this->db->where('designation_name',$chkvalue);
			if($condition!=""){
			$this->db->where('designation_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function check_exist($chkvalue,$condition){
			$this->db->select('department_master.*');
	    	$this->db->from('department_master');
			$this->db->where('department_name',$chkvalue);
			if($condition!=""){
			$this->db->where('department_id!=',$condition);
			}
	    	$query = $this->db->get();					 
			return $query->row_array();
	}
	
	public function delete($id){
		$this->db->where('department_id',$id);
		$this->db->where('department_default!=','1');		
		$this->db->delete('department_master');
		return true;
	}
	public function get_parent_departments(){
			$this->db->select('department_master.*');
	    	$this->db->from('department_master');
			$this->db->where('is_dynamic','1');
			$this->db->where('department_parent','0');
			$this->db->order_by("department_name", "");
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	public function insert_department($data){
		
		$this->db->insert('department_master', $data);
		return true;
	}
	
	public function update_department($data, $id){
		$this->db->where('department_id', $id);
		$this->db->update('department_master', $data);
		return true;
	}
	
	
	public function get_department_data($id){
			$query = $this->db->get_where('department_master', array('department_id' => $id));
			return $result = $query->row_array();
	}
	public function get_all_departments(){
			$this->db->select('department_master.*,dp.department_name as parent_dept');
	    	$this->db->from('department_master');
			$this->db->join('department_master as dp', 'dp.department_id = department_master.department_parent ', 'Left');
			$this->db->order_by("department_name", "");
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	

}

?>