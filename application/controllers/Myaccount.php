<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('myaccount_model', 'myaccount_model');
		$this->load->model('dashboard_model', 'dashboard_model');
		$this->load->model('design_model', 'design_model');
		$this->load->model('qc_model', 'qc_model');
		$this->load->model('printing_model', 'printing_model');
		$this->load->model('fusing_model', 'fusing_model');
		$this->load->model('bundling_model', 'bundling_model');
		$this->load->model('stitching_model', 'stitching_model');
		$this->load->model('common_model', 'common_model');
        $this->load->model('leads_model', 'leads_model');
		$this->load->library('datatable');
		
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
      	//$localIP = getHostByName(getHostName());
		//echo $localIP;exit;
		
	}
	
public function get_works_designqc($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_works_designqc($id,$unit,$date,$type);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}


public function get_works_design($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_works_design($id,$unit,$date,$type);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}


public function get_works_printing($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_works_printing($id,$unit,$date,$type);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_works_fusing($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_works_fusing($id,$unit,$type,$date);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_works_bundling($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_works_bundling($id,$unit,$date,$type);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_works_stitching($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_works_stitching($id,$unit,$date,$type);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_wo_from_pending_finalqc($id,$date ,$type)
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_wo_from_pending_finalqc($id,	$date);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}
public function get_wo_from_completed_finalqc($id,$date )
{
	
	$unit="0,1,2,3";
		$records =$this->dashboard_model->get_wo_from_completed_finalqc($id,$date);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_dispatch_pending_orders($date)
{
	
	
		$records =$this->dashboard_model->get_dispatch_pending_orders($date);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_wo_pending_with_accounts($date)
{
	
	
		$records =$this->dashboard_model->get_wo_pending_with_accounts($date);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

public function get_wo_completed_with_accounts($date)
{
	
	
		$records =$this->dashboard_model->get_wo_completed_with_accounts($date);
		$dd['data']=$records;
		echo json_encode($dd);
				
	
}

	public function statusinfo(){
		//echo $_POST['fd'];
		//$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);
		$data['row']=$this->myaccount_model->get_my_order_status_data_by_id($_POST['sid'],$_POST['fd'],$_POST['did']);
		$data['item_row']=$_POST['smid'];
		$data['fromdep']=$_POST['fd'];
		$this->load->view('myaccount/order_status_info',$data);
		
	}
	public function iteminfo(){
		//echo $_POST['sid'];
		//$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['sid']);
		$data['item_row']=$_POST['smid'];
		$this->load->view('myaccount/order_item_info',$data);
		
	}
	
	public function set_date(){
		$this->session->set_userdata('date_now',$_POST['td']);
	}
	public function all_updates_of_order(){
		$loginid=$this->session->userdata('loginid');
		$this->load->view('myaccount/all_updates_of_order');
	}
	public function updates_of_order(){
		$loginid=$this->session->userdata('loginid');
		$data['staffRow']=$this->myaccount_model->get_staff_profile_data($loginid);
		
		$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);
		$this->load->view('myaccount/updates_of_order');
	}
	public function order_info(){
		$loginid=$this->session->userdata('loginid');
		$data['staffRow']=$this->myaccount_model->get_staff_profile_data($loginid);
		
		$data['schedule_status']=$this->myaccount_model->get_schedule_status_by_deptmt($_POST['did']);
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($_POST['sdid']);
		$data['item_row']=$_POST['smid'];
		$this->load->view('myaccount/order_info',$data);
		
	}
	public function myorders(){
		$data['title']="Myaccount | My Orders";
		if($this->session->userdata('role_id')=="3"){
			$loginid=$this->session->userdata('loginid');
			$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
			//echo $staffRow['department_id'];
//-------------------------------------------------------------------------------------------------------//
			if($staffRow['department_id']==4){ // design deptmt
				if($this->uri->segment(3)=="pending"){
					$data['view']='design/orders_design_pending_new';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='design/orders_design_competed_new';
				}else if($this->uri->segment(3)=="all"){
					$data['view']='design/orders_design_all_new';	
				}else{
					$data['view']='design/orders_design_active_new';
				}
				$this->load->view('layout',$data);
			}
//----------------------------------------------------------------------------------------------------//
			if($staffRow['department_id']==11){ // design qc deptmt
				if($this->uri->segment(3)=="competed"){
					$data['view']='qc/orders_design_qc_competed';	
				}else if($this->uri->segment(3)=="pending"){
					$data['view']='qc/orders_design_qc_pending';
				}else if($this->uri->segment(3)=="all"){
					$data['view']='qc/orders_design_qc_all';
				}else{
					$data['view']='qc/orders_design_qc_active';
				}
				$this->load->view('layout',$data);
			}
//----------------------------------------------------------------------------------------------------//
			if($staffRow['department_id']==5){ // printing deptmt
				//echo 'rrr';
				if($this->uri->segment(3)=="pending"){
					$data['view']='printing/printing_orders_list_pending';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='printing/printing_orders_list_competed';
				}else if($this->uri->segment(3)=="all"){
					$data['view']='printing/printing_orders_list_all';
				}else{
					$data['view']='printing/printing_orders_list_active';
				}
				$this->load->view('layout',$data);
			}
//-----------------------------------------------------------------------------------------------------//			
			if($staffRow['department_id']==6){ // fusing deptmt
				if($this->uri->segment(3)=="pending"){
					$data['view']='fusing/fusing_orders_list_pending';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='fusing/fusing_orders_list_competed';
				}else if($this->uri->segment(3)=="submitted"){
					$data['view']='fusing/fusing_orders_list_submitted';
				}else if($this->uri->segment(3)=="all"){
					$data['view']='fusing/fusing_orders_list_all';
				}else{
					$data['view']='fusing/fusing_orders_list_active';
				}
				$this->load->view('layout',$data);
			}
//-------------------------------------------------------------------------------------------------------//			
			if($staffRow['department_id']==12){ // bundling
				if($this->uri->segment(3)=="pending"){
					$data['view']='bundling/bundling_orders_list_pending';
				}else if($this->uri->segment(3)=="request"){
					$data['view']='bundling/bundling_orders_list_request';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='bundling/bundling_orders_list_competed';
				}else if($this->uri->segment(3)=="all"){
					$data['view']='bundling/bundling_orders_list_all';
				}else{
					$data['view']='bundling/bundling_orders_list_active';
				}
				$this->load->view('layout',$data);
			}
//--------------------------------------------------------------------------------------------------------//			
			if($staffRow['department_id']==8){ // stiching deptmt
				if($this->uri->segment(3)=="pending"){
					$data['view']='stitching/stitching_orders_list_pending';
				}else if($this->uri->segment(3)=="submitted"){
					$data['view']='stitching/stitching_orders_list_submitted';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='stitching/stitching_orders_list_competed';	
				}else if($this->uri->segment(3)=="all"){
					$data['view']='stitching/stitching_orders_list_all';
				}else{
					$data['view']='stitching/stitching_orders_list_active';
				}
				$this->load->view('layout',$data);
			}
//------------------------------------------------------------------------------------------------------------------//			
			if($staffRow['department_id']==13){ // final qc deptmt
				if($this->uri->segment(3)=="pending"){
					$data['view']='qc/final_qc_list_pending';
				}else if($this->uri->segment(3)=="request"){
					$data['view']='qc/final_qc_list_request';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='qc/final_qc_list_competed';
				}else if($this->uri->segment(3)=="all"){
					$data['view']='qc/final_qc_list_all';
				}else{
					$data['view']='qc/final_qc_orders_list_active';
				}
				$this->load->view('layout',$data);
			}
//------------------------------------------------------------------------------------------------------------------//			
			if($staffRow['department_id']==10){ // dispatch
				//echo $this->uri->segment(3);
				if($this->uri->segment(3)=="pending"){
					$data['view']='dispatch/dispatch_orders_list_pending';
				}else if($this->uri->segment(3)=="competed"){
					$data['view']='dispatch/dispatch_orders_list_competed'; 
				}else if($this->uri->segment(3)=="all"){
					$data['view']='dispatch/dispatch_orders_list_all'; 
				}else{
					$data['view']='dispatch/dispatch_orders_list_active';
				}
				$this->load->view('layout',$data);
			}
		}else{
			redirect('myaccount/index');
		}
	}

	public function order_view($uuid,$sdid,$actionFrom=null){
		//echo $actionFrom;
		$data['actionFrom']=$actionFrom;
		$data['title']="My Orders | Scheduled Order View";
		$data['title_head']="My Orders";
		$data['row']=$this->myaccount_model->get_my_order_scheduled_data_by_uuid($uuid);
		
		$data['schedule_data']=$this->myaccount_model->get_my_order_scheduled_deptmt_data_by_id($sdid);
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$data['staffRow']=$staffRow;

		if($staffRow['department_id']==4){ // design deptmt
			//$data['view']='design/order_view_design';
			$data['view']='design/order_view_design_table';
			$this->load->view('layout',$data);
		}
		if($staffRow['department_id']==11){
			$data['view']='qc/order_view_design_qc';
			$this->load->view('layout',$data);
		}
		
		if($staffRow['department_id']==5){
			$data['view']='printing/printing_order_view';
			$this->load->view('layout',$data);
		}
		if($staffRow['department_id']==6){
			$data['view']='fusing/fusing_order_view';
			$this->load->view('layout',$data);
		}
		if($staffRow['department_id']==12){
			$data['view']='bundling/bundling_order_view';
			$this->load->view('layout',$data);
		}
		if($staffRow['department_id']==8){
			$data['view']='stitching/stitching_order_view';
			$this->load->view('layout',$data);
		}
		if($staffRow['department_id']==13){
			$data['view']='qc/order_view_final_qc';
			$this->load->view('layout',$data);
		}
		if($staffRow['department_id']==10){
			$data['view']='dispatch/dispatch_order_view';
			$this->load->view('layout',$data);
		}
		
	}
	
	public function orders_list_design_qc(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->myaccount_model->get_my_scheduled_orders($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$option='<td style="text-align:center;">';
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$data[]= array(
					$row['orderform_number'],
					date("d-m-Y", strtotime($row['department_schedule_date'])),
					//$row['schedule_c_date'],
					$row['production_unit_name'],
					//date("d-m-Y", strtotime($row['schedule_date'])),
					//date("d-m-Y", strtotime($row['schedule_end_date'])),
					//$row['schedule_date'],
					//$row['schedule_end_date'],
					$option
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
	
	public function orders_list_design(){
		$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		//echo $staffRow['unit_managed'];exit;
		//$records = $this->myaccount_model->get_my_orders($staffRow['department_id']);
		$records = $this->myaccount_model->get_my_scheduled_orders($staffRow['department_id'],$staffRow['unit_managed']);
		$data = array();
		foreach ($records['data']  as $row) 
		{
			$option='<td style="text-align:center;">';
			
			$option.='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> View Order</label></a>';
			$option.='</td>';
			
			$data[]= array(
					$row['orderform_number'],
					date("d-m-Y", strtotime($row['department_schedule_date'])),
					//$row['schedule_c_date'],
					$row['production_unit_name'],
					//date("d-m-Y", strtotime($row['schedule_date'])),
					//date("d-m-Y", strtotime($row['schedule_end_date'])),
					//$row['schedule_date'],
					//$row['schedule_end_date'],
					$option
				);
		}
		$records['data']=$data;
		echo json_encode($records);	
	}
	
public function index_admin_gem_sales_single()

{
$data['title']="Myaccount | Admin Dashboard";
$data['lead_staffs'] = $this->leads_model->get_all_staffs_sales();
$data['view']='myaccount/index_admin_gem_sales_single';
 $this->load->view('layout',$data);
}

public function index_admin_gem_production()

{
$data['title']="Myaccount | Admin Dashboard";
$data['view']='myaccount/index_gem_production.php';
 $this->load->view('layout',$data);
}
	public function index(){
		$department=$this->session->userdata('department_parent');
		
//			print_r($department);			
		if($department==0){
			$data['title']="Myaccount | Admin Dashboard";
			$data['view']='myaccount/index_admin';
		}else{
			$loginid=$this->session->userdata('loginid');
			$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
			$dashboard_category=$staffRow['dashboard_category'];


if($dashboard_category=="AD")
{
$data['title']="Myaccount | Admin Dashboard";
$data['view']='myaccount/index_admin_gem';


}
else
{
			if($department==1){
				$data['title']="Myaccount | Support Dashboard";
				$data['view']='myaccount/index_support';
			}
			if($department==2){
				$data['title']="Myaccount | Sales Dashboard";
				$data['view']='myaccount/index_sales';
			}
			if($department==3){
				$data['title']="Myaccount | Production Dashboard";
				if($dashboard_category==""){
					$data['view']='myaccount/index_production';
				}else{
					if($dashboard_category=="PH"){
						$data['title']="Myaccount | Production Head";
						$data['view']='myaccount/index_production_ph';
					}
				}
			}
}
		}
		$this->load->view('layout',$data);
	}
	public function update_pwd(){
		if($this->input->post('submitData')){
			$this->form_validation->set_rules('old_pwd', 'Old Password', 'trim|required');
			$this->form_validation->set_rules('new_pwd', 'New Password', 'trim|required');
			$this->form_validation->set_rules('c_pwd', 'Re New Password', 'trim|required');
			
			
			
			if ($this->form_validation->run() == FALSE) {
				
				$message='<div class="alert alert-warning alert-dismissible" style="width:100%;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<h4><i class="icon fa fa-warning"></i> Alert!</h4>
				'.validation_errors().'
				</div>';
				echo json_encode(array('responseCode' =>"F",'responseMsg'=>$message));
				exit;
			}else{
				//$loginid=$this->session->has_userdata('loginid');
				$loginid=$this->session->userdata('loginid');
				$old_pwd=md5($this->input->post('old_pwd'));
				$new_pwd=md5($this->input->post('new_pwd'));
				$c_pwd=md5($this->input->post('c_pwd'));
				$dataExist = $this->auth_model->check_password_is_correct($loginid,$old_pwd);
				if($dataExist['login_master_id']!=""){
					if($old_pwd==$new_pwd){
						$message='<div class="alert alert-warning alert-dismissible" style="width:100%;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<h4><i class="icon fa fa-warning"></i> Alert!</h4>
						<p>Old password and new password are same. Please choose another...!</p>
						</div>';
						echo json_encode(array('responseCode' =>"F",'responseMsg'=>$message));
						exit;
					}else{
						if($c_pwd==$new_pwd){
							$data = array(
								'log_password' =>$new_pwd
							);
							$dataExist = $this->auth_model->update_new_password($data,$loginid);
							$message='<div class="alert alert-success alert-dismissible" style="width:100%;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
							<h4>Success!</h4>
							<p>Password changed successfully...!</p>
							</div>';
							echo json_encode(array('responseCode' =>"S",'responseMsg'=>$message));
							exit;
						}else{
							$message='<div class="alert alert-warning alert-dismissible" style="width:100%;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
							<h4><i class="icon fa fa-warning"></i> Alert!</h4>
							<p>New password and Re new password are not same...!</p>
							</div>';
							echo json_encode(array('responseCode' =>"F",'responseMsg'=>$message));
							exit;
						}
					}
					
				}else{
					$message='<div class="alert alert-warning alert-dismissible" style="width:100%;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<h4><i class="icon fa fa-warning"></i> Alert!</h4>
					<p>Invalid old password...!</p>
					</div>';
					echo json_encode(array('responseCode' =>"F",'responseMsg'=>$message));
					exit;
				}
			}
		}
	}
	public function profile(){
		//echo $this->session->userdata('role_name');
		//print_r($results);
		$data['title']="Myaccount | Profile";
		$data['view']='myaccount/profile';
		$this->load->view('layout',$data);
	}
	
}
 
