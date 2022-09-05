<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Bundling_model extends CI_Model{

	public function get_works_bundling($did,$unit_managed,$type){
			$cdate=date('Y-m-d');
			$wh =array();
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
			and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling") ';
				//
			}
			if($type=="completed"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')
			and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling") ';
			}
			$WHERE = implode(' and ',$wh);
//			error_log($SQL.$WHERE);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function get_completed_works($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
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
			//$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"';
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	public function get_pending_works($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date<"'.$cdate.'"';
			//$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	public function get_active_works($did,$unit_managed){
			$wh =array();
			$SQL='SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"';
			//$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	

	public function get_completed_works____($did,$unit_managed){

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

				rs_design_departments AS RDD,

				sh_schedule_departments AS SHD  ';

			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';

			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";

			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";

			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";

			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";

			//echo $SQL;

			$cdate=date('Y-m-d');

			$wh[] = '  SHD.unit_id IN('.$unit_managed.')  and

			SHD.schedule_department_id=RDD.schedule_department_id and 

			RDD.from_department="fusing" and

			RDD.to_department="bundling" and

			RDD.verify_status!=0  AND  RDD.status_value=1 AND RDD.approved_dept_id!=0 ';

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	public function get_pending_works______($did,$unit_managed){

			$wh =array();

			$SQL='SELECT 

				SH.*,

				SHD.department_schedule_date,

				SHD.scheduled_order_info,

				SHD.schedule_department_id,
				RDD.submitted_item,
				RDD.summary_item_id,
				SHD.order_is_approved,

				SHD.is_re_scheduled,

				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,

				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name

			FROM

				rs_design_departments AS RDD,

				sh_schedule_departments AS SHD  ';

			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';

			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";

			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";

			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";

			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";

			//echo $SQL;

			$cdate=date('Y-m-d');

			$wh[] = '  SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'" and

			SHD.schedule_department_id=RDD.schedule_department_id and 

			RDD.from_department="fusing" and

			RDD.to_department="bundling" and

			RDD.row_status="submitted" and 

			RDD.verify_status=0  AND  RDD.status_value=1 AND RDD.approved_dept_id=0 ';

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	public function get_all_works($did,$unit_managed){

			$wh =array();

			$SQL='SELECT 

				SH.*,

				SHD.department_schedule_date,

				SHD.scheduled_order_info,

				SHD.schedule_department_id,

				SHD.order_is_approved,

				SHD.is_re_scheduled,SHD.batch_number,

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

			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	

//------------------------------------------------------------------------------------------------------------------------------------------------------//	

	public function get_active_works_old($did,$unit_managed){

			$wh =array();

			$SQL='SELECT 

				SH.*,

				SHD.department_schedule_date,

				SHD.scheduled_order_info,

				SHD.schedule_department_id,

				SHD.order_is_approved,

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

			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date<=now()';

			

			$WHERE = implode(' and ',$wh);

			

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	

	public function check_bundling_completed_new($summary_item_id,$qc_name){

			$sql="Select * from rs_design_departments where  summary_item_id='$summary_item_id' and qc_name='$qc_name' ";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function check_bundling_completed($schedule_department_id,$summary_item_id,$qc_name){

			$sql="Select * from rs_design_departments where schedule_department_id='$schedule_department_id' AND summary_item_id='$summary_item_id' and qc_name='$qc_name' ";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	public function get_all_department_for_rejection_by_batch_no($schedule_id,$unit_id,$batch_number){
			$sql="Select * from sh_schedule_departments where schedule_id='$schedule_id' AND unit_id='$unit_id' and batch_number='$batch_number' "; 
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();

	}

	public function get_all_department_for_rejection($schedule_id,$unit_id){

			$sql="Select * from sh_schedule_departments where schedule_id='$schedule_id' AND unit_id='$unit_id'"; 

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	public function get_bundling_request_row($rs_design_id){

			$sql="Select * from rs_design_departments where rs_design_id='$rs_design_id'"; 

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function get_requested_works($did,$unit_managed){

			$wh =array();

			$SQL='SELECT 

				SH.*,

				SHD.department_schedule_date,

				SHD.scheduled_order_info,

				SHD.schedule_department_id,

				SHD.order_is_approved,

				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.submitted_item,RDD.summary_item_id,RDD.verify_remark,RDD.verify_datetime,RDD.response_remark,RDD.rs_design_id,RDD.verify_status

			FROM

				rs_design_departments AS RDD  ';

			

			$SQL.='LEFT JOIN sh_schedule_departments as SHD on SHD.schedule_department_id=RDD.schedule_department_id ';

			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';

			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";

			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";

			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";

			//echo $SQL;

			$wh[] = ' RDD.status_value=1 AND RDD.qc_name="fusing" and verify_status=0';

			

			$WHERE = implode(' and ',$wh);

			

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	public function get_pending_works_old($did,$unit_managed){

			$wh =array();

			$SQL='SELECT 

				SH.*,

				SHD.department_schedule_date,

				SHD.scheduled_order_info,

				SHD.schedule_department_id,

				SHD.order_is_approved,

				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,

				(SELECT count(*) as APP FROM  rs_design_departments as RDD WHERE RDD.schedule_id=SHD.schedule_id and RDD.status_value=1 AND qc_name="fusing" ) as APP_COUNT

			FROM

				sh_schedule_departments AS SHD  ';

			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';

			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";

			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";

			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";

			//echo $SQL;

			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date>now()';

			

			$WHERE = implode(' and ',$wh);

			

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	

	public function check_fusing_deptmt_submitted($summary_item_id,$qc_name){

			$sql="Select * from rs_design_departments where summary_item_id='$summary_item_id' and qc_name='$qc_name' and status_value='1'";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	

	

	public function get_my_design_requests($did,$unit_managed){

			$wh =array();

			$SQL='SELECT 

				DD.*,WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,SH.schedule_uuid

			FROM

				rs_design_departments as DD

				';

			$SQL.='LEFT JOIN sh_schedules  as SH on SH.schedule_id=DD.schedule_id ';

			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";

			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=DD.unit_id ";

			

			//echo $SQL;

			$wh[] = ' DD.status_value=1 AND DD.unit_id IN('.$unit_managed.')';

			

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	//------------------------------





}



?>