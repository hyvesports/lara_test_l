<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Order_model extends CI_Model{

	

	public function get_order_data_by_uuid_for_schedule($order_uuid){

			$sql="Select

				wo_work_orders.*,wo_customer_shipping.customer_shipping_id,wo_customer_shipping.shipping_address,wo_customer_billing.customer_billing_id,wo_customer_billing.billing_address,wo_types.wo_type_name,leads_master.lead_code,customer_master.*,staff_master.staff_code,staff_master.staff_name,wo_order_nature.order_nature_name,

				priority_master.priority_name,priority_master.priority_color_code,wo_shipping_mode.shipping_mode_name,sh_schedules.schedule_id

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

				LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1 

			where 

				wo_work_orders.order_uuid='$order_uuid'";    

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}	

	

	public function get_all_online_production_orders(){
			$wh =array();
			$SQL ='SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  ';
			$SQL.="LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id ";
			$SQL.="LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id ";
			$SQL.="LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id ";
			$SQL.="LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1 ";
			//$order_by=" ORDER BY  leads_master.lead_id DESC";
			//$finalSql=$SQL.$order_by;
			//echo $finalSql;
			if($this->session->userdata('is_scheduled')!=''){
				if($this->session->userdata('is_scheduled')==1){
				$wh[]="wo_work_orders.order_id=(SELECT JT2.order_id FROM sh_schedules as JT2 WHERE JT2.order_id=wo_work_orders.order_id LIMIT 1)";
				}else{
				$wh[]="wo_work_orders.order_id  NOT IN (SELECT JT2.order_id FROM sh_schedules as JT2 WHERE JT2.order_id=wo_work_orders.order_id )";
				}
			}	

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

			$wh[] = " wo_work_orders.orderform_type_id='2' AND wo_work_orders.order_id != 0 and wo_work_orders.wo_row_status=1  and submited_to_production='yes'";
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	

	//--------------------------------------------------------------------------------------------------------------------------

	

	public function get_order_summary_in_detail_list($wo_order_id){

			$this->db->select('wo_order_summary.*,');

	    	$this->db->from('wo_order_summary');

			$this->db->where('wo_order_id',$wo_order_id);

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	public function get_sum_making_time($order_id){

		$sql="Select

			(sum(wo_product_making_time)+sum(wo_collar_making_min)+sum(wo_sleeve_making_time)+sum(wo_fabric_making_min)+sum(wo_addon_making_min)) as total_making_time,

			sum(wo_qty) as total_making_qty

		FROM

			wo_order_summary where wo_order_id='$order_id'"; 

			

			

    	$query = $this->db->query($sql);					 

		return $query->row_array();

	}

	public function get_all_offline_production_orders(){
			$wh =array();
			$SQL ='SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  ';
			$SQL.="LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id ";
			$SQL.="LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id ";
			$SQL.="LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id ";
			$SQL.="LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1 ";
			//$order_by=" ORDER BY  leads_master.lead_id DESC";
			//$finalSql=$SQL.$order_by;
			//echo $finalSql;
			if($this->session->userdata('offline_is_scheduled')!=''){
				if($this->session->userdata('offline_is_scheduled')==1){
				$wh[]="wo_work_orders.order_id=(SELECT JT2.order_id FROM sh_schedules as JT2 WHERE JT2.order_id=wo_work_orders.order_id LIMIT 1)";
				}else{
				$wh[]="wo_work_orders.order_id  NOT IN (SELECT JT2.order_id FROM sh_schedules as JT2 WHERE JT2.order_id=wo_work_orders.order_id )";
				}
			}	


			if($this->session->userdata('offline_wo_date')!='')
			$wh[]="wo_work_orders.wo_date = '".$this->session->userdata('offline_wo_date')."'";
	
			if($this->session->userdata('offline_wo_dispatch_date')!='')
			$wh[]="wo_work_orders.wo_dispatch_date = '".$this->session->userdata('offline_wo_dispatch_date')."'";
			
			if($this->session->userdata('offline_orderform_number')!='')
			$wh[]="wo_work_orders.orderform_number = '".$this->session->userdata('offline_orderform_number')."'";
		
			if($this->session->userdata('offline_wo_dispatch_date')!='')
			$wh[]="wo_work_orders.wo_staff_name LIKE '%".$this->session->userdata('offline_wo_dispatch_date')."%'";
		
			if($this->session->userdata('offline_wo_dispatch_date')!='')
			$wh[]="wo_work_orders.wo_customer_name LIKE '%".$this->session->userdata('offline_wo_dispatch_date')."%'";
			
			if($this->session->userdata('offline_wo_work_priority_id')!='')
			$wh[]="wo_work_orders.wo_work_priority_id = '".$this->session->userdata('offline_wo_work_priority_id')."'";

			if($this->session->userdata('offline_orderform_type_id')!='')
			$wh[]="wo_work_orders.orderform_type_id = '".$this->session->userdata('offline_orderform_type_id')."'";
			
			//print_r($wh);
			$wh[] = "wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1";
			$WHERE = implode(' and ',$wh);
			//echo $SQL;
			return $this->datatable->LoadJson($SQL,$WHERE);

	}





	

}

?>