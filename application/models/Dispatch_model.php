<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dispatch_model extends CI_Model{
	//get_pending_works 
	//update_tracking
	//get_works_dispatch
	public function get_works_dispatch($did,$unit_managed,$type){
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
SHD.total_order_items as TOTAL_COUNT,IFNULL(WO.accounts_completed_status,0) as account_status
			FROM
				sh_schedule_departments AS SHD  ';
			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
			$SQL.="LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";



			if($type=="all"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')  ';
			}
			if($type=="active"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') AND SHD.department_schedule_date="'.$cdate.'"  ';
			}
			if($type=="pending"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date <"'.$cdate.'" 
			and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T111 WHERE T111.schedule_id=SHD.schedule_id and T111.is_current=1 and T111.to_department="final_qc" and T111.verify_status=1) ';
				// AND SHD.department_schedule_date <"'.$cdate.'"
			}
			if($type=="completed"){
				$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')
			and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="final_qc" and T11.verify_status=1) ';
			}
			$GROUP_BY ="GROUP BY SHD.order_id";
			$WHERE = implode(' and ',$wh);
		//echo $SQL.$WHERE;

			return $this->datatable->LoadJson($SQL,$WHERE,$GROUP_BY);
	}
	public function get_all_pending_works($did,$unit_managed){
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'"   ';
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}	

	public function get_all_active_works($did,$unit_managed){
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date="'.$cdate.'"   ';
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
			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')   ';
			$WHERE = implode(' and ',$wh);
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

			$wh[] = ' SHD.unit_id IN('.$unit_managed.') and

			SHD.schedule_department_id=RDD.schedule_department_id and 

			RDD.accounts_status=1 and RDD.submitted_to_dispatch=1 ';

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

			$wh[] = ' SHD.unit_id IN('.$unit_managed.') and SHD.department_schedule_date<"'.$cdate.'" and

			SHD.schedule_department_id=RDD.schedule_department_id and 

			RDD.accounts_status=1 and RDD.submitted_to_dispatch=0 ';

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	

	public function get_active_works___________($did,$unit_managed){

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

			$wh[] = 'FIND_IN_SET('.$did.',SHD.department_ids) AND SHD.unit_id IN('.$unit_managed.')  AND SHD.department_schedule_date="'.$cdate.'" ';

			$WHERE = implode(' and ',$wh);

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	//------------------------------- update_dispatch
	public function delete_dispatch($tracking_id){
		$this->db->where('tracking_id',$tracking_id);
		$this->db->delete('tbl_dispatch');
		return true;
	}
	
	public function delete_tracking($dispatch_tracking_id){
		$this->db->where('dispatch_tracking_id',$dispatch_tracking_id);
		$this->db->delete('tbl_dispatch_tracking');
		return true;
	}
	public function update_wo_completed($data,$completed_id){
		$this->db->where('completed_id', $completed_id);
		$this->db->update('wo_completed', $data);
		return true;
	}
	public function update_tracking($data,$dispatch_tracking_id){
		$this->db->where('dispatch_tracking_id', $dispatch_tracking_id);
		$this->db->update('tbl_dispatch_tracking', $data);
		return true;
	}
	public function insert_tracking($data){
		$this->db->set('tracking_uuid', 'UUID()', FALSE);
		$this->db->insert('tbl_dispatch_tracking', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function insert_dispatch($data){
		$this->db->insert('tbl_dispatch', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_dispatch($data, $id){
		$this->db->where('dispatch_id', $id);
		$this->db->update('tbl_dispatch', $data);
		return true;

	}	

	//

	public function get_shipping_modes(){

			$sql="Select * from wo_shipping_mode where shipping_mode_status='1'"; 

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	public function get_shipping_types(){

			$sql="Select * from wo_shipping_types where shipping_type_status='1'"; 

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}
	
	
	public function get_dispatch_row($dispatch_id){
			$sql="Select DISTINCT tbl_dispatch.* from tbl_dispatch where tbl_dispatch.dispatch_id ='$dispatch_id'";  
				//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->row_array();

	}	

	
	public function get_my_order_dispatches($dispatch_order_id,$dispatch_order_item_id){
			$sql="Select tbl_dispatch.*,wo_shipping_types.shipping_type_name,wo_shipping_mode.shipping_mode_name
			from 
			tbl_dispatch 
			LEFT JOIN wo_shipping_types on wo_shipping_types.shipping_type_id=tbl_dispatch.shipping_type_id
			LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=tbl_dispatch.shipping_mode_id
			where tbl_dispatch.dispatch_order_id='$dispatch_order_id' and dispatch_order_item_id='$dispatch_order_item_id'";  
				//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}	
		public function get_my_order_trackings($order_id){
			$sql="Select DISTINCT tbl_dispatch_tracking.* from tbl_dispatch_tracking where tbl_dispatch_tracking.order_id ='$order_id'";  
				//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();

	}
public function get_my_order_dispatch_ref_orderid($dispatch_order_id,$dispatch_order_item_id)
{
$sql="SELECT wo_ref_no as ref_no FROM wo_order_summary WHERE wo_order_summary.wo_order_id='$dispatch_order_id' and order_summary_id='$dispatch_order_item_id' limit 1";
$query = $this->db->query($sql);
                               return $query->row_array();
}

	public function get_my_order_dispatches_by_wo($dispatch_order_id,$tracking_id){
			$sql="Select tbl_dispatch.*,wo_shipping_types.shipping_type_name,wo_shipping_mode.shipping_mode_name
			from 
			tbl_dispatch 
			LEFT JOIN wo_shipping_types on wo_shipping_types.shipping_type_id=tbl_dispatch.shipping_type_id
			LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=tbl_dispatch.shipping_mode_id
			where tbl_dispatch.dispatch_order_id='$dispatch_order_id' and tracking_id='$tracking_id' limit 1";  
			//	echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}	

	public function get_order_data_by_order_id($order_id){

			$sql="Select DISTINCT wo_work_orders.* from wo_work_orders where wo_work_orders.order_id ='$order_id'";  

				//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->row_array();

	}	

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

				SHD.order_is_approved,				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.submitted_item,RDD.summary_item_id,RDD.verify_remark,RDD.verify_datetime,RDD.response_remark,RDD.rs_design_id,RDD.verify_status,RDD.submitted_to_accounts,RDD.accounts_status,RDD.accounts_verified_by,RDD.accounts_remark

			FROM

				rs_design_departments AS RDD  ';

			

			$SQL.='LEFT JOIN sh_schedule_departments as SHD on SHD.schedule_department_id=RDD.schedule_department_id ';

			$SQL.='LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';

			$SQL.="LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";

			$SQL.="LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";

			$SQL.="LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";

			//echo $SQL;

			$wh[] = ' RDD.status_value=1 AND RDD.qc_name="stitching" AND RDD.approved_dep_name="Final QC" ';

			

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

				(SELECT count(*) as APP FROM  rs_design_departments as RDD WHERE RDD.schedule_id=SHD.schedule_id and RDD.verify_status=1 AND  approved_dep_name="Final QC" ) as APP_COUNT

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

	

	public function check_bundling_deptmt_approved($summary_item_id,$approved_dep_name){

			$sql="Select * from rs_design_departments where summary_item_id='$summary_item_id' and approved_dep_name='$approved_dep_name' and verify_status='1'";  

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