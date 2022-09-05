<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount_model extends CI_Model{
	//get_leads_time_statistics




	public function get_my_order_status_data_by_id($schedule_department_id,$fromDep,$did){
 		if($fromDep=="finalqc"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_id=SHD.schedule_id and T1.is_current=1 and T1.to_department="final_qc") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_id=SHD.schedule_id and T2.verify_status=1 and T2.is_current=1 and T2.to_department="final_qc") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_id=SHD.schedule_id and T3.verify_status=-1 and T3.is_current=1 and T3.to_department="final_qc") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET('.$did.',rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT 
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}
		if($fromDep=="stitching"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="stitching") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="stitching") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="stitching") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET('.$did.',rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT 
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}
		if($fromDep=="bundling"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_id=SHD.schedule_id and T1.is_current=1 and T1.to_department="bundling") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_id=SHD.schedule_id and T2.verify_status=1 and T2.is_current=1 and T2.to_department="bundling") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_id=SHD.schedule_id and T3.verify_status=-1 and T3.is_current=1 and T3.to_department="bundling") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET('.$did.',rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}
		if($fromDep=="fusing"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="fusing") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="fusing") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="fusing") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET('.$did.',rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}

		if($fromDep=="dispatch"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_id=SHD.schedule_id and T1.is_current=1 and T1.to_department="final_qc") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_id=SHD.schedule_id and T2.verify_status=1 and T2.is_current=1 and T2.to_department="final_qc") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_id=SHD.schedule_id and T3.verify_status=-1 and T3.is_current=1 and T3.to_department="final_qc") as REJECTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T4 WHERE T4.schedule_id=SHD.schedule_id and T4.accounts_status=1 and T4.is_current=1 and T4.to_department="final_qc") as ACCOUNTS_APPROVED_COUNT
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}  

		if($fromDep=="printing"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
				(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="printing") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="printing") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="printing") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET('.$did.',rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}  
		if($fromDep=="designqc"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
				(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_id=SHD.schedule_id and T1.is_current=1 and T1.to_department="final_qc") as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_id=SHD.schedule_id and T2.verify_status=1 and T2.is_current=1 and T2.to_department="final_qc") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_id=SHD.schedule_id and T3.verify_status=-1 and T3.is_current=1 and T3.to_department="final_qc") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET('.$did.',rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}
		if($fromDep=="design"){
			$sql='SELECT
				SHD.total_order_items as TOTAL_COUNT,
				(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="design" ) as SUBMITTED_COUNT,
				(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="design") as APPROVED_COUNT,
				(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="design") as REJECTED_COUNT,
				(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET("'.$did.'",rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT
		FROM 
			sh_schedule_departments as SHD WHERE SHD.schedule_department_id ="'.$schedule_department_id.'"  ';
		}  
  	
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->row_array();
	}	

	public function get_overdue_orders($date){
	 $sql="SELECT W23.* FROM  sh_schedule_departments as SCD,wo_work_orders as W23 WHERE  SCD.order_id=W23.order_id   and W23.accounts_completed_status=0 and department_ids='10' and department_schedule_date < '".$date."' order by wo_date desc";

		$query = $this->db->query($sql);					 
		return $query->result_array();
}


	public function get_overdue_upcoming_orders($date){
	     $sql="SELECT W23.* FROM  sh_schedule_departments as SCD,wo_work_orders as W23 WHERE  SCD.order_id=W23.order_id   and W23.accounts_completed_status=0 and department_ids='10'  order by wo_date desc";

		// $sql="SELECT W23.* FROM  leads_master as L26,wo_work_orders as W23 WHERE  L26.lead_id=W23.lead_id  and W23.accounts_completed_status='0'   order by wo_date desc";

		$query = $this->db->query($sql);					 
		return $query->result_array();
}

	public function get_upcoming_orders($date){
	 $sql="SELECT W23.* FROM  sh_schedule_departments as SCD,wo_work_orders as W23 WHERE  SCD.order_id=W23.order_id   and W23.accounts_completed_status=0 and department_ids='10' and department_schedule_date >=  '".$date."' order by wo_date desc";
//echo $sql;
//exit();
		$query = $this->db->query($sql);					 
		return $query->result_array();
}


	public function get_wo_statistics_for_all($year,$month){
		$sql="SELECT W1.orderform_number,W1.wo_customer_name,datediff(W1.wo_date,STR_TO_DATE(L3.lead_date,'%d/%m/%Y') ) as lead_diff,W1.wo_gross_cost,W1.wo_shipping_cost FROM  leads_master as L3,wo_work_orders as W1 WHERE L3.lead_id=W1.lead_id and MONTH(W1.wo_date)='".$month."' AND YEAR(W1.wo_date)='".$year."'";

//echo $sql;
//exit();
		$query = $this->db->query($sql);					 
		return $query->result_array();
}

	public function get_wo_statistics($lead_owner_id,$month,$year){
		$sql="SELECT W1.orderform_number,W1.wo_customer_name,datediff(W1.wo_date,STR_TO_DATE(L3.lead_date,'%d/%m/%Y') ) as lead_diff,W1.wo_gross_cost,W1.wo_shipping_cost FROM  leads_master as L3,wo_work_orders as W1 WHERE W1.wo_owner_id='$lead_owner_id' and L3.lead_id=W1.lead_id and MONTH(W1.wo_date)='".$month."' AND YEAR(W1.wo_date)='".$year."'";
//echo $sql;
//exit();
		$query = $this->db->query($sql);					 
		return $query->result_array();


	}
	public function get_leads_statistics_graph($lead_owner_id,$month,$year){

			$sql="SELECT

				(SELECT sum(W2.wo_advance) FROM  leads_master as L5,wo_work_orders as W2 WHERE L5.lead_id=W2.lead_id and MONTH(W2.wo_date)='".$month."' and YEAR(W2.wo_date)='".$year."' and W2.accounts_completed_status=0 and W2.wo_owner_id='$lead_owner_id') as wo_advance_total,
				(SELECT sum(W3.wo_balance) FROM  leads_master as L6,wo_work_orders as W3 WHERE L6.lead_id=W3.lead_id and  MONTH(W3.accounts_completed_date)='".$month."' and YEAR(W3.accounts_completed_date)='".$year."' and W3.accounts_completed_status=1 and W3.wo_owner_id='$lead_owner_id') as wo_gross_total
FROM
				wo_work_orders
			WHERE 
wo_work_orders.wo_owner_id='$lead_owner_id' and
			       MONTH(wo_work_orders.wo_date)='".$month."' and YEAR(wo_work_orders.wo_date)='".$year."'";   

			//			echo $sql;
//exit();
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}

	public function get_leads_statistics_graph_gem($month,$year){
			$sql="SELECT

				(SELECT sum(W2.wo_advance) FROM  leads_master as L5,wo_work_orders as W2 WHERE L5.lead_id=W2.lead_id and MONTH(W2.wo_date)='".$month."' and YEAR(W2.wo_date)='".$year."' and W2.accounts_completed_status=0) as wo_advance_total,
				(SELECT sum(W3.wo_balance) FROM  leads_master as L6,wo_work_orders as W3 WHERE L6.lead_id=W3.lead_id and  MONTH(W3.accounts_completed_date)='".$month."' and YEAR(W3.accounts_completed_date)='".$year."' and W3.accounts_completed_status=1) as wo_gross_total
FROM
				wo_work_orders
			WHERE 
			       MONTH(wo_work_orders.wo_date)='".$month."' and YEAR(wo_work_orders.wo_date)='".$year."'";   

			//			echo $sql;
//exit();
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function get_leads_statistics($lead_owner_id,$month){
			$sql="SELECT
			 	count(*) as total_leads,
				(SELECT count(*) FROM  leads_master as L1 WHERE L1.lead_cat_id=1 and L1.lead_owner_id='$lead_owner_id' and  MONTH(L1.lead_c_date)='".$month."') as inbound_total,
				(SELECT count(*) FROM  leads_master as L2 WHERE L2.lead_cat_id=2 and L2.lead_owner_id='$lead_owner_id' and  MONTH(L2.lead_c_date)='".$month."') as outbound_total,
				(SELECT count(*) FROM  leads_master as L3,wo_work_orders as W1 WHERE L3.lead_owner_id='$lead_owner_id' and L3.lead_id=W1.lead_id and MONTH(L3.lead_c_date)='".$month."') as order_total,
				(SELECT sum(L4.lead_info) FROM  leads_master as L4 WHERE L4.lead_type_id=3 and MONTH(L4.lead_c_date)='".$month."' and lead_owner_id='$lead_owner_id' 			 and generate_wo='0')  as pipline_total,

				(SELECT sum(W2.wo_advance) FROM  leads_master as L5,wo_work_orders as W2 WHERE L5.lead_owner_id='$lead_owner_id' and L5.lead_id=W2.lead_id and MONTH(L5.lead_c_date)='".$month."' ) as wo_advance_total,
				(SELECT sum(W3.wo_balance) FROM  leads_master as L6,wo_work_orders as W3 WHERE L6.lead_owner_id='$lead_owner_id' and L6.lead_id=W3.lead_id and MONTH(W3.accounts_completed_date)='".$month."' and W3.accounts_completed_status=1) as wo_gross_total,
				(SELECT max(W4.wo_gross_cost) FROM  leads_master as L7,wo_work_orders as W4 WHERE L7.lead_owner_id='$lead_owner_id' and L7.lead_id=W4.lead_id and MONTH(L7.lead_c_date)='".$month."' ) as wo_max_gross_total,
				(SELECT AVG(W5.wo_gross_cost) FROM  leads_master as L8,wo_work_orders as W5 WHERE L8.lead_owner_id='$lead_owner_id' and L8.lead_id=W5.lead_id and MONTH(L8.lead_c_date)='".$month."') as order_total_avg,
				
				(SELECT AVG(datediff(W6.wo_date,L9.lead_c_date)) FROM  leads_master as L9,wo_work_orders as W6 WHERE L9.lead_owner_id='$lead_owner_id' and L9.lead_id=W6.lead_id AND L9.lead_c_date < W6.wo_date) as order_time_avg,
(SELECT IFNULL(sum(W23.wo_balance),0) FROM  leads_master as L26,wo_work_orders as W23 WHERE L26.lead_owner_id='$lead_owner_id' and L26.lead_id=W23.lead_id and MONTH(L26.lead_c_date)='".$month."' and W23.accounts_completed_status=0) as amount_to_be_rec

			FROM
				leads_master
			WHERE 
				leads_master.lead_owner_id='$lead_owner_id' and  MONTH(leads_master.lead_c_date)='".$month."'";   
				//echo $sql;
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
		public function get_leads_statistics_new($lead_owner_id,$month,$year){
			$sql="SELECT
			 	count(*) as total_leads,
				(SELECT count(*) FROM  leads_master as L1 WHERE L1.lead_cat_id=1 and L1.lead_owner_id='$lead_owner_id' and  MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' ) as inbound_total,
				(SELECT count(*) FROM  leads_master as L2 WHERE L2.lead_cat_id=2 and L2.lead_owner_id='$lead_owner_id' and  MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' ) as outbound_total,
			  (SELECT sum(L4.lead_info) FROM  leads_master as L4 WHERE L4.lead_type_id=3 and MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' and lead_owner_id='$lead_owner_id' 			 and generate_wo='0')  as pipline_total,
				(SELECT max(W4.wo_gross_cost) FROM  leads_master as L7,wo_work_orders as W4 WHERE L7.lead_owner_id='$lead_owner_id' and L7.lead_id=W4.lead_id and MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' )  as wo_max_gross_total,
				(SELECT AVG(W5.wo_gross_cost) FROM  leads_master as L8,wo_work_orders as W5 WHERE L8.lead_owner_id='$lead_owner_id' and L8.lead_id=W5.lead_id and  MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' ) as order_total_avg,
				
				(SELECT AVG(datediff(W6.wo_date,STR_TO_DATE(L9.lead_date,'%d/%m/%Y') )) FROM  leads_master as L9,wo_work_orders as W6 WHERE L9.lead_owner_id='$lead_owner_id' and L9.lead_id=W6.lead_id AND STR_TO_DATE(L9.lead_date,'%d/%m/%Y') < W6.wo_date) as order_time_avg,
               (SELECT ROUND(IFNULL(sum(W23.wo_balance),0)) FROM  leads_master as L26,wo_work_orders as W23 WHERE W23.wo_owner_id='$lead_owner_id' and L26.lead_id=W23.lead_id and  W23.accounts_completed_status=0) as amount_to_be_rec

			FROM
				leads_master
			WHERE 
				leads_master.lead_owner_id='$lead_owner_id' and  MONTH(date_format(STR_TO_DATE(leads_master.lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."' and YEAR(date_format(STR_TO_DATE(leads_master.lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."'";   
			//	echo $sql;
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}

public function get_amount_to_rec_by_sales($lead_owner_id,$month,$year){
    
    $sql="SELECT count(*)	as total_orders FROM  leads_master as L26,wo_work_orders as W23 WHERE W23.wo_owner_id='$lead_owner_id' and L26.lead_id=W23.lead_id and  W23.accounts_completed_status='0'";
    
//    echo $sql;
    	$query = $this->db->query($sql);
    		return $query->row_array();
    	
}

public function get_amount_to_rec_by_sales_admin($month,$year){
    
    $sql="SELECT count(*)	as total_orders FROM  leads_master as L26,wo_work_orders as W23 WHERE  L26.lead_id=W23.lead_id and  W23.accounts_completed_status='0'";
    
//    echo $sql;
    	$query = $this->db->query($sql);
    		return $query->row_array();
    	
}



	public function get_order_statistics_new($lead_owner_id,$month,$year){
			$sql="SELECT
			 	(SELECT count(*) FROM  leads_master as L3,wo_work_orders as W1 WHERE W1.wo_owner_id='$lead_owner_id' and L3.lead_id=W1.lead_id and MONTH(W1.wo_date)='".$month."' and YEAR(W1.wo_date)='".$year."') as order_total,
				(SELECT sum(W2.wo_advance) FROM  leads_master as L5,wo_work_orders as W2 WHERE W2.wo_owner_id='$lead_owner_id' and L5.lead_id=W2.lead_id and MONTH(W2.wo_date)='".$month."' and YEAR(W2.wo_date)='".$year."' ) as wo_advance_total,
				(SELECT sum(W3.wo_balance) FROM  leads_master as L6,wo_work_orders as W3 WHERE W3.wo_owner_id='$lead_owner_id' and L6.lead_id=W3.lead_id and MONTH(W3.accounts_completed_date)='".$month."' and YEAR(W3.accounts_completed_date)='".$year."' and W3.accounts_completed_status=1) as wo_gross_total
						FROM
				wo_work_orders
			WHERE 
				wo_work_orders.wo_owner_id='$lead_owner_id' and  MONTH(wo_work_orders.wo_date)='".$month."' and YEAR(wo_work_orders.wo_date)='".$year."'";   
			//	echo $sql;
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}


	public function get_order_statistics_new_admin($month,$year){
			$sql="SELECT
			 	(SELECT count(*) FROM  leads_master as L3,wo_work_orders as W1 WHERE L3.lead_id=W1.lead_id and MONTH(W1.wo_date)='".$month."' and YEAR(W1.wo_date)='".$year."') as order_total,
				(SELECT sum(W2.wo_advance) FROM  leads_master as L5,wo_work_orders as W2 WHERE L5.lead_id=W2.lead_id and MONTH(W2.wo_date)='".$month."' and YEAR(W2.wo_date)='".$year."' ) as wo_advance_total,
				(SELECT sum(W3.wo_balance) FROM  leads_master as L6,wo_work_orders as W3 WHERE L6.lead_id=W3.lead_id and MONTH(W3.accounts_completed_date)='".$month."' and YEAR(W3.accounts_completed_date)='".$year."' and W3.accounts_completed_status=1) as wo_gross_total
						FROM
				wo_work_orders
			WHERE 
				MONTH(wo_work_orders.wo_date)='".$month."' and YEAR(wo_work_orders.wo_date)='".$year."'";   
			//	echo $sql;
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}


	public function get_leads_statistics_admin($month,$year){

			$sql="SELECT
			 	count(*) as total_leads,
				(SELECT count(*) FROM  leads_master as L1 WHERE L1.lead_cat_id=1  and  MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' ) as inbound_total,
				(SELECT count(*) FROM  leads_master as L2 WHERE L2.lead_cat_id=2 and   MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' ) as outbound_total,
			  (SELECT sum(L4.lead_info) FROM  leads_master as L4 WHERE L4.lead_type_id=3 and MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."'  and generate_wo='0')  as pipline_total,
				(SELECT max(W4.wo_gross_cost) FROM  leads_master as L7,wo_work_orders as W4 WHERE  L7.lead_id=W4.lead_id and MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' )  as wo_max_gross_total,
				(SELECT AVG(W5.wo_gross_cost) FROM  leads_master as L8,wo_work_orders as W5 WHERE  L8.lead_id=W5.lead_id and  MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."' ) as order_total_avg,
				
				(SELECT AVG(datediff(W6.wo_date,STR_TO_DATE(L9.lead_date,'%d/%m/%Y') )) FROM  leads_master as L9,wo_work_orders as W6 WHERE  L9.lead_id=W6.lead_id AND STR_TO_DATE(L9.lead_date,'%d/%m/%Y') < W6.wo_date) as order_time_avg,
               (SELECT ROUND(IFNULL(sum(W23.wo_balance),0)) FROM  leads_master as L26,wo_work_orders as W23 WHERE  L26.lead_id=W23.lead_id and  W23.accounts_completed_status=0) as amount_to_be_rec

			FROM
				leads_master
			WHERE 
				  MONTH(date_format(STR_TO_DATE(leads_master.lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."' and YEAR(date_format(STR_TO_DATE(leads_master.lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."'";   


			$query = $this->db->query($sql);					 
			return $query->row_array();
	}



	public function get_leads_statistics_admin_pie_chart($month,$year){

			$sql="SELECT staff_name,L5.lead_owner_id,
				sum(IF(W2.accounts_completed_status='1' ,W2.wo_balance,'O')) as balance, sum(W2.wo_advance) as advance FROM staff_master SF , leads_master as L5,wo_work_orders as W2 WHERE SF.staff_id=L5.lead_owner_id  and MONTH(W2.wo_date)='".$month."' and YEAR(W2.wo_date)='".$year."' AND L5.lead_id=W2.lead_id  group by L5.lead_owner_id"; 

//				echo $sql;
			$query = $this->db->query($sql);					 
			return $query->result_array();
	}


	public function get_leads_pipeline_admin_donut_chart($month,$year){

			$sql="SELECT sum(L4.lead_info) as lead_info,staff_name FROM  staff_master SF , leads_master as L4 WHERE SF.staff_id=L4.lead_owner_id and L4.lead_type_id=3 and MONTH(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$month."'   and YEAR(date_format(STR_TO_DATE(lead_date,'%d/%m/%Y'),'%Y-%m-%d'))='".$year."'  and generate_wo='0' group by L4.lead_owner_id having lead_info > 0"; 

			//				echo $sql;
			$query = $this->db->query($sql);					 
			return $query->result_array();
	}


	public function get_leads_statistics_admin_pie_chart_bal($month,$year,$leadid){

			$sql="SELECT IFNULL(sum(W3.wo_balance),0) as  bal FROM leads_master as L6,wo_work_orders as W3 WHERE YEAR(L6.lead_c_date)='$year' and L6.lead_id=W3.lead_id and MONTH(W3.accounts_completed_date)='$month' and W3.accounts_completed_status='1' and L6.lead_owner_id='$leadid'"; 

//				echo $sql;

			$query = $this->db->query($sql);					 
			return $query->row_array();
	}


	public function check_any_rejection_by_qty_field($batch_number,$schedule_id,$summary_id,$did){    
    
		$anyRejSql="SELECT rejected_from_departments,rejected_remark,rejected_datetime,rejected_qty FROM sh_schedule_department_rejections WHERE batch_number='".$batch_number."' and schedule_id='".$schedule_id."' and summary_id='".$summary_id."' and  FIND_IN_SET(".$did.",rejected_to_departments) limit 1 ";
		$query = $this->db->query($anyRejSql);					 
		return $query->row_array();
	}
	public function check_any_rejection_by_qty($batch_number,$schedule_id,$summary_id,$did){    
    
		$anyRejSql="SELECT * FROM sh_schedule_department_rejections WHERE batch_number='".$batch_number."' and schedule_id='".$schedule_id."' and summary_id='".$summary_id."' and  FIND_IN_SET(".$did.",rejected_to_departments) limit 1 ";
		$query = $this->db->query($anyRejSql);					 
		return $query->row_array();
	}
	
	
	public function get_my_tasks($login_id){
		$current_date=date('Y-m-d');
		$nxt_date=date('Y-m-d', strtotime(' +1 day'));
		//echo $sql="Select * from tasks where tasks.task_owner_id='$login_id' and reminder_date BETWEEN $current_date and $nxt_date ";  
		$sql="Select tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email from 
		tasks 
		left join leads_master on leads_master.lead_id=tasks.lead_id
		LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id
		where tasks.task_owner_id='$login_id' and tasks.reminder_date BETWEEN '$current_date' and '$nxt_date' ";
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	public function get_my_tasks_by_date($login_id,$date){
		//$current_date=date('Y-m-d');
		//$nxt_date=date('Y-m-d', strtotime(' +1 day'));
		//echo $sql="Select * from tasks where tasks.task_owner_id='$login_id' and reminder_date BETWEEN $current_date and $nxt_date ";  
		$sql="Select tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email from 
		tasks 
		left join leads_master on leads_master.lead_id=tasks.lead_id
		LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id
		where tasks.task_owner_id='$login_id' and tasks.reminder_date='$date'  ";
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}



	public function get_my_tasks_by_date_staff($login_id,$date){
		//$current_date=date('Y-m-d');
		//$nxt_date=date('Y-m-d', strtotime(' +1 day'));
		//echo $sql="Select * from tasks where tasks.task_owner_id='$login_id' and reminder_date BETWEEN $current_date and $nxt_date ";  
		$sql="Select tasks.*,leads_master.lead_code,leads_master.lead_uuid,customer_master.customer_name,customer_master.customer_mobile_no,customer_master.customer_email from 
		tasks 
		left join leads_master on leads_master.lead_id=tasks.lead_id
		LEFT JOIN customer_master ON customer_master.customer_id = leads_master.lead_client_id
		where leads_master.lead_owner_id='$login_id' and tasks.reminder_date='$date'  ";
    	$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	
	//-------------------------------
	
	
	
	public function get_design_data($summary_item_id,$from_department){
		$sql="Select * from rs_design_departments where summary_item_id='$summary_item_id' and from_department='$from_department' and verify_status='1'";  
		//echo $sql;
    	$query = $this->db->query($sql);					 
		return $query->row_array();
	}
	public function get_last_updated_row_by_schedule_id_by_field($schedule_id,$summary_id,$fd,$td){
		$sel="SELECT rs_design_id,verify_status  FROM rs_design_departments WHERE schedule_id='".$schedule_id."'  AND summary_item_id='".$summary_id."' and from_department='$fd' AND to_department='$td' ORDER BY rs_design_id DESC LIMIT 1 ";
		
		//echo $sel;
		$query = $this->db->query($sel);					 
		return $query->row_array();
		
	}
	public function get_last_updated_row_by_schedule_id($schedule_id,$summary_id,$fd,$td){
		$sel="SELECT * FROM rs_design_departments WHERE schedule_id='".$schedule_id."'  AND summary_item_id='".$summary_id."' and from_department='$fd' AND to_department='$td' ORDER BY rs_design_id DESC LIMIT 1 ";
		
		//echo $sel;
		$query = $this->db->query($sel);					 
		return $query->row_array();
		
	}
	public function get_last_updated_row_by_field($department_id,$summary_id,$fd,$td){
		$sel="SELECT verify_status,rs_design_id,accounts_status FROM rs_design_departments WHERE schedule_department_id='".$department_id."'  AND summary_item_id='".$summary_id."' and from_department='$fd' AND to_department='$td' ORDER BY rs_design_id DESC LIMIT 1 ";
		//echo $sel."<br/>";
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
    	$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark,RDD.rejected_count
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
    	$sql="SELECT wo_order_options.*,wo_product_fit_type.fit_type_name FROM wo_order_options 
		LEFT JOIN wo_product_fit_type ON wo_product_fit_type.fit_type_id=wo_order_options.fit_type_id
		 WHERE wo_order_options.wo_order_id='$wo_order_id' AND wo_order_options.order_summary_id='$order_summary_id' ";
		//echo $sql;
		$query = $this->db->query($sql);					 
		return $query->result_array();
	}
	
	public function get_my_order_scheduled_data_by_uuid($schedule_uuid){    
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
	public function get_staff_profile_data_by_fields($login_id){
			$sql="SELECT department_id,unit_managed FROM staff_master WHERE login_id='$login_id' ";   
			//echo $sql;
			$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	


}

?>
