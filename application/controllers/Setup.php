<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setup extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('order_model', 'order_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('calendar_model', 'calendar_model');
		$this->load->model('common_model', 'common_model');
		$this->load->model('setup_model', 'setup_model');

		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	public function delete($uuid){
		$shRow=$this->schedule_model->get_scheduled_data_by_uuid($uuid);
		if($shRow['production_stitching_date']=="0000-00-00"){
			$production_end_date=$shRow['schedule_end_date'];
		}else{
			$production_end_date=$shRow['production_stitching_date'];
		}
		$schedule_unit_id=$shRow['schedule_unit_id'];
		$day_data_row=$this->schedule_model->get_unit_day_info($production_end_date,$schedule_unit_id);
		$unit_working_capacity_in_sec=$day_data_row['unit_working_capacity_in_sec'];
		//echo $unit_working_capacity_in_sec."<br/>";
		$per_sum=0;
		$sec_sum=0;
		if($day_data_row['schedule_unit_percentage']!=''){
			$per_sum=$day_data_row['schedule_unit_percentage'];
		}
		if($day_data_row['schedule_unit_percentage_sec']!=''){
			$sec_sum=$day_data_row['schedule_unit_percentage_sec'];
		}
		//echo $per_sum."==".$sec_sum."<br/>";
		$array1 = json_decode($shRow['sh_order_json'],true);
		//print_r($array1);
		$item_order_total_sec=0;
		if($array1){
			foreach($array1 as $key1 => $value1){
				$item_order_total_sec+=$value1['item_order_total_sec'];
			} 
		}
		$remaingSec=$sec_sum-$item_order_total_sec;
		$remainPer=$remaingSec/$unit_working_capacity_in_sec;
		$final_per=round( number_format( $remainPer * 100, 2 )); 
		
		$this->schedule_model->delete_scheduled_data($uuid);
		$this->schedule_model->delete_scheduled_department_data($shRow['schedule_id']);
		$this->schedule_model->delete_scheduled_item_qty_data($shRow['schedule_uuid']);
		$this->schedule_model->delete_rejected_order_data($shRow['schedule_id']);
		$this->schedule_model->delete_dispatch_order_data($shRow['order_id']);
		$this->schedule_model->delete_schedule_updates($shRow['schedule_id']);
		$this->schedule_model->delete_schedule_rejection_latest($shRow['schedule_id']);
		$this->schedule_model->delete_schedule_wo_completed($shRow['schedule_id']);
		$u_data = array(
			'schedule_unit_percentage' =>$final_per,
			'schedule_unit_percentage_sec' =>$remaingSec,
		);
		$this->schedule_model->update_unit_calender_time($u_data,$production_end_date,$schedule_unit_id);
		$this->session->set_flashdata('success','successfully deleted.');	
		redirect('setup/schedule_list');
	}
	public function scheduled_list(){
		//$accessArray=$this->rbac->check_operation_access(); 
		$sdate='2021-11-24';
		$records = $this->setup_model->get_all_scheduled_orders($sdate);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			
			$wo_ref_numbers="";
			$c="";
			if($row['wo_ref_numbers']!=""){
				//$wo_ref_numbers="<br/>Ref: No: ".$row['wo_ref_numbers'];
				$wo_ref_numbersArray=explode(',',$row['wo_ref_numbers']);
				$oItems="";
				$c='<ul class="list-ticked">';
				foreach($wo_ref_numbersArray as $onum){
					$c.='<li>'.$onum.'</li>';
					$oItems.=','.$onum;
				}
				$c.='</ul>';
			}
			$order_info=$row['orderform_number'].$oItems;
			//if($row['schedule_order_info']==""){
			$upInfo="UPDATE sh_schedules SET schedule_order_info='$order_info' WHERE schedule_id='".$row['schedule_id']."' ";
			$query = $this->db->query($upInfo);
			//}
			
			$startDate=$this->schedule_model->final_dispatch_dates($row['schedule_id'],4);
			
			$dispatchDates= $this->schedule_model->final_dispatch_dates($row['schedule_id'],10);
			
			$option='<td style="text-align:center;">';
			
				$option.='<a href="'.base_url('schedule/view/'.$row['schedule_uuid']).'" title="View" style="cursor: pointer;" target="_blank"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			
			
				$option.='&nbsp;<a title="Delete"  onclick="return  deleteRow();" href="'.base_url('setup/delete/'.$row['schedule_uuid']).'" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>';
			
			$option.='</td>'; 
			$dispatch_date='<label class="badge badge-outline-warning">'.date("d-m-Y", strtotime($row['wo_dispatch_date']))."[R]</label>"."<br/><label class='badge badge-outline-success mt-1'>".date("d-m-Y", strtotime($dispatchDates['dates']))."[S]</label>";
			if($row['wo_product_info']==""){
				$Summary="Nil";
			}else{
				$Summary='<a href="#"  title="'.$row['wo_product_info'].'">'.substr($row['wo_product_info'],0,30)."..</a>";
			}
			$currentStage=$this->schedule_model->get_current_stage($row['schedule_id']);
			$currentDept="";
			if($currentStage!=""){
				$department1=$this->schedule_model->get_production_department_names($currentStage['department_ids']);
				$currentDept='<label class="badge badge-outline-warning">In '.$department1['DNAME'].'</label>';
			}
			
			$data[]= array(
					$row['orderform_number'].$c,
					$Summary,
					date("d-m-Y", strtotime($startDate['dates'])),
					$dispatch_date,
					$currentDept,
					$option
				);
			
			
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	public function schedule_list(){
		
		$data['title']="Drop | Master";
		$data['title_head']=$accessArray['menu_name'];
		$data['view']='setup/schedule_list';
		$this->load->view('layout',$data);
	}

	public function design___($id){
		//echo 'Hiii';
		$records=$this->setup_model->get_works_scheduling($id);
		if($records){
			$rec=0;
			foreach($records as $row){
				$rec++;
				$itemsArray=json_decode($row['scheduled_order_info'],true);
				$total_order_items=0;
				$schedule_department_id=$row['schedule_department_id'];
				foreach($itemsArray as $item){
					//echo $item['summary_id']."<br/>";
					
					if($item['item_unit_qty_input']!=0){
						//echo $item['summary_id']."::".$row['schedule_department_id']."<br/>";
						$total_order_items++;
					}
				}
				
				$sql="UPDATE sh_schedule_departments SET total_order_items='$total_order_items' WHERE schedule_department_id='$schedule_department_id'";
				//echo "<br/>";
				$query = $this->db->query($sql);
			}
		}
	}
}
?>