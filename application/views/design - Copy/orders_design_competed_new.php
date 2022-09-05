<div class="content-wrapper">
<?php //include("filter.php")?>
<div class="card">
<div class="card-body">
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>
<h4 class="card-title"><?php echo $title;?> | completed

</h4>

<div class="row">
<p style="text-align:right; float:right;" class="text-right">
<a class="btn btn-outline-info " href="<?=base_url('myaccount/myorders/all/')?>">All</a>
<a class="btn btn-outline-warning" href="<?=base_url('myaccount/myorders')?>">Active</a>
<a class="btn btn-outline-danger" href="<?=base_url('myaccount/myorders/pending/')?>">Pending</a>
<a class="btn btn-success" href="<?=base_url('myaccount/myorders/competed/')?>">Completed</a>
</p>
<div class="col-12 table-responsive">
<table id="listing" class="table" >
<thead>
<tr>
<th>Schedule Date</th>
<th>#Number</th>
<th>Timestamp</th>
<th>Disp: Date</th>
<th>Sales Handler</th>
<th>Summary</th>
<th>Status</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>

<tbody>
<?php
$accessArray=$this->rbac->check_operation_access(); 
		$loginid=$this->session->userdata('loginid');
		$staffRow=$this->myaccount_model->get_staff_profile_data($loginid);
		$records = $this->design_model->get_design_works_competed_new($staffRow['department_id'],$staffRow['unit_managed']);
		//print_r($records);
		$data = array();
		
		foreach ($records  as $row) 
		{
			$val=0;
			//$option='<td style="text-align:center;">';
			$option='<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
			//$option.='</td>';
			//$option1='<td><span class="badge" style="background-color:'.$row['priority_color_code'].';">'.$row['priority_name'].'</span></td>';
			$wo_product_info="";
			if($wo_product_info!=""){
			$wo_product_info=$row['wo_product_info']."</br>";
			}
			$re="";
			if($row['is_re_scheduled']>0){
				$re='&nbsp;<span class="badge badge-outline-warning" ><strong>R</strong></span>';
			}
			
			if($row['lead_id']==0){
				$sales_handler='Admin';
			}else{
				$sales_handler=$row['sales_handler'];
			}
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']);
			//sales_handler
			$array1 = json_decode($row['scheduled_order_info'],true);
			 $i=0;if($array1) {
				 $upSatatus="";
				 $total_items=count($array1);
				 foreach($array1 as $key1 => $value1){
				 if($value1['item_unit_qty_input']!=0){
					 $us="";
					 $i++;
					 if(isset($value1['online_ref_number'])){
						 $ref="";
						 if($value1['online_ref_number']!=""){
						 $ref='<span  >#'.$value1['online_ref_number'].'</span><br/>';
						 }
					}else{
						$ref="";
					}
					
					$sel="SELECT * FROM rs_design_departments WHERE schedule_department_id='".$row['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
					//echo $sel;
					$query = $this->db->query($sel);					 
					$rsRow2=$query->row_array();
					
					$anyRejSql="SELECT RO.*,RDD.rejected_department,RDD.verify_datetime,RDD.verify_remark
					FROM
						rj_scheduled_orders as RO
						LEFT JOIN rs_design_departments as RDD on RDD.rs_design_id=RO.rs_design_id
					WHERE
						RO.schedule_department_id='".$row['schedule_department_id']."' AND
						RO.rej_summary_item_id='".$value1['summary_id']."'
						ORDER BY RO.rej_order_id DESC LIMIT 1";
					$queryRej = $this->db->query($anyRejSql);					 
					$any_rejection=$queryRej->row_array();
					if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].'<br/> Rejected</span>';
$upSatatus=0;
					}else{
						
						if(isset($rsRow2)){
							
							if($rsRow2['verify_status']==1){
							$st='<span class="badge badge-outline-success" >Approved </span>';
							}
							if($rsRow2['verify_status']==-1){
							$st='<span class="badge badge-outline-danger" >Rejectd</span>';
							}
							if($rsRow2['verify_status']==0){
							$st='<span class="badge badge-outline-warning" >Waiting</span>';
							}
							
							
								
						}else{
							$st='<span class="badge badge-outline-warning" >Order Not Submitted</span>';
							
						}
						if($row['department_schedule_date']<= date('Y-m-d') && $rsRow2['verify_status']!=1){
						$us='&nbsp;<a href="#" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="up" ><label class="badge badge-primary" style="cursor: pointer;"><i class="fa fa-refresh" ></i></label></a>';
						}
						
					}
					
					$info='&nbsp;<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'" data-act="list" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
					
					$option='&nbsp;<a href="'.base_url('myaccount/order_view/'.$row['schedule_uuid']).'/'.$row['schedule_department_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>';
					 
					 if(isset($rsRow2)){
					
						echo'
						<tr><td><span class="badge" style="background-color:'.$row['priority_color_code'].';" >'.date("d-m-Y", strtotime($row['department_schedule_date'])).'</span></td>';
						echo '<td><span class="badge badge-success" >'.$row['orderform_number'].' ('.$i.'/'.$total_items.')</span>'.$re.'</td>';
						echo '<td><span class="badge" >'.$row['wo_date_time'].'</span></td>';
						echo '<td>'.date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])).'</td>';
						echo '<td>'.$sales_handler.'</td>';
						echo '<td><label class="badge badge-outline-success">'.$wo_product_info.$ref.$value1['product_type'].'-'.$value1['item_unit_qty_input'].'</label></td>';
						echo '<td>'.$st.'</td>';
						echo '<td>'.$info.$us.$option.'</td></tr>';
					
					 }
					$upSatatus="";
					 
				 }
			 }
			 }
			 
			
		}
		//$records['data']=$data;
		//echo json_encode($records);	
?>
</tbody>



</table>
</div>
</div>
</div>
</div>
</div>

<div class="modal" id="orderSummary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content"></div> 
</div>
</div>
<div class="modal" id="itemInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>
<div class="modal" id="orderItemUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

<script>


 $(function() {
    $('#listing').DataTable({
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      },
	  
    });
    $('#listing').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });


$(function() {



$('#orderSummary').on('show.bs.modal', function (event) {
	
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var sdid=button.data('sdid');
	var did=button.data('did');
	
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&did="+did;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/order_response/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});  
		   


});
</script>
<script>
$(function() {
	$('#orderItemUpdate').on('hidden.bs.modal', function () {
	 location.reload();
	})

	$('#orderItemUpdate').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var sdid=button.data('sdid');
	var smid=button.data('smid');
	var did=button.data('did');
	var act=button.data('act');
	//alert(act);
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&smid="+smid+"&did="+did+"&act="+act;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("design/updates_design/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	}); 
	
	$('#itemInfo').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var sdid=button.data('sdid');
	var smid=button.data('smid');
	var did=button.data('did');
	var act=button.data('act');
	//alert(act);
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&smid="+smid+"&did="+did+"&act="+act;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/order_info/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
	
	
	
});
</script>
