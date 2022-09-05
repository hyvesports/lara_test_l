<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount_model extends CI_Model{
	
	//-------------------------------
	
	
	
	public function get_design_data($summary_item_id,$from_department){
		$sql="Select * from rs_design_departments where summary_item_id='$summary_item_id' and from_department='$from_department' and verify_status='1'";  
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_last_updated_row_by_schedule_id($schedule_id,$summary_id,$fd,$td){
		$sel="SELECT * FROM rs_design_departments WHERE schedule_id='".$schedule_id."'  AND summary_item_id='".$summary_id."' and from_department='$fd' AND to_department='$td' ORDER BY rs_design_id DESC LIMIT 1 ";
		
		//echo $sel;
		$query = $this->db->query($sel);					 
		return $query->row_array();
		
	}
	public function get_last_updated_row($department_id,$summary_id,$fd,$td){
		$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$department_id."'  AND summary_item_id='".$summary_id."' and from_department='$fd' AND to_department='$td' ORDER BY rs_design_id DESC LIMIT 1 ";
		
		//echo $sel;
		$query = $this->db->query($sel);					 
		return $query->row_array();
		
	}
	public function check_any_rejection($schedule_department_id,$summary_id){    
    	$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
	FROM
		rj_scheduled_orders as RO
		LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
	WHERE
		RO.schedule_department_id='".$schedule_department_id."' AND
		RO.rej_summary_item_id='".$summary_id."'
		ORDER BY RO.rej_order_id DESC LIMIT 1";
		//echo $anyRejSql;
		$query = $this->db->query($anyRejSql);					 
		return $query->row_array();
	}
	
	public function get_my_orders_design_qc($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,SDS.is_verified,SDS.schedule_departments_status_id
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id,sh_schedule_departments_status SDS ";
			
			//echo $SQL;
			$wh[] = ' SDS.schedules_status_value=1 AND SDS.schedule_department_id=SHD.schedule_department_id AND SDS.submitted_to_dept_id='.$did.'  AND SDS.unit_id IN('.$unit_managed.')';
			
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_my_scheduled_orders($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				
				SHD.order_is_approved,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			
			//echo $SQL;
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')';
			
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	//-------------------------------
	
	public function update_schedule_deptmt_data($data,$schedule_department_id){
		$this->db->where('schedule_department_id', $schedule_department_id);
		$this->db->update('sh_schedule_departments',$data);
		//echo $this->db->last_query();;
		return true;
	}
	
	public function get_status_data_by_id($schedules_status_id){    
    	$sql="SELECT * FROM sh_schedules_status WHERE schedules_status_id='$schedules_status_id' ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function insert_status_data($data){    
    	$this->db->insert('sh_schedule_departments_status', $data);
		return true;
	}
	public function update_schedule_exist_data($data,$schedule_department_id){
		$this->db->where('schedule_department_id', $schedule_department_id);
		$this->db->update('sh_schedule_departments_status',$data);
		//echo $this->db->last_query();;
		return true;
	}
	
	public function check_schedule_exist($schedule_department_id,$schedules_status_id){    
    	$sql="SELECT * FROM sh_schedule_departments_status WHERE schedule_department_id='$schedule_department_id' AND schedules_status_id='$schedules_status_id'  ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	
	public function get_schedule_status_by_deptmt($schedules_status_department){    
    	$sql="SELECT * FROM sh_schedules_status WHERE schedules_status_department='$schedules_status_department' and schedules_status=1 ORDER BY schedules_status_order ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	public function get_my_order_scheduled_deptmt_data_by_id($schedule_department_id){    
    	$sql="SELECT * FROM sh_schedule_departments WHERE schedule_department_id ='$schedule_department_id'  ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_order_options($wo_order_id,$order_summary_id){    
    	$sql="SELECT * FROM wo_order_options WHERE wo_order_id='$wo_order_id' AND order_summary_id='$order_summary_id' ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	public function get_my_order_scheduled_data_by_uuid($schedule_uuid){    
    	$sql="SELECT 
			sh_schedules.*,login_master.log_full_name,WO.orderform_number,PO.production_unit_name
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
	
	public function get_my_orders($did){
			$wh =array();
			$SQL ='SELECT 	
				SH.*,WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,SHD.department_schedule_date,SHD.scheduled_order_info,SHD.schedule_department_id,SHD.department_schedule_status_value,SHD.order_is_approved
			FROM
				sh_schedules  AS SH
			';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SH.schedule_unit_id ";
			$SQL.=",sh_schedule_departments as SHD";
			
			//$order_by=" ORDER BY  leads_master.lead_id DESC";
			//$finalSql=$SQL.$order_by;
			//echo $finalSql;
			$wh[] = " SH.schedule_id!='0' AND SHD.schedule_id=SH.schedule_id AND FIND_IN_SET($did,SHD.department_ids)";
			if($did!=4){
			//$wh[]=" SHD.order_is_approved='1'  ";
			}
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_staff_profile_data($login_id){
			$sql="SELECT * FROM staff_master WHERE login_id='$login_id' ";   
			//echo $sql;
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}


}

?>