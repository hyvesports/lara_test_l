<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Accounts_model extends CI_Model{

	public function get_all_completed_works($orderform_type_id){
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
			if($this->session->userdata('orderform_type_id')!='')
			$wh[]="wo_work_orders.orderform_type_id = '".$this->session->userdata('orderform_type_id')."'";
			$wh[] = " wo_work_orders.order_id != 0 AND wo_work_orders.orderform_type_id='$orderform_type_id' 
AND ";
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	public function get_final_qc_data_for_accounts($rs_design_id){    
    	$sql="SELECT 
			RDD.*,LM.log_full_name,CONCAT(SM.staff_code,'-',SM.staff_name) as submitted_person,CONCAT(DM.designation_name,',',DPM.department_name) as staff_role
		FROM
			rs_design_departments as RDD
			LEFT JOIN login_master as LM on LM.login_master_id=RDD.approved_by
			LEFT JOIN staff_master as SM on SM.login_id=LM.login_master_id
			LEFT JOIN designation_master as DM on DM.designation_id=SM.designation_id
			LEFT JOIN department_master as DPM on DPM.department_id=SM.department_id 
		WHERE
			RDD.rs_design_id='$rs_design_id'";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_scheduled_data_by_uuid($schedule_uuid){    
    	$sql="SELECT 
			sh_schedules.*,login_master.log_full_name,WO.orderform_number,PO.production_unit_name,WO.orderform_type_id,WO.wo_owner_id
		FROM
			sh_schedules 
			LEFT JOIN login_master ON login_master.login_master_id=sh_schedules.schedule_c_by
			LEFT JOIN wo_work_orders as WO on WO.order_id=sh_schedules.order_id
			LEFT JOIN pr_production_units as PO on PO.production_unit_id=sh_schedules.schedule_unit_id
		WHERE
			sh_schedules.schedule_uuid='$schedule_uuid'";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_all_completed_work_orders($unit_managed){
			$wh =array();
			$SQL ='SELECT 	
				SH.*,WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_ref_numbers,
				RDD.rs_design_id,RDD.summary_item_id,RDD.verify_datetime,LM.log_full_name,CONCAT(SM.staff_code,"-",SM.staff_name) as submitted_person,CONCAT(DM.designation_name,",",DPM.department_name) as staff_role,RDD.accounts_status
			FROM
				sh_schedules  AS SH
			';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SH.schedule_unit_id ";
			$SQL.=",rs_design_departments as RDD ";
			$SQL.="LEFT JOIN login_master as LM on LM.login_master_id=RDD.approved_by ";
			$SQL.="LEFT JOIN staff_master as SM on SM.login_id=LM.login_master_id ";
			$SQL.="LEFT JOIN designation_master as DM on DM.designation_id=SM.designation_id ";
			$SQL.="LEFT JOIN department_master as DPM on DPM.department_id=SM.department_id ";
			//$order_by=" ORDER BY  leads_master.lead_id DESC";
			//$finalSql=$SQL.$order_by;
			//echo $finalSql;
			$wh[] = " SH.schedule_id!='0' and RDD.schedule_id=SH.schedule_id AND RDD.submitted_to_accounts=1 ";
			if($unit_managed!='admin'){ $wh[]='  SH.schedule_unit_id IN('.$unit_managed.')'; }
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	//------------------------------------------------------------------------------------------------------------------------------
	//
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
	//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}

}
