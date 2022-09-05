<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_model extends CI_Model{

	public function get_all_scheduled_orders($sdate){
			
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
			//echo $finalSql;
			$wh[] = " SH.schedule_id!='0' ";
			$wh[] = " SH.schedule_date<'".$sdate."'";
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
	}
	
	public function update_department_row($data,$id){
		$this->db->where('schedule_department_id',$id);
		$this->db->update('sh_schedule_departments',$data);
		return true;
	}
	public function get_department_row($schedule_department_id){
		$sql="SELECT schedule_department_id,design_total_items,design_submitted_items,design_approved_items,design_rejected_items FROM sh_schedule_departments WHERE schedule_department_id='$schedule_department_id'";
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_works_scheduling($did){
			$wh =array();
			//$cdate=date('Y-m-d');
			$SQL='SELECT 
				SHD.scheduled_order_info,
				SHD.schedule_department_id
			FROM
				sh_schedule_departments AS SHD  ';
			//echo $SQL;
			$SQL.= ' WHERE FIND_IN_SET('.$did.',SHD.department_ids) ORDER BY  SHD.schedule_department_id  ';
			//echo $SQL;
			$query = $this->db->query($SQL);					 
			return $query->result_array();
	}
	
}
?>