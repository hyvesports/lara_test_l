<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Fusing_model extends CI_Model{
	public function get_works_fusing($did,$unit_managed,$type){
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
			and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing") ';
			}
			if($type=="completed"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')
			and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing") ';
			}
			$WHERE = implode(' and ',$wh);
			//echo $SQL.$WHERE;
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
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
			//$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'"';
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	public function get_pending_works_latest($did,$unit_managed){
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'"';
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'" ';
			//$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') ';
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

	public function get_completed_works________________________________($did,$unit_managed){

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

			$wh[] = '  SHD.unit_id IN('.$unit_managed.') and 

			SHD.schedule_department_id=RDD.schedule_department_id and 

			RDD.status_value=1 AND RDD.qc_name="fusing" and

			SHD.schedule_department_id=RDD.schedule_department_id and

			RDD.from_department="fusing" and

			RDD.to_department="bundling" and

			RDD.row_status="submitted"  ';

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	public function get_pending_works_latest______________($did,$unit_managed){
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'"';
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
			$wh[] = ' FIND_IN_SET('.$did.',SHD.department_ids) and SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'" and
			SHD.schedule_department_id=RDD.schedule_department_id and 
			RDD.to_department="fusing" and
			RDD.row_status="submitted" and RDD.fusing_submitted=0 ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);

	}
	//-------------------------------
	//
	public function get_fusing_request_row($rs_design_id){

			$sql="Select * from rs_design_departments where rs_design_id='$rs_design_id'"; 

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}

	

	public function get_submitted_works($did,$unit_managed){

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

			$wh[] = ' RDD.submitted_by="'.$this->session->userdata('loginid').'" and RDD.status_value=1 AND RDD.qc_name="fusing"';

			

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

				(SELECT count(*) as APP FROM  rs_design_departments as RDD WHERE RDD.schedule_id=SHD.schedule_id and RDD.verify_status=1 AND qc_name="printing" ) as APP_COUNT

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

	

	public function check_printing_deptmt_submitted($summary_item_id,$qc_name){

			$sql="Select * from rs_design_departments where summary_item_id='$summary_item_id' and qc_name='$qc_name' and verify_status='1'";  

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