<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Schedule_model extends CI_Model{
	//
	//insert_schedule_new_qty_row delete_schedule_wo_completed
	public function delete_schedule_wo_completed($schedule_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->delete('wo_completed');
		return true;
	}
	public function delete_schedule_rejection_latest($schedule_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->delete('sh_schedule_department_rejections');
		return true;
	}
	public function save_rejection_data($data){
		$this->db->insert('sh_schedule_department_rejections', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
		// $this->db->last_query();;
		return true;
	}
	public function save_reschedule_data($data){
		$this->db->insert('sh_schedule_departments', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
		//echo $this->db->last_query();;
		return true;
	}
	public function remove_qty_row($schedule_item_qty_id){
		$this->db->where('schedule_item_qty_id',$schedule_item_qty_id);
		$this->db->delete('sh_schedule_item_qty');
		return true;
	}	
	public function update_schedule_old_qty_row($data,$schedule_item_qty_id){
		$this->db->where('schedule_item_qty_id', $schedule_item_qty_id);
		$this->db->update('sh_schedule_item_qty',$data);
		//echo $this->db->last_query();;
		return true;
	}
	public function insert_schedule_new_qty_row($data){    
    	$this->db->insert('sh_schedule_item_qty', $data);
		$this->db->last_query();
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function update_schedule_qty_data($data,$scheduled_id,$orderid){
		$this->db->where('scheduled_id', $scheduled_id);
		$this->db->where('orderid', $orderid);
		$this->db->update('sh_schedule_item_qty',$data);
		//echo $this->db->last_query();;
		return true;
	}
	public function update_schedule_ids($data,$schedule_uuid){
		$this->db->where('schedule_uuid', $schedule_uuid);
		$this->db->update('sh_schedule_item_qty',$data);
		//echo $this->db->last_query();;
		return true;
	}
	public function get_allocated_count($unit_calendar_date,$unit_id){
		//wo_order_summary
		$sql="SELECT allocated_to_design,allocated_to_printing,allocated_to_fusing,allocated_to_bundling,allocated_to_finalqc,allocated_to_dispatch,unit_working_capacity_in_sec FROM pr_unit_calendar WHERE unit_calendar_date='$unit_calendar_date' and unit_id='$unit_id' limit 1";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_current_stage($schedule_id){
		//wo_order_summary
		date_default_timezone_set('Asia/Kolkata'); # add your city to set local time zone
		$now = date('Y-m-d');
		$sql="SELECT department_ids FROM sh_schedule_departments WHERE schedule_id='$schedule_id' and department_schedule_date='$now' ORDER BY schedule_department_id DESC limit 1  ";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function remove_unwanted_schedules(){
		//$this->db->where('department_ids','');
		//$this->db->delete('sh_schedule_departments');
		$sql="DELETE FROM sh_schedule_departments WHERE department_ids='' ";   
    	$query = $this->db->query($sql);	
		return true;
	}
	public function final_dispatch_dates($schedule_id,$schedule_department_id){
		//wo_order_summary
		$sql="SELECT sh_schedule_departments.department_schedule_date AS dates FROM sh_schedule_departments WHERE schedule_id='$schedule_id' AND FIND_IN_SET($schedule_department_id,department_ids)  ORDER BY sh_schedule_departments.schedule_department_id DESC LIMIT 1";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function check_any_schedule_exist_in_deptmt($department_schedule_date,$unit_id,$schedule_id,$order_id,$schedule_department_id){
		//wo_order_summary
		$sql="SELECT * FROM sh_schedule_departments WHERE department_schedule_date='$department_schedule_date' AND unit_id='$unit_id' AND schedule_id='$schedule_id' AND order_id='$order_id' AND FIND_IN_SET($schedule_department_id,department_ids) LIMIT 1 ";
		$sql2="SELECT * FROM sh_schedule_departments WHERE department_schedule_date='$department_schedule_date' AND unit_id='$unit_id'  AND order_id='$order_id' AND FIND_IN_SET($schedule_department_id,department_ids) LIMIT 1 ";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_unit_calender_date_info($unit_calendar_date,$unit_id){
		//wo_order_summary
		$sql="SELECT 
			pr_unit_calendar.*,pr_production_calendar.system_working_capacity_sec
		FROM
			pr_unit_calendar
			LEFT JOIN pr_production_calendar ON pr_production_calendar.calendar_id=pr_unit_calendar.calendar_id
		WHERE
			pr_unit_calendar.unit_id='$unit_id' AND
			pr_unit_calendar.unit_calendar_date='$unit_calendar_date' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_schedule_department_rows_by_schedule_id($schedule_id ){
		//wo_order_summary
		$sql="SELECT * FROM sh_schedule_departments WHERE schedule_id='$schedule_id' order by department_schedule_date ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function delete_dispatch_order_data($dispatch_order_id){
		$this->db->where('dispatch_order_id',$dispatch_order_id);
		$this->db->delete('tbl_dispatch');
		return true;
	}
	
	public function delete_schedule_updates($schedule_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->delete('rs_design_departments');
		return true;
	}


	public function delete_rs_design_department_item_data($schedule_id,$summary_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->where('summary_item_id',$summary_id);
		$this->db->delete('rs_design_departments');
		return true;
	}
	public function delete_rejected_order_data_online($schedule_id,$summary_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->where('rej_summary_item_id',$summary_id);
		$this->db->delete('rj_scheduled_orders');
		return true;
	}

	public function delete_rejected_order_data($schedule_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->delete('rj_scheduled_orders');
		return true;
	}
	public function delete_scheduled_item_qty_data($schedule_uuid){
		$this->db->where('schedule_uuid',$schedule_uuid);
		$this->db->delete('sh_schedule_item_qty');
		return true;
	}


	public function delete_scheduled_item_qty_data_online($orderId,$orderSummaryId){
		$this->db->where('order_summery_id',$orderSummaryId);
		$this->db->where('orderid',$orderId);
		$this->db->delete('sh_schedule_item_qty');
		return true;
	}
	public function delete_work_order_summary_referenece_data_online($orderId,$refNo){
		$sql="delete from wo_order_summary where wo_ref_no='$refNo' and wo_order_id='$orderId'";
//echo $sql;
$query = $this->db->query($sql);
                return true;

	}

	public function delete_work_order_summary_data_online($orderId,$orderSummaryId){
		$sql="delete from wo_order_summary where order_summary_id='$orderSummaryId' and wo_order_id='$orderId'";
//echo $sql;
$query = $this->db->query($sql);
                return true;

	}

	public function drop_scheduled_department_by_id($schedule_department_id){
		$this->db->where('schedule_department_id',$schedule_department_id);
		$this->db->delete('sh_schedule_departments');
		return true;
	}
	public function delete_scheduled_department_data($schedule_id){
		$this->db->where('schedule_id',$schedule_id);
		$this->db->delete('sh_schedule_departments');
		return true;
	}
	public function delete_scheduled_data($schedule_uuid){
		$this->db->where('schedule_uuid',$schedule_uuid);
		$this->db->delete('sh_schedules');
		return true;
	}
	public function get_scheduled_data_by_uuid($schedule_uuid){    
    	$sql="SELECT 
		sh_schedules.*,login_master.log_full_name,WO.orderform_number,PO.production_unit_name,WO.lead_id,CONCAT(SM.staff_code,'-',SM.staff_name) as sales_handler,WO.wo_product_info,WO.wo_special_requirement
		FROM
			sh_schedules 
			LEFT JOIN login_master ON login_master.login_master_id=sh_schedules.schedule_c_by
			LEFT JOIN wo_work_orders as WO on WO.order_id=sh_schedules.order_id
			LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0
			LEFT JOIN pr_production_units as PO on PO.production_unit_id=sh_schedules.schedule_unit_id
		WHERE
			sh_schedules.schedule_uuid='$schedule_uuid'";
//		echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_all_scheduled_orders(){
			$wh =array();
			$SQL ='SELECT 	
				SH.*,WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_ref_numbers,WO.wo_dispatch_date,WO.wo_product_info
			FROM
				sh_schedules  AS SH
			';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SH.schedule_unit_id ";
			//$order_by=" ORDER BY  leads_master.lead_id DESC";
			//$finalSql=$SQL.$order_by;
		//	echo $SQL;

			$wh[] = " SH.schedule_id!='0' ";
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_sum_of_scheduled_order($schedule_end_date,$schedule_unit_id){    
    	$sql="SELECT sum(scheduled_order_seconds) as SOS FROM sh_schedules WHERE schedule_end_date='$schedule_end_date' AND schedule_unit_id='$schedule_unit_id' ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_unit_day_info($unit_calendar_date,$unit_id){    
    	$sql="SELECT * FROM pr_unit_calendar WHERE unit_calendar_date='$unit_calendar_date' AND unit_id='$unit_id' ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	
	public function get_old_schedule_qty_info($schedule_department_id,$scheduled_id,$orderid,$order_summery_id){    
    	$sql="SELECT * FROM sh_schedule_item_qty WHERE scheduled_id='$scheduled_id' and orderid='$orderid' and FIND_IN_SET(".$schedule_department_id.",schedule_department_ids) and order_summery_id='$order_summery_id'";
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_old_schedule_date_info($schedule_department_id){    
    	$sql="SELECT * FROM sh_schedule_departments WHERE schedule_department_id='$schedule_department_id'";
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function insert_old_schedule_date_info($data){    
    	$this->db->insert('sh_schedule_departments_old', $data);
		return true;
	}
	public function change_schedule_date($data,$schedule_department_id){
		
		$this->db->where('schedule_department_id', $schedule_department_id);
		$this->db->update('sh_schedule_departments',$data);
		$this->save_items_ids($schedule_department_id);
		//echo $this->db->last_query();;
		return true;
	}
	public function save_items_ids($schedule_department_id){
			$sql="SELECT * FROM sh_schedule_departments WHERE schedule_department_id='$schedule_department_id' LIMIT 1";
			$query = $this->db->query($sql);					 
			$rsArray=$query->row_array();
			if($rsArray['scheduled_order_info']){
				$db_array=json_decode($rsArray['scheduled_order_info'],true);
				$design_pending_items_array=$rsArray['scheduled_order_info'];	
				$total_order_items=0;
				foreach($db_array as $postkey=>$postvalue){
					if($db_array[$postkey]['item_unit_qty_input']!=0){
						$total_order_items++;
					}
				}
				$update="UPDATE sh_schedule_departments SET total_order_items='$total_order_items' WHERE schedule_department_id='$schedule_department_id'  ";
				$query = $this->db->query($update);
			}
		

	}
	public function get_department_day_info($date,$unit_id,$did){
		$sql="SELECT * FROM sh_schedule_departments WHERE unit_id='$unit_id' AND order_id='$order_id' AND FIND_IN_SET($did,department_ids) LIMIT 1";
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_previous_department_and_date_for_qc($did,$order_id,$unit_id){
		$sql="SELECT * FROM sh_schedule_departments WHERE 
		unit_id='$unit_id' AND order_id='$order_id' AND FIND_IN_SET($did,department_ids) ORDER BY schedule_department_id DESC LIMIT 1";
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_previous_department_and_date($did,$order_id,$unit_id,$department_schedule_date){
		$sql="SELECT * FROM sh_schedule_departments WHERE 
		department_schedule_date<='$department_schedule_date' AND
		unit_id='$unit_id' AND order_id='$order_id' AND FIND_IN_SET($did,department_ids) ORDER BY schedule_department_id DESC LIMIT 1";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_next_department_and_date($did,$order_id,$unit_id,$department_schedule_date){
		$sql="SELECT * FROM sh_schedule_departments WHERE 
		department_schedule_date>='$department_schedule_date' AND
		unit_id='$unit_id' AND order_id='$order_id' AND FIND_IN_SET($did,department_ids) LIMIT 1";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_order_data_by_id_for_schedule($schedule_department_id,$did){
			$sql="SELECT
			SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id
		FROM
			sh_schedule_departments SHD
			LEFT JOIN sh_schedules as SHED on SHED.schedule_id=SHD.schedule_id
		WHERE 
			SHD.schedule_department_id='$schedule_department_id' AND FIND_IN_SET($did,SHD.department_ids) GROUP BY SHD.schedule_id ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}	
	public function get_shedule_department_row_by_id($schedule_department_id){
		//wo_order_summary
		$sql="SELECT * FROM sh_schedule_departments WHERE schedule_department_id='$schedule_department_id' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
//------------------------------------------------------------------------
	public function get_production_start_date_from_calendar_for_online($current_date){
		//wo_order_summary
		$sql="SELECT calendar_date as START_DATE FROM `pr_production_calendar` WHERE DATE(calendar_date) >= DATE('".$current_date."' + INTERVAL 1 DAY) AND working_type='yes' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_production_start_date_from_calendar_for_offfline($wo_dispatch_date){
		//wo_order_summary
		$sql="SELECT calendar_date as START_DATE FROM `pr_production_calendar` WHERE DATE(calendar_date) = DATE('".$wo_dispatch_date."' - INTERVAL 9 DAY) AND working_type='yes' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function update_schedule_data($data,$schedule_id){
		$this->db->where('schedule_id', $schedule_id);
		$this->db->update('sh_schedules',$data);
		//echo $this->db->last_query();;
		return true;
	}
	public function get_sh_items_total($orderid){
		//wo_order_summary
		$sql="SELECT sum(sh_schedule_item_qty.sh_qty) as SHQTY FROM sh_schedule_item_qty WHERE orderid='$orderid'";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	
public function get_wo_items_total($wo_order_id){
		//wo_order_summary
		$sql="SELECT sum(wo_order_summary.wo_qty) as WOQTY FROM wo_order_summary WHERE wo_order_id='$wo_order_id'";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_each_date_and_deptmt_not_dispatched_new($department_schedule_date,$did,$unit_id){
		//wo_order_summary
		$sql="SELECT
		SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id,wo_work_orders.orderform_number,priority_master.priority_name,priority_master.priority_color_code,SHD.scheduled_order_info,SHD.order_id,SHD.is_re_scheduled,SHD.rej_items
		FROM
			sh_schedule_departments SHD,
			sh_schedules as SHED 
			LEFT JOIN wo_work_orders on wo_work_orders.order_id=SHED.order_id
			LEFT JOIN priority_master ON priority_master.priority_id=wo_work_orders.wo_work_priority_id
		WHERE
			SHD.department_schedule_date='$department_schedule_date' AND FIND_IN_SET($did,SHD.department_ids) and SHED.schedule_id=SHD.schedule_id and SHD.unit_id='$unit_id' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_each_date_and_deptmt_not_dispatched($department_schedule_date,$did){
		//wo_order_summary
		$sql="SELECT
 SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id,wo_work_orders.orderform_number,priority_master.priority_name,priority_master.priority_color_code,SHD.scheduled_order_info,SHD.order_id,SHD.is_re_scheduled,SHD.rej_items
	FROM
			sh_schedule_departments SHD
			LEFT JOIN sh_schedules as SHED on SHED.schedule_id=SHD.schedule_id
			LEFT JOIN wo_work_orders on wo_work_orders.order_id=SHD.order_id
			LEFT JOIN priority_master ON priority_master.priority_id=wo_work_orders.wo_work_priority_id
		WHERE
			SHD.department_schedule_date='$department_schedule_date' AND FIND_IN_SET($did,SHD.department_ids)  ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_each_date_and_deptmt_new($department_schedule_date,$did){
		//wo_order_summary
		$sql="SELECT
SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id,wo_work_orders.orderform_number,priority_master.priority_name,priority_master.priority_color_code,SHD.scheduled_order_info
		FROM
			sh_schedule_departments SHD
			LEFT JOIN sh_schedules as SHED on SHED.schedule_id=SHD.schedule_id
			LEFT JOIN wo_work_orders on wo_work_orders.order_id=SHD.order_id
			LEFT JOIN priority_master ON priority_master.priority_id=wo_work_orders.wo_work_priority_id
		WHERE 
			SHD.department_schedule_date='$department_schedule_date' AND FIND_IN_SET($did,SHD.department_ids) GROUP BY SHD.order_id  ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_orders_under_date_and_depmt_latest($department_schedule_date,$did,$unit_id,$schedule_department_id){
		//wo_order_summary
		$sql="SELECT
			SHD.rej_items,SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id,SHD.scheduled_order_info
		FROM
			sh_schedule_departments SHD
			LEFT JOIN sh_schedules as SHED on SHED.schedule_id=SHD.schedule_id
		WHERE 
			SHD.department_schedule_date='$department_schedule_date' AND
			FIND_IN_SET($did,SHD.department_ids) AND
			SHD.unit_id='$unit_id' AND SHD.schedule_department_id='$schedule_department_id' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_orders_under_date_and_depmt($department_schedule_date,$did,$unit_id){
		//wo_order_summary
		$sql="SELECT
			SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id,SHD.scheduled_order_info
		FROM
			sh_schedule_departments SHD
			LEFT JOIN sh_schedules as SHED on SHED.schedule_id=SHD.schedule_id
		WHERE 
			SHD.department_schedule_date='$department_schedule_date' AND
			FIND_IN_SET($did,SHD.department_ids) AND
			SHD.unit_id='$unit_id' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_each_date_and_deptmt($department_schedule_date,$did){
		//wo_order_summary
		$sql="SELECT
			SHD.schedule_department_id,SHD.schedule_id,SHD.department_ids,SHED.sh_order_json,department_schedule_date,SHED.schedule_unit_id
		FROM
			sh_schedule_departments SHD
			LEFT JOIN sh_schedules as SHED on SHED.schedule_id=SHD.schedule_id
		WHERE 
			SHD.department_schedule_date='$department_schedule_date' AND FIND_IN_SET($did,SHD.department_ids) GROUP BY SHD.schedule_id ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}

	public function get_dates_from_scheduled_dptmt_by_order_view($order_id){
		//wo_order_summary
		$sql="SELECT DISTINCT
			department_schedule_date as DSD,
			sh_schedule_departments.schedule_department_id
		FROM 
			sh_schedule_departments
		WHERE 
			order_id='$order_id' ";   
		$sql.="  GROUP BY department_schedule_date";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}

	public function get_dates_from_scheduled_dptmt_by_order_view_search($order_id){
		//wo_order_summary
		$sql="SELECT DISTINCT
			department_schedule_date as DSD,
			sh_schedule_departments.schedule_department_id
		FROM 
			sh_schedule_departments
		sh_schedule_departments,wo_work_orders WHERE sh_schedule_departments.order_id=wo_work_orders.order_id and  orderform_number='$order_id'";  
		$sql.="  GROUP BY department_schedule_date";
//			 echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}



	public function get_dates_from_scheduled_dptmt_by_order($order_id){
		//wo_order_summary
		$sql="SELECT DISTINCT
			department_schedule_date as DSD,
			sh_schedule_departments.schedule_department_id
		FROM 
			sh_schedule_departments
		WHERE 
			order_id='$order_id' ";   
		$sql.="  GROUP BY department_schedule_date LIMIT 5";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_dates_from_scheduled_dptmt($sdate,$edate,$unit_id){
		//wo_order_summary
		$sql="SELECT DISTINCT
			sh_schedule_departments.department_schedule_date as DSD,
			sh_schedule_departments.schedule_department_id,
			PCU.allocated_to_design,
			PCU.collected_from_design,
			PCU.allocated_to_printing,
			PCU.collected_from_printing,
			PCU.allocated_to_fusing,
			PCU.collected_from_fusing,
			PCU.allocated_to_bundling,
			PCU.collected_to_bundling
		FROM 
			sh_schedule_departments
			LEFT JOIN pr_unit_calendar as PCU on PCU.unit_calendar_date=sh_schedule_departments.department_schedule_date AND PCU.unit_id=sh_schedule_departments.unit_id
		WHERE
			sh_schedule_departments.department_schedule_date>='$sdate' AND 
			sh_schedule_departments.department_schedule_date<='$edate'";   
		if($unit_id!=""){
			$sql.=" AND sh_schedule_departments.unit_id='$unit_id' ";
		}
		$sql.="  GROUP BY sh_schedule_departments.department_schedule_date";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_item_total_qty($order_summery_id){
		//wo_order_summary
		$sql="Select sum(sh_qty) as TQ FROM sh_schedule_item_qty WHERE order_summery_id='$order_summery_id' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function save_schedule_qty_data($sql){    
    		$query = $this->db->query($sql);					 
			return true;
	}
	public function update_unit_calender_time($data,$schedule_date,$unitid){
		$this->db->where('unit_calendar_date',$schedule_date);
		$this->db->where('unit_id', $unitid);
	$this->db->update('pr_unit_calendar',$data);
		//echo $this->db->last_query();;
		return true;
	}
	public function get_all_scheduled_working_seconds($schedule_date){
		//wo_order_summary
		$sql="Select sum(total_order_second) as TOS FROM sh_schedules WHERE schedule_date='$schedule_date' ";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function save_department_data($data){
		$this->db->insert('sh_schedule_departments', $data);
		$insert_id = $this->db->insert_id();
		$this->save_items_ids($insert_id);
		return $insert_id;
		//echo $this->db->last_query();;
		//return true;
	}
	public function save_schedule_data($data){
		$this->db->insert('sh_schedules', $data);
		$insert_id = $this->db->insert_id();
		//echo $this->db->last_query();;
		return $insert_id;
		
		//return true;
	}
	//------------------------------------------------------------------------
	public function get_schedule_uuid(){
		//wo_order_summary
		$sql="Select uuid() as uid";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}

	public function get_schedule_uuid_order($orderId){
		//wo_order_summary
		$sql="Select schedule_uuid from sh_schedules where order_id='".$orderId."'";   
//		echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}

	public function get_schedule_id_order($orderId){
		//wo_order_summary
		$sql="Select schedule_id from sh_schedules where order_id='".$orderId."'";   
//		echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}

	public function get_order_summary_in_detail_info($wo_order_id){
		//wo_order_summary
		$sql="Select sum(wo_qty) as QTY,wo_product_type_name from wo_order_summary WHERE wo_order_id='$wo_order_id' GROUP BY `wo_product_type_id` ASC";   
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	//------------------------------------------------------------------------
	function get_my_business_unit($unit_managed_by){
		$sql="Select * from pr_production_units WHERE production_unit_status='1'";  
	if($unit_managed_by!=""){
			$sql.=" AND unit_managed_by='$unit_managed_by' ";
		}
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	//------------------------------------------------------------------------
	public function get_all_production_active_units($unitIds){
			$sql="Select * from pr_production_units WHERE production_unit_status='1' AND production_unit_id IN ($unitIds) ORDER BY `production_unit_id` ASC";   
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}

	public function get_all_disabiled_days($calendar_date){
		$sql="SELECT GROUP_CONCAT(calendar_date) as CDATE FROM `pr_production_calendar` WHERE `working_type` ='no' AND calendar_date>='$calendar_date' "; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_all_disabiled_days_d_m_y($calendar_date){
		$sql="SELECT GROUP_CONCAT(DATE_FORMAT(calendar_date,'%d-%m-%Y')) as CDATE FROM `pr_production_calendar` WHERE `working_type` ='no' AND calendar_date>='$calendar_date' "; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_staff_details_by_department($department){
		$sql="SELECT `staff_id`,CONCAT(staff_code,'-',staff_name) as STAFF FROM `staff_master` where FIND_IN_SET('".$department."',`department_managed`)"; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	//------------------------------------------------------------------------
	public function get_production_department_row($department){
		$sql="SELECT `department_name`,department_id FROM `department_master` WHERE `department_id` ='$department' "; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_production_department_names($department){
		$sql="SELECT GROUP_CONCAT(`department_name`) as DNAME FROM `department_master` WHERE `department_id` IN ($department) "; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
//------------------------------------------------------------------------
	public function get_production_departments(){
		$sql="SELECT * FROM `department_master` WHERE department_parent='3' ORDER BY `department_master`.`department_order` ASC "; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	//------------------------------------------------------------------------
	public function get_productions_available_days_with_unit($calendar_date,$limit,$unit_id){
		$sql="SELECT
			PC.*,
			PUC.unit_work,
			PUC.unit_calendar_date,
			PUC.unit_working_capacity_in_sec,
			PUC.schedule_unit_percentage,
			PUC.schedule_unit_percentage_sec
		FROM 
			`pr_production_calendar` as PC,pr_unit_calendar as PUC
		WHERE
			PC.calendar_id=PUC.calendar_id AND PUC.unit_id='$unit_id' AND
			PC.calendar_date>='$calendar_date' and
			PC.working_type='yes' ORDER BY PC.calendar_id  limit $limit"; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_productions_available_days($calendar_date,$limit){
		$sql="SELECT * FROM `pr_production_calendar` WHERE `calendar_date`>='$calendar_date' and `working_type`='yes' ORDER BY `calendar_id` ASC limit $limit"; 
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
//------------------------------------------------------------------------
	public function get_system_production_days($system_master_code){
		$sql="Select * from system_master where system_master_code='$system_master_code' LIMIT 1";    
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	//------------------------------------------------------------------------
}
?>