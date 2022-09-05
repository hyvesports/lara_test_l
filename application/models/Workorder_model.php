<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Workorder_model extends CI_Model{

	

	//check_priority_exist
	public function get_product_fit(){
			$this->db->select('wo_product_fit_type.*');
	    	$this->db->from('wo_product_fit_type');
			$this->db->where('fit_type_status','1');
	    	$query = $this->db->get();					 
			return $query->result_array();

	} 

	public function update_sms_wo_data($orderid,$summaryid,$data){
		$this->db->where('wo_order_id', $orderid);
		$this->db->where('wo_order_summary_id', $summaryid);
		$this->db->update('sms_order_status',$data);
		return true;
	}
public function  insert_sms_wo_data($data)
{
$this->db->insert('sms_order_status', $data);
 $insert_id = $this->db->insert_id();
  return $insert_id;
}
	public function insert_work_order_online($data){
		$this->db->set('order_uuid', 'UUID()', FALSE);
		$this->db->insert('wo_work_orders', $data);
		$insert_id = $this->db->insert_id();
		//print_r($this->db->last_query());
		$no=1000+$insert_id;
		$orderform_number="N".$no;
		$dataup=array('orderform_number' =>$orderform_number);
		$this->db->where('order_id', $insert_id);
        $this->db->update('wo_work_orders', $dataup);
		return $insert_id;

	}

	public function remove_wo_order_options($wo_order_id){

		$this->db->where('wo_order_id ',$wo_order_id);

		$this->db->delete('wo_order_options');

		return true;

	}

	public function remove_wo_shedules($order_id){

		$this->db->where('order_id ',$order_id);

		$this->db->delete('sh_schedules');

		return true;

	}

	public function remove_wo_shedule_department($order_id){

		$this->db->where('order_id ',$order_id);

		$this->db->delete('sh_schedule_departments');

		return true;

	}

	public function remove_wo_shedule_department_rej($order_id){

		$this->db->where('order_id ',$order_id);

		$this->db->delete('sh_schedule_department_rejections');

		return true;

	}

	public function remove_wo_rj_scheduled($order_id){

		$this->db->where('order_id ',$order_id);

		$this->db->delete('rj_scheduled_orders');

		return true;

	}

	public function remove_wo_shedule_department_item($order_id){

		$this->db->where('orderid ',$order_id);

		$this->db->delete('sh_schedule_item_qty');

		return true;

	}


	public function remove_wo_rs_design($order_id){

$sql="delete RDD from rs_design_departments RDD,sh_schedules SH where RDD.schedule_id=SH.schedule_id and   order_id='".$order_id."'";
 $query = $this->db->query($sql);
return true;

	}

	
	public function get_all_summary_options_latest_offline($order_summary_id,$wo_option_session_id){
			$this->db->select('wo_order_options.*,wo_product_fit_type.fit_type_name');
	    	$this->db->from('wo_order_options');
			$this->db->join('wo_product_fit_type', 'wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id', 'Left');
			$this->db->where('order_summary_id',$order_summary_id);
			$this->db->where('option_session_id',$wo_option_session_id);
			$this->db->where('data_from','offline');

	    	$query = $this->db->get();//echo $this->db->last_query();							 
			return $query->result_array();

	}
	public function get_all_order_options_latest($order_summary_id,$wo_option_session_id){
			$this->db->select('wo_order_options.*,wo_product_fit_type.fit_type_name');
	    	$this->db->from('wo_order_options');
			$this->db->join('wo_product_fit_type', 'wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id', 'Left');
			$this->db->where('order_summary_id',$order_summary_id);
			$this->db->where('option_session_id',$wo_option_session_id);
			$this->db->where('data_from','online');

	    	$query = $this->db->get();//echo $this->db->last_query();							 
			return $query->result_array();

	}

	public function get_all_order_options($order_summary_id){
			$this->db->select('wo_order_options.*,wo_product_fit_type.fit_type_name');
	    	$this->db->from('wo_order_options');
			$this->db->join('wo_product_fit_type', 'wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id', 'Left');
			$this->db->where('order_summary_id',$order_summary_id);
	    	$query = $this->db->get();	echo $this->db->last_query();				 
			return $query->result_array();

	}
	public function update_orders_option_final_new($data, $online_draft_id,$data_from){
		$this->db->where('online_draft_id', $online_draft_id);
		$this->db->where('data_from', $data_from);
		$this->db->update('wo_order_options', $data);
		return true;
	}

	public function update_orders_option_final($data, $online_draft_id){
		$this->db->where('online_draft_id', $online_draft_id);
		$this->db->where('online_draft_id', $online_draft_id);
		$this->db->update('wo_order_options', $data);
		return true;
	}

	public function remove_order_option_item_by_summary_id($order_summary_id){

		$this->db->where('order_summary_id ',$order_summary_id);
		$this->db->where('data_from','online');
		$this->db->delete('wo_order_options');

		return true;

	}



	public function remove_order_option_item($online_draft_id,$wo_current_form_no){
		$this->db->where('online_draft_id ',$online_draft_id);
		$this->db->where('wo_current_form_no',$wo_current_form_no);
		$this->db->where('data_from','online');
		$this->db->delete('wo_order_options');
		return true;
	}

	
	
	public function get_added_order_options_latest($online_draft_id,$option_session_id,$option_login_id){
			$this->db->select('wo_order_options.*');
	    	$this->db->from('wo_order_options');
			$this->db->where('online_draft_id',$online_draft_id);
			$this->db->where('option_session_id',$option_session_id);
			$this->db->where('option_login_id',$option_login_id);
	    	$query = $this->db->get();					 
			return $query->result_array();
	}
	public function get_added_order_options($online_draft_id){
			$this->db->select('wo_order_options.*');
	    	$this->db->from('wo_order_options');
			$this->db->where('online_draft_id',$online_draft_id);
	    	$query = $this->db->get();					 
			return $query->result_array();
	}



	public function get_product_size(){

			$this->db->select('wo_product_size.*');

	    	$this->db->from('wo_product_size');

			$this->db->where('product_size_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	public function remove_summary_item_in_edit($id,$id_for){

		if($id_for==""){

			$this->db->where('order_summary_id ',$id);

		}

		if($id_for=="child"){

			$this->db->where('summary_parent',$id);

		}

		$this->db->delete('wo_order_summary');

		return true;

	}

	public function create_online_summary_item_data($data){
		$this->db->insert('wo_order_summary', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
		//echo $this->db->last_query();;
		//return true;
	}

	public function update_online_summary_item_data($data, $id){

		$this->db->where('order_summary_id', $id);

		$this->db->update('wo_order_summary', $data);

		return true;

	}

	public function get_summary_item_data($order_summary_id){

			$this->db->select('wo_order_summary.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no');

	    	$this->db->from('wo_order_summary');

			$this->db->where('order_summary_id',$order_summary_id);

			$this->db->join('customer_master', 'customer_master.customer_id=wo_order_summary.summary_client_id', 'Left');

	    	$query = $this->db->get();					 

			return $query->row_array();

	}



	public function remove_current_draft_data($current_form_id){

		$this->db->where('current_form_id',$current_form_id);

		$this->db->delete('wo_online_draft');

		return true;

	}



	public function update_summary_child_parent($data, $id){

		$this->db->where('online_draft_parent_id', $id);

		$this->db->update('wo_online_draft', $data);

		return true;

	}

	public function update_online_draft_data($data, $id){
		$this->db->where('online_draft_id', $id);
		$this->db->update('wo_online_draft', $data);
		return true;
	}

	public function remove_summary_item($id,$id_for){

		if($id_for==""){

			$this->db->where('online_draft_id',$id);

		}

		if($id_for=="child"){

			$this->db->where('online_draft_parent_id',$id);

		}

		$this->db->delete('wo_online_draft');

		return true;

	}

	public function chk_ref_no_exist($wo_ref_no,$current_form_id){

			$this->db->select('wo_online_draft.*');

	    	$this->db->from('wo_online_draft');

			$this->db->where('wo_ref_no',$wo_ref_no);

			$this->db->where('current_form_id',$current_form_id);

			$this->db->where('online_draft_parent_id',0);

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	

	

	public function get_product_size_data($product_size_id){

			$this->db->select('wo_product_size.*');

	    	$this->db->from('wo_product_size');

			$this->db->where('product_size_id',$product_size_id);

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function get_online_draft_only($online_draft_id){

			$this->db->select('wo_online_draft.*');

	    	$this->db->from('wo_online_draft');

			$this->db->where('online_draft_id',$online_draft_id);

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function get_summary_draft_data($online_draft_id){

			$this->db->select('wo_online_draft.*,wo_product_types.product_type_name,wo_collar_types.collar_type_name,wo_sleeve_types.sleeve_type_name,wo_fabric_types.fabric_type_name,wo_addons.addon_name');

	    	$this->db->from('wo_online_draft');

			$this->db->join('wo_product_types', 'wo_product_types.product_type_id=wo_online_draft.wo_product_type_id', 'Left');

			$this->db->join('wo_collar_types', 'wo_collar_types.collar_type_id=wo_online_draft.wo_collar_type_id', 'Left');

			$this->db->join('wo_sleeve_types', 'wo_sleeve_types.sleeve_type_id=wo_online_draft.wo_sleeve_type_id', 'Left');

			$this->db->join('wo_fabric_types', 'wo_fabric_types.fabric_type_id=wo_online_draft.wo_fabric_type_id', 'Left');

			$this->db->join('wo_addons', 'wo_addons.addon_id=wo_online_draft.wo_addon_id', 'Left');

			$this->db->where('online_draft_id',$online_draft_id);

			$this->db->order_by("wo_ref_no");

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function get_summary_draft_latest($current_form_id,$session_id,$loginid){
			$this->db->select('wo_online_draft.*,wo_product_types.product_type_name,wo_collar_types.collar_type_name,wo_sleeve_types.sleeve_type_name,wo_fabric_types.fabric_type_name,wo_addons.addon_name');
	    	$this->db->from('wo_online_draft');
			$this->db->join('wo_product_types', 'wo_product_types.product_type_id=wo_online_draft.wo_product_type_id', 'Left');
			$this->db->join('wo_collar_types', 'wo_collar_types.collar_type_id=wo_online_draft.wo_collar_type_id', 'Left');
			$this->db->join('wo_sleeve_types', 'wo_sleeve_types.sleeve_type_id=wo_online_draft.wo_sleeve_type_id', 'Left');
			$this->db->join('wo_fabric_types', 'wo_fabric_types.fabric_type_id=wo_online_draft.wo_fabric_type_id', 'Left');
			$this->db->join('wo_addons', 'wo_addons.addon_id=wo_online_draft.wo_addon_id', 'Left');
			$this->db->where('wo_online_draft.current_form_id',$current_form_id);
			$this->db->where('wo_online_draft.current_session_id',$session_id);
			$this->db->where('wo_online_draft.current_login_id',$loginid);
			$this->db->order_by('wo_online_draft.wo_ref_no', 'asc');
			$this->db->order_by('wo_online_draft.online_draft_parent_id', 'asc');
			//$this->db->group_by('wo_online_draft.wo_ref_no');
	    	$query = $this->db->get();	
			//echo $this->db->last_query();
			return $query->result_array();

	}

	public function get_summary_draft($current_form_id){
			$this->db->select('wo_online_draft.*,wo_product_types.product_type_name,wo_collar_types.collar_type_name,wo_sleeve_types.sleeve_type_name,wo_fabric_types.fabric_type_name,wo_addons.addon_name');
	    	$this->db->from('wo_online_draft');
			$this->db->join('wo_product_types', 'wo_product_types.product_type_id=wo_online_draft.wo_product_type_id', 'Left');
			$this->db->join('wo_collar_types', 'wo_collar_types.collar_type_id=wo_online_draft.wo_collar_type_id', 'Left');
			$this->db->join('wo_sleeve_types', 'wo_sleeve_types.sleeve_type_id=wo_online_draft.wo_sleeve_type_id', 'Left');
			$this->db->join('wo_fabric_types', 'wo_fabric_types.fabric_type_id=wo_online_draft.wo_fabric_type_id', 'Left');
			$this->db->join('wo_addons', 'wo_addons.addon_id=wo_online_draft.wo_addon_id', 'Left');
			$this->db->where('wo_online_draft.current_form_id',$current_form_id);
			$this->db->order_by('wo_online_draft.wo_ref_no', 'asc');
			$this->db->order_by('wo_online_draft.online_draft_parent_id', 'asc');
			//$this->db->group_by('wo_online_draft.wo_ref_no');
	    	$query = $this->db->get();	
			//echo $this->db->last_query();
			return $query->result_array();

	}

	

	

	public function insert_work_summary_one_by_one($data){
			$this->db->insert('wo_order_summary', $data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
			//return true;
	}

	public function insert_online_draft_data($data){

			$this->db->insert('wo_online_draft', $data);

			$insert_id = $this->db->insert_id();

			return $insert_id;

			//return true;

	}

	public function get_next_autoid($tableName){

			$sql="SHOW TABLE STATUS LIKE '$tableName'";

			$query = $this->db->query($sql);					 

			$row=$query->row_array();

			return $row['Auto_increment'];

	}

	public function get_txa_info_data($taxclass_id){

			$this->db->select('wo_taxclass.*');

	    	$this->db->from('wo_taxclass');

			$this->db->where('taxclass_id',$taxclass_id);

	    	$query = $this->db->get();					 

			$row=$query->row_array();

			return $row;

	}

	

	public function get_wo_document($document_id){

			$this->db->select('wo_work_order_documents.document_name');

	    	$this->db->from('wo_work_order_documents');

			$this->db->where('document_id',$document_id);

	    	$query = $this->db->get();					 

			$row=$query->row_array();

			return $row;

	}

	public function remove_wo_document($document_id){

		$this->db->where('document_id',$document_id);

		$this->db->delete('wo_work_order_documents');

		return true;

	}

	public function remove_shipping_data($customer_shipping_id){
		$this->db->where('customer_shipping_id',$customer_shipping_id);
		$this->db->delete('wo_customer_shipping');
		return true;

	}
	public function remove_shipping_data_new($wo_order_id,$shipping_customer_id){
		$this->db->where('wo_order_id',$wo_order_id);
		$this->db->where('shipping_customer_id',$shipping_customer_id);
		$this->db->delete('wo_customer_shipping');
		return true;

	}

	public function remove_billing_data($customer_billing_id){
		$this->db->where('customer_billing_id',$customer_billing_id);
		$this->db->delete('wo_customer_billing');
		return true;
	}
	public function remove_billing_data_new($wo_order_id,$billing_customer_id){
		$this->db->where('wo_order_id',$wo_order_id);
		$this->db->where('billing_customer_id',$billing_customer_id);
		$this->db->delete('wo_customer_billing');
		return true;
	}

	public function get_wo_documents($wo_order_id,$document_type){

			$sql="Select * from wo_work_order_documents WHERE wo_order_id='$wo_order_id' AND document_type='$document_type' ";    

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	

	public function get_wo_all_documents($wo_order_id){

			$sql="Select * from wo_work_order_documents WHERE wo_order_id='$wo_order_id'  ";    

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	

	

	public function remove_docs($wo_order_id){

		$this->db->where('wo_order_id',$wo_order_id);

		$this->db->delete('wo_work_order_documents');

		return true;

	}

	public function delete_wo_data($wo_order_id){
		$this->db->where('wo_order_id',$wo_order_id);
		$this->db->delete('wo_order_summary');
		return true;

	}

	

	public function remove_wo_summary($wo_order_id){
		$this->db->where('wo_order_id',$wo_order_id);
		$this->db->delete('wo_order_summary');
		return true;

	}

	

	public function remove_wo_data($order_id){
		$this->db->where('order_id',$order_id);
		$this->db->delete('wo_work_orders');
	//echo $this->db->last_query();;exit;
		return true;

	}

	

	public function get_order_summary_in_detail($wo_order_id){

			$this->db->select('wo_order_summary.*');

	    	$this->db->from('wo_order_summary');

			$this->db->where('wo_order_id',$wo_order_id);

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	public function get_order_summary_in_detail_online($wo_order_id){
			$this->db->select('wo_order_summary.*,wo_shipping_types.shipping_type_name');
	    	$this->db->from('wo_order_summary');
			$this->db->where('wo_order_id',$wo_order_id);
			$this->db->join('wo_shipping_types', 'wo_shipping_types.shipping_type_id = wo_order_summary.wo_shipping_type_id', 'Left');
			$this->db->order_by('wo_ref_no', 'asc');
	    	$query = $this->db->get();					 
			return $query->result_array();
	}

	

	

	public function get_order_summary($wo_order_id){
			$sql="Select * from wo_order_summary WHERE wo_order_id='$wo_order_id' ";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}


	public function get_order_summary_by_ref_no($wo_order_id,$refno){
			$sql="Select * from wo_order_summary WHERE wo_order_id='$wo_order_id' and wo_ref_no='$refno' ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}

	public function get_order_summary_by_summary_no($wo_order_id,$summary){
			$sql="Select * from wo_order_summary ws,wo_work_orders wo WHERE  wo.order_id=ws.wo_order_id and ws.wo_order_id='$wo_order_id' and order_summary_id='$summary' ";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}


	public function get_shipping_types(){

			$sql="Select * from wo_shipping_types WHERE shipping_type_status='1' ";    

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	public function get_all_active_shipping_modes(){

			$sql="Select * from wo_shipping_mode WHERE shipping_mode_status='1' ORDER BY shipping_mode_name";    

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}



	public function get_all_active_priority(){

			$sql="Select * from priority_master WHERE priority_status='1' ORDER BY priority_name";    

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	public function insert_billing_data($data){

			$this->db->insert('wo_customer_billing', $data);
//echo $str = $this->db->last_query();
			return true;

			

	}

	

	public function insert_shipping_data($data){
			$this->db->insert('wo_customer_shipping', $data);
			return true;

	}

	public function update_wo_data($data,$order_id){

			$this->db->where('order_id', $order_id);

			$this->db->update('wo_work_orders', $data);


			return true;

			

	}

	public function save_order_form_document($data){

			$this->db->insert('wo_work_order_documents', $data);

			return true;

			

	}

	public function get_order_data_by_uuid($order_uuid){
			$sql="Select
				wo_work_orders.*,
				wo_customer_shipping.customer_shipping_id,
				wo_customer_shipping.shipping_address,
				wo_customer_shipping.shipping_customer_id,
				wo_customer_billing.customer_billing_id,wo_customer_billing.billing_address,wo_customer_billing.billing_customer_id,
				wo_types.wo_type_name,leads_master.lead_code,customer_master.*,staff_master.staff_code,staff_master.staff_name,wo_order_nature.order_nature_name,
				priority_master.priority_name,priority_master.priority_color_code,wo_shipping_mode.shipping_mode_name,wo_status.wo_status_value,leads_master.lead_uuid
			from
				wo_work_orders
				LEFT JOIN wo_customer_shipping ON wo_customer_shipping.wo_order_id=wo_work_orders.order_id
				LEFT JOIN wo_customer_billing ON wo_customer_billing.wo_order_id=wo_work_orders.order_id
				LEFT JOIN wo_types ON wo_types.wo_type_id=wo_work_orders.orderform_type_id
				LEFT JOIN leads_master ON leads_master.lead_id=wo_work_orders.lead_id
				LEFT JOIN customer_master ON  customer_master.customer_id = wo_work_orders.wo_client_id
				LEFT JOIN staff_master ON staff_master.staff_id=wo_work_orders.wo_owner_id
				LEFT JOIN wo_order_nature ON wo_order_nature.order_nature_id=wo_work_orders.wo_order_nature_id
				LEFT JOIN priority_master ON priority_master.priority_id=wo_work_orders.wo_work_priority_id
				LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=wo_work_orders.wo_shipping_mode_id
				LEFT JOIN wo_status ON wo_status.wo_status_id=wo_work_orders.wo_status_id
			where 
				wo_work_orders.order_uuid='$order_uuid'";    
//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->row_array();

	}

	public function get_shipping_modes_by_id($shipping_mode_id){

			$sql="Select shipping_mode_name from wo_shipping_mode WHERE shipping_mode_id='$shipping_mode_id'";    

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}
public function get_order_sms_status($orderid,$column)
{
$sql="select count(*) as cnt  from sms_order_status where wo_order_id='$orderid' and $column='1'";
//error_log("Sql=====".$sql);
$query = $this->db->query($sql);
return $query->row_array();
}


public function get_online_order_sms_status($orderid,$summary_id,$column)
{
$sql="select count(*) as cnt  from sms_order_status where wo_order_id='$orderid' and wo_order_summary_id='$summary_id' and $column='1'";
//error_log("Sql=====".$sql);
$query = $this->db->query($sql);
return $query->row_array();
}



public function get_online_order_sms_completed($orderid,$summary_id)
{
$sql="select count(*) as cnt  from sms_order_status where wo_order_id='$orderid' and wo_order_summary_id='$summary_id'";
//error_log("Sql=====".$sql);
$query = $this->db->query($sql);
return $query->row_array();
}

public function get_offline_order_sms_completed($orderid)
{
$sql="select count(*) as cnt  from sms_order_status where wo_order_id='$orderid'";
//error_log("Sql=====".$sql);
$query = $this->db->query($sql);
return $query->row_array();
}


public function get_order_data_unit_type($order_uuid)
{
$sql="select orderform_type_id from wo_work_orders where order_id='$order_uuid'";
$query = $this->db->query($sql);
return $query->row_array();
}

	public function get_order_data_by_order_id($order_uuid){
			$sql="Select
				REPLACE(REPLACE(customer_master.customer_mobile_no,'+',''),' ','') as customer_mobile_no,scheduled_sms_status,orderform_number
			from
				wo_work_orders
				LEFT JOIN wo_customer_shipping ON wo_customer_shipping.wo_order_id=wo_work_orders.order_id
				LEFT JOIN wo_customer_billing ON wo_customer_billing.wo_order_id=wo_work_orders.order_id
				LEFT JOIN wo_types ON wo_types.wo_type_id=wo_work_orders.orderform_type_id
				LEFT JOIN leads_master ON leads_master.lead_id=wo_work_orders.lead_id
				LEFT JOIN customer_master ON  customer_master.customer_id = wo_work_orders.wo_client_id
				LEFT JOIN staff_master ON staff_master.staff_id=wo_work_orders.wo_owner_id
				LEFT JOIN wo_order_nature ON wo_order_nature.order_nature_id=wo_work_orders.wo_order_nature_id
				LEFT JOIN priority_master ON priority_master.priority_id=wo_work_orders.wo_work_priority_id
				LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=wo_work_orders.wo_shipping_mode_id
				LEFT JOIN wo_status ON wo_status.wo_status_id=wo_work_orders.wo_status_id
			where 
		wo_work_orders.orderform_type_id='1' and		wo_work_orders.order_id='$order_uuid'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();

	}



	public function get_order_data_by_orderfromnumber($order_uuid){
			$sql="Select
				wo_work_orders.*,
				wo_customer_shipping.customer_shipping_id,
				wo_customer_shipping.shipping_address,
				wo_customer_shipping.shipping_customer_id,
				wo_customer_billing.customer_billing_id,wo_customer_billing.billing_address,wo_customer_billing.billing_customer_id,
				wo_types.wo_type_name,leads_master.lead_code,customer_master.*,staff_master.staff_code,staff_master.staff_name,wo_order_nature.order_nature_name,
				priority_master.priority_name,priority_master.priority_color_code,wo_shipping_mode.shipping_mode_name,wo_status.wo_status_value,leads_master.lead_uuid
			from
				wo_work_orders
				LEFT JOIN wo_customer_shipping ON wo_customer_shipping.wo_order_id=wo_work_orders.order_id
				LEFT JOIN wo_customer_billing ON wo_customer_billing.wo_order_id=wo_work_orders.order_id
				LEFT JOIN wo_types ON wo_types.wo_type_id=wo_work_orders.orderform_type_id
				LEFT JOIN leads_master ON leads_master.lead_id=wo_work_orders.lead_id
				LEFT JOIN customer_master ON  customer_master.customer_id = wo_work_orders.wo_client_id
				LEFT JOIN staff_master ON staff_master.staff_id=wo_work_orders.wo_owner_id
				LEFT JOIN wo_order_nature ON wo_order_nature.order_nature_id=wo_work_orders.wo_order_nature_id
				LEFT JOIN priority_master ON priority_master.priority_id=wo_work_orders.wo_work_priority_id
				LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=wo_work_orders.wo_shipping_mode_id
				LEFT JOIN wo_status ON wo_status.wo_status_id=wo_work_orders.wo_status_id
			where 
				wo_work_orders.orderform_number='$order_uuid'";    


    		$query = $this->db->query($sql);					 
			return $query->row_array();

	}


	

	public function get_work_order($order_id){
			$sql="Select order_uuid,order_id,wo_shipping_cost,wo_additional_cost,wo_tax_value,wo_adjustment,wo_advance  from wo_work_orders where order_id='$order_id'";    
    		$query = $this->db->query($sql);					 
			return $query->row_array();

	}

	public function insert_wo_options($sql){    

    		$query = $this->db->query($sql);					 

			return true;

	}

	public function insert_work_summary($sql){    

    		$query = $this->db->query($sql);					 

			return true;

	}

	public function insert_work_order($data){

		

		$wo_tax_id=$data['wo_tax_id'];

		$sql="Select * from wo_taxclass WHERE taxclass_id='$wo_tax_id' ";    

    	$query = $this->db->query($sql);					 

		$taxRow=$query->row_array();

		

		$taxclass_name=$taxRow['taxclass_name'];

		$taxclass_value=$taxRow['taxclass_value'];

		

		$this->db->set('order_uuid', 'UUID()', FALSE);

		$this->db->set('wo_tax_name',$taxclass_name);

		$this->db->set('wo_tax_value',$taxclass_value);

		$this->db->insert('wo_work_orders', $data);

		$insert_id = $this->db->insert_id();

		

		$no=1000+$insert_id;

		$orderform_number="F".$no;

		$dataup = [

            'orderform_number' =>$orderform_number,

        ];

		$this->db->where('order_id', $insert_id);

        $this->db->update('wo_work_orders', $dataup);

		//print_r($this->db->last_query());

		return $insert_id;

	}

	public function check_order_no_exist($data,$condition){

			//print_r($data);

			$orderform_number=$data['orderform_number'];

			$this->db->select('wo_work_orders.orderform_number');

	    	$this->db->from('wo_work_orders');

			$this->db->where('orderform_number',$orderform_number);

			if($condition!=""){

			$this->db->where('order_id !=',$condition);

			}

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function check_lead_saved($data,$condition){

			//print_r($data);

			$lead_id=$data['lead_id'];

			$this->db->select('wo_work_orders.*');

	    	$this->db->from('wo_work_orders');

			$this->db->where('lead_id',$lead_id);

			if($condition!=""){

			$this->db->where('order_id !=',$condition);

			}

	    	$query = $this->db->get();	

			//print_r($this->db->last_query());

			return $query->row_array();

	}

	

	//_______________latest end

		

	

	public function get_order_date_info($orderform_id,$action_title){

			$this->db->select('wo_orderform_dates.*');

	    	$this->db->from('wo_orderform_dates');

			$this->db->where('orderform_id',$orderform_id);

			$this->db->where('action_title',$action_title);

	    	$query = $this->db->get();					 

			//print_r($this->db->last_query());

			return $query->row_array();

	}



	public function get_wo_data($uuid){

			$this->db->select('wo_orderform_master.*,wo_types.wo_type_name,wo_customer_data.*,wo_groups.*,wo_status.wo_status_title,staff_master.staff_code,staff_master.staff_name,wo_orderform_master.orderform_id as OID,wo_fabric_types.fabric_type_name,wo_collar_types.collar_type_name');

	    	$this->db->from('wo_orderform_master');

			$this->db->join('wo_types', 'wo_types.wo_type_id = wo_orderform_master.orderform_type_id', 'Left');

			$this->db->join('wo_customer_data', 'wo_customer_data.orderform_id = wo_orderform_master.orderform_id', 'Left');

			$this->db->join('wo_groups', 'wo_groups.wo_group_id = wo_orderform_master.group_id', 'Left');

			$this->db->join('wo_status', 'wo_status.wo_status_value = wo_orderform_master.orderform_status', 'Left');

			$this->db->join('staff_master', 'staff_master.staff_id = wo_orderform_master.order_owner_id', 'Left');

			$this->db->join('wo_fabric_types', 'wo_fabric_types.fabric_type_id = wo_orderform_master.fabric_type_id', 'Left');

			$this->db->join('wo_collar_types', 'wo_collar_types.collar_type_id = wo_orderform_master.collar_type_id', 'Left');

			$this->db->where('wo_orderform_master.orderform_uuid',$uuid);

	    	$query = $this->db->get();	

			//print_r($this->db->last_query());

			return $query->row_array();

	}	

	public function get_all_work_orders(){

			$this->db->select('wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,staff_master.staff_code,staff_master.staff_name');

	    	$this->db->from('wo_work_orders');

			$this->db->join('customer_master', 'customer_master.customer_id= wo_work_orders.wo_client_id', 'Left');

			$this->db->join('staff_master', 'staff_master.staff_id = wo_work_orders.wo_owner_id', 'Left');

			$this->db->order_by("wo_work_orders.order_id", "DESC");

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_all_work_orders_json($orderform_type_id){

			$wh =array();

			$SQL ='SELECT 	

				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class

			FROM wo_work_orders  ';

			$SQL.="LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id ";

			$SQL.="LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id ";

			$SQL.="LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id ";

			

			//$order_by=" ORDER BY  leads_master.lead_id DESC";

			//$finalSql=$SQL.$order_by;

			//echo $finalSql;

			if($this->session->userdata('wo_date')!='')

			$wh[]="wo_work_orders.wo_date = '".$this->session->userdata('wo_date')."'";

			

			if($this->session->userdata('wo_dispatch_date')!='')

			$wh[]="wo_work_orders.wo_dispatch_date = '".$this->session->userdata('wo_dispatch_date')."'";

			

			if($this->session->userdata('orderform_number')!='')

			$wh[]="wo_work_orders.orderform_number = '".$this->session->userdata('orderform_number')."'";

			

			if($this->session->userdata('wo_staff_name')!='')

			$wh[]="wo_work_orders.wo_staff_name LIKE '%".$this->session->userdata('wo_staff_name')."%'";

			

			if($this->session->userdata('wo_customer_name')!='')

			$wh[]="wo_work_orders.wo_customer_name LIKE '%".$this->session->userdata('wo_staff_name')."%'";

			

			if($this->session->userdata('wo_ref_numbers')!='')

			$wh[]="wo_work_orders.wo_ref_numbers LIKE '%".$this->session->userdata('wo_ref_numbers')."%'";

			

						

			if($this->session->userdata('wo_work_priority_id')!='')

			$wh[]="wo_work_orders.wo_work_priority_id = '".$this->session->userdata('wo_work_priority_id')."'";

			

			if($this->session->userdata('orderform_type_id')!='')

			$wh[]="wo_work_orders.orderform_type_id = '".$this->session->userdata('orderform_type_id')."'";

			

			

			$wh[] = " wo_work_orders.order_id != 0 AND wo_work_orders.orderform_type_id='$orderform_type_id' ";

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}





	

	

	public function get_taxclass(){

			$this->db->select('wo_taxclass.*');

	    	$this->db->from('wo_taxclass');

			$this->db->where('taxclass_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_addons(){

			$this->db->select('wo_addons.*');

	    	$this->db->from('wo_addons');

			$this->db->where('addon_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_order_nature(){

			$this->db->select('wo_order_nature.*');

	    	$this->db->from('wo_order_nature');

			$this->db->where('order_nature_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_product_types(){

			$this->db->select('wo_product_types.*');

	    	$this->db->from('wo_product_types');

			$this->db->where('product_type_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	public function get_sleeve_types(){

			$this->db->select('wo_sleeve_types.*');

	    	$this->db->from('wo_sleeve_types');

			$this->db->where('sleeve_type_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_collar_types(){

			$this->db->select('wo_collar_types.*');

	    	$this->db->from('wo_collar_types');

			$this->db->where('collar_type_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_fabric_types(){

			$this->db->select('wo_fabric_types.*');

	    	$this->db->from('wo_fabric_types');

			$this->db->where('fabric_type_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_order_types(){

			$this->db->select('wo_types.*');

	    	$this->db->from('wo_types');

			$this->db->where('wo_type_status','1');

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

function delete_rs_design_items($order_id,$ref_no)
{
	$SQL ="select rs.* from wo_order_summary w,
	                        rs_design_departments rs 
							where 
							rs.summary_item_id=w.order_summary_id 
							and  wo_order_id='".$order_id."' "; 

							$query = $this->db->query($SQL);
							echo $SQL;
							$dataArray =     $query->result_array();
							if ($dataArray) {
								foreach ($dataArray as  $row) {
				
								$dataJson = json_decode($row['submitted_item'], true);

							
							foreach ($dataJson as $postkey => $postvalue) {
								if ($dataJson[$postkey]['online_ref_number'] ==$ref_no ) {
								//	echo "<pre>";
								//	echo $postkey;
								unset($dataJson[$postkey]);
								}
							}
						//	echo "<pre>";
							//print_r($dataJson);
							$a = array_values($dataJson);
							print_r(json_encode($a));


							$SQLU ="update wo_order_summary w,
	                        rs_design_departments rs set submitted_item='".json_encode($a)."'
							where 
							rs.summary_item_id=w.order_summary_id 
							and  wo_order_id='".$order_id."' AND rs_design_id='".$row['rs_design_id']."' "; 

							$query = $this->db->query($SQLU);
							echo $SQLU;
							
							
								}
								$SQLD ="delete rs.* from wo_order_summary w,
								rs_design_departments rs where 
								rs.summary_item_id=w.order_summary_id 
								and  wo_order_id='".$order_id."' AND wo_ref_no='".$ref_no."' "; 
								
								echo $SQLD;
								$query = $this->db->query($SQLD);	
								
							}
return "success";
}



function delete_schedule_items($order_id,$ref_no)
{
	$SQL ="select sh_order_json,schedule_id ,schedule_order_info from sh_schedules where order_id='".$order_id."' "; 

							$query = $this->db->query($SQL);
							//echo $SQL;
							$dataArray =     $query->result_array();
							if ($dataArray) {
								foreach ($dataArray as  $row) {
				           $minus_qty=0;
								$dataJson = json_decode($row['sh_order_json'], true);

								$schedule_order_info=$row[schedule_order_info];

                            foreach ($dataJson as $postkey => $postvalue) {
								if ($dataJson[$postkey]['online_ref_number'] ==$ref_no ) {
									
									$ref_no_comma =$ref_no.',';	
									$result = str_replace($ref_no_comma, '', $schedule_order_info);	
									$result = str_replace($ref_no, '', $result);
									$minus_qty=$dataJson[$postkey]['item_unit_qty_input'];
								    unset($dataJson[$postkey]);
								}
							}
						
							$a = array_values($dataJson);
							//print_r(json_encode($a));


							$SQLU ="update sh_schedules SET  order_total_qty=(order_total_qty-'".$minus_qty."'),order_total_submitted_qty=(order_total_submitted_qty-'".$minus_qty."'),schedule_order_info='".$result."',sh_order_json='".json_encode($a)."' WHERE order_id='".$order_id."' AND schedule_id='".$row['schedule_id']."' "; 

							$query = $this->db->query($SQLU);
							//echo $SQLU;
							
							
								}	
							}
return "success";
}


function delete_schedule_department_items($order_id,$ref_no)
{
	$SQL ="select scheduled_order_info,schedule_department_id,total_order_items from sh_schedule_departments where order_id='".$order_id."' "; 

							$query = $this->db->query($SQL);
							//echo $SQL;
							$dataArray =     $query->result_array();
							if ($dataArray) {
								foreach ($dataArray as  $row) {
				//echo "Total -items ==".$row['total_order_items']."<br>";
				
								$dataJson = json_decode($row['scheduled_order_info'], true);
							//	echo "Total -items ==".count($dataJson)."<br>";
							$i=0;
							foreach ($dataJson as $postkey => $postvalue) {
								if ($dataJson[$postkey]['online_ref_number'] ==$ref_no ) {
								$i--;
								unset($dataJson[$postkey]);
								}
							}
						//	echo "Total items removed==".count($dataJson)."<br>";
							//echo "Total items removed==".$i."<br>";
							$a = array_values($dataJson);
							$b=count($dataJson);
							//print_r(json_encode($a));


							$SQLU ="update sh_schedule_departments SET scheduled_order_info='".json_encode($a)."' , total_order_items='".$b."' WHERE order_id='".$order_id."' AND schedule_department_id='".$row['schedule_department_id']."' "; 

								$query = $this->db->query($SQLU);
							//print_r($SQLU);
							//exit();
							
								}	
							}
return "success";
}

function update_work_order_items($orderid,$ref_no)
{

	$SQL ="select wo_ref_numbers from wo_work_orders where order_id='".$orderid."'"; 

							$query = $this->db->query($SQL);
					   $dataArray =     $query->row_array();
					   $ref_no_comma =$ref_no.',';	
					   $result = str_replace($ref_no_comma, '', $dataArray['wo_ref_numbers']);	
					   $result = str_replace($ref_no, '', $result);
					
					   $SQLU ="update wo_work_orders set wo_ref_numbers='".$result."'  where order_id='".$orderid."'"; 
						//echo $SQLU;
					   $query = $this->db->query($SQLU);

}

	//___________________________________________________ end of work order

	//____________________end of leads



	

}

?>