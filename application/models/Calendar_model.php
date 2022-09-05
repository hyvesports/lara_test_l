<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model{
	
	//check_priority_exist 
	public function get_all_production_units_by_id($production_unit_id){
			$sql="Select * from pr_production_units WHERE production_unit_status='1' AND production_unit_id='$production_unit_id'  ORDER BY `production_unit_id` ASC";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function get_all_production_unit_managed_by(){
			$sql="Select pr_production_units.*,staff_id,CONCAT(staff_code,'-',staff_name) as staff_data from pr_production_units
			LEFT JOIN  staff_master ON staff_master.staff_id=pr_production_units.unit_managed_by
			WHERE production_unit_status='1'  GROUP BY `unit_managed_by` ";  
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function get_all_production_units(){
			$sql="Select * from pr_production_units WHERE production_unit_status='1'  ORDER BY `production_unit_id` ASC";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function chk_calender_created($calendar_year,$calendar_month){
			$sql="Select * from pr_production_calendar WHERE calendar_id!='0' "; 
			$sql.=" AND calendar_year='".$calendar_year."' ";
			$sql.=" AND calendar_month='".$calendar_month."' LIMIT 1";
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function get_all_dates_list_by_unit($calendar_month,$calendar_year,$unit_id){
			$sql="Select * from pr_unit_calendar WHERE MONTH(unit_calendar_date)='$calendar_month' AND YEAR(unit_calendar_date)='$calendar_year'  and unit_id='$unit_id 'ORDER BY `unit_calendar_date` ASC";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function get_all_dates_list($calendar_month,$calendar_year){
			$sql="Select * from pr_production_calendar WHERE calendar_month='$calendar_month' AND calendar_year='$calendar_year' ORDER BY `calendar_date` ASC";    
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	public function delete_calender_data($calendar_month,$calendar_year){
		$this->db->where('calendar_month',$calendar_month);
		$this->db->where('calendar_year',$calendar_year);
		$this->db->delete('pr_production_calendar');
		return true;
	}
	public function get_all_calender_date(){
			$sql="Select * from pr_production_calendar WHERE calendar_id!='0' "; 
			if($this->session->userdata('calendar_year')!=''){
				$sql.=" AND calendar_year='".$this->session->userdata('calendar_year')."' ";
			}
			if($this->session->userdata('calendar_month')!=''){
				$sql.=" AND calendar_month='".$this->session->userdata('calendar_month')."' ";
			}
			$sql.="GROUP BY `calendar_year`,`calendar_month` ORDER BY `calendar_date` DESC";
			
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->result_array();
	}
	
	public function delete_production_calendar($calendar_year,$calendar_month){
		$this->db->where('calendar_year',$calendar_year);
		$this->db->where('calendar_month',$calendar_month);
		$this->db->delete('pr_production_calendar');
		return true;
	}
	
	public function get_non_working_days($non_working_days){
			$sql="Select non_working_id FROM pr_non_working_days WHERE non_working_days='$non_working_days' AND status='1'";  
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	public function get_production_unit_calendar($unit_id,$calendar_id){
			$sql="Select unit_calendar_date,unit_work,unit_work_completed,unit_working_capacity_in_sec,schedule_unit_percentage,schedule_unit_percentage_sec FROM pr_unit_calendar WHERE unit_id='$unit_id' AND calendar_id='$calendar_id'";  
			//echo $sql;
    		$query = $this->db->query($sql);					 
			return $query->row_array();
	}
	
	public function insert_production_calendar($sql){    
    		$query = $this->db->query($sql);	
			$insert_id = $this->db->insert_id();
			return $insert_id;
	}
	public function insert_production_unit_calendar($sql){    
    		$query = $this->db->query($sql);	
			//$insert_id = $this->db->insert_id();
			return true;
	}

public function days_in_month($month, $year)
{
// calculate number of days in a month
return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

	
}
?>