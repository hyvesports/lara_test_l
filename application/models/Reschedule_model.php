<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reschedule_model extends CI_Model{

	

	//get_order_details

	

	public function save_reschedule_data($data){

		$this->db->insert('sh_schedule_departments', $data);

		$insert_id = $this->db->insert_id();

		//return $insert_id;

		//echo $this->db->last_query();;

		return true;

	}

	public function get_production_department_names($department){

		$sql="SELECT GROUP_CONCAT(`department_name`) as DNAME FROM `department_master` WHERE `department_id` IN ($department) "; 

		//echo $sql;

    	$query = $this->db->query($sql);					 

		return $query->row_array();

	}

	

	public function get_schedule_department_row($schedule_department_id){

		$sql="Select * FROM sh_schedule_departments where schedule_department_id='$schedule_department_id'"; 

    	$query = $this->db->query($sql);					 

		return $query->row_array();

	}

	

	public function get_all_order_rejection_rows($schedule_id,$order_id,$rs_design_id){

		$sql="Select * FROM rj_scheduled_orders  where schedule_id='$schedule_id' and order_id='$order_id' and rs_design_id='$rs_design_id'  "; 

    	$query = $this->db->query($sql);					 

		return $query->result_array();

	}

	public function get_order_rejection_details($schedule_id,$order_id,$rs_design_id){

		$sql="Select * FROM rj_scheduled_orders  where schedule_id='$schedule_id' and order_id='$order_id' and rs_design_id='$rs_design_id' limit 1 "; 

    	$query = $this->db->query($sql);					 

		return $query->row_array();

	}

	public function get_order_response_details($rs_design_id){

		$sql="Select * FROM rs_design_departments where rs_design_id='$rs_design_id'"; 

    	$query = $this->db->query($sql);					 

		return $query->row_array();

	}

	public function get_order_details($order_id){

			$sql="Select

				wo_work_orders.*,wo_customer_shipping.customer_shipping_id,wo_customer_shipping.shipping_address,wo_customer_billing.customer_billing_id,wo_customer_billing.billing_address,wo_types.wo_type_name,leads_master.lead_code,customer_master.*,staff_master.staff_code,staff_master.staff_name,wo_order_nature.order_nature_name,

				priority_master.priority_name,priority_master.priority_color_code,wo_shipping_mode.shipping_mode_name,sh_schedules.schedule_id,CONCAT(staff_master.staff_code,'-',staff_master.staff_name) as sales_handler

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

				wo_work_orders.order_id='$order_id'";    

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	public function get_all_rejected_works($unit_managed){

			$wh =array();

			$sql='SELECT 

				RSO.*,WO.orderform_number,WO.wo_product_info,WO.wo_date_time,rs_design_departments.verify_remark,rs_design_departments.rejected_department,rs_design_departments.submitted_item

			FROM

				rj_scheduled_orders AS RSO 

				LEFT JOIN wo_work_orders as WO on WO.order_id=RSO.order_id

				LEFT JOIN rs_design_departments ON rs_design_departments.rs_design_id=RSO.rs_design_id

				';

			//echo $SQL;

			$where = ' WHERE RSO.rej_order_id!=0 ';

			if($unit_managed!='admin'){

				$where.=' AND  RSO.unit_id IN('.$unit_managed.')';

			}

			$where.=" GROUP BY RSO.rej_summary_item_id";

			$final_sql=$sql.$where;

			$query = $this->db->query($final_sql);					 

			return $query->result_array();

	}



}

?>