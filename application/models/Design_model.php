<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Design_model extends CI_Model{
	
	public function get_works_design($did,$unit_managed,$type){
			$wh =array();
			$cdate=date('Y-m-d');
			$SQL='SELECT 
				SH.schedule_uuid,
				SH.order_id,
				SH.schedule_id,
				SHD.batch_number,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			if($type=="all"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')  ';
			}
			if($type=="active"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"  ';
			}
			if($type=="pending"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date <"'.$cdate.'"
			and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design") ';
			}
			if($type=="completed"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')
			and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design") ';
			}
			$WHERE = implode(' and ',$wh);
		//echo $SQL.$WHERE;
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
//__________________________________________________________________________________________________________________________
	public function get_design_works_competed_new($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$SQL.= ' WHERE FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$SQL.='and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design")
			 ORDER BY  SHD.department_schedule_date DESC ';
			$query = $this->db->query($SQL);					 
			return $query->result_array();
			//$WHERE = implode(' and ',$wh);
			//return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_design_works_pending_new($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="design" ) as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="design") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="design") as REJECTED_COUNT
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$cdate=date('Y-m-d');
			$SQL.= 'WHERE FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date <"'.$cdate.'"
			and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design")
			 ORDER BY  SHD.department_schedule_date DESC ';
			$query = $this->db->query($SQL);		//echo $SQL;			 
			return $query->result_array();
			
			//$WHERE = implode(' and ',$wh);
			//return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_design_works_active_new($did,$unit_managed){
			$wh =array();
			$cdate=date('Y-m-d');
			$SQL='SELECT     
				SH.*, 
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="design" ) as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="design") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="design") as REJECTED_COUNT
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL; 
			$SQL.= ' WHERE FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"  ORDER BY  SHD.department_schedule_date DESC';
			$query = $this->db->query($SQL);					 
			return $query->result_array();
	}
	public function get_design_works_all_new($did,$unit_managed){
			$wh =array();
			//$cdate=date('Y-m-d');
			$SQL='SELECT 
				SH.*,
				SHD.batch_number,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="design") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="design") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="design") as REJECTED_COUNT
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$SQL.= ' WHERE FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ORDER BY  SHD.department_schedule_date DESC';
			//echo $SQL;
			$query = $this->db->query($SQL);					 
			return $query->result_array();
	}
	
	
	public function get_design_works_competed($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	
	
	public function get_design_works_pending($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$cdate=date('Y-m-d');
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date<"'.$cdate.'"
			';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_design_works_all($did,$unit_managed){
			$wh =array();
			//$cdate=date('Y-m-d');
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_design_works_active($did,$unit_managed){
			$wh =array();
			$cdate=date('Y-m-d');
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	
//______________________________________________________________________________________________________________________________________________	
	//
	public function get_my_order_scheduled_deptmt_data_by_id($schedule_department_id){    
    	$sql="SELECT * FROM sh_schedule_departments WHERE schedule_department_id ='$schedule_department_id'  ";
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
	public function get_design_works_approved($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.submitted_item,RDD.summary_item_id,RDD.verify_remark,RDD.verify_datetime,RDD.rejected_department
			FROM
				rs_design_departments AS RDD  ';
			$SQL.='LEFT JOIN sh_schedule_departments as SHD on SHD.schedule_department_id=RDD.schedule_department_id ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = ' RDD.qc_name="design" and RDD.verify_status=1 ';
			
			$WHERE = implode(' and ',$wh);
			
			return $this->datatable->LoadJson($SQL,$WHERE);
	}	
	public function get_design_works_rejected($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.submitted_item,RDD.summary_item_id,RDD.verify_remark,RDD.verify_datetime,RDD.rejected_department
			FROM
				rs_design_departments AS RDD  ';
			$SQL.='LEFT JOIN sh_schedule_departments as SHD on SHD.schedule_department_id=RDD.schedule_department_id ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = ' RDD.is_current=1 and RDD.verify_status=-1 ';
			
			$WHERE = implode(' and ',$wh);
			
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_design_works_upcoming($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date>=now()';
			
			$WHERE = implode(' and ',$wh);
			
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	public function get_design_works($did,$unit_managed){
			$wh =array();
			$cdate=date('Y-m-d');
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
			//echo $SQL;
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	
	
	
	
	

}

?>