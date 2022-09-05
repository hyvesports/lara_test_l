<?php
$schedule_department_id=$_POST['sdid'];
$schedule_id=$_POST['sid'];
$summary_id=$_POST['smid'];
//echo 'fgdfg';
$sel="SELECT 
	DD.*,SS.schedules_status_name,department_master.department_name
FROM
	rs_design_departments  as DD
	LEFT JOIN sh_schedules_status as SS on SS.schedules_status_id=DD.status_id
	LEFT JOIN department_master on department_master.department_id=DD.approved_dept_id
WHERE 
DD.schedule_id='$schedule_id'  AND
DD.summary_item_id='$summary_id' ORDER BY DD.rs_design_id DESC ";
//echo $sel;
$query = $this->db->query($sel);					 
$updates=$query->result_array();
//print_r($updates);
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">x</span>
</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">All Updates</h4>
<table class="table">
<thead>
<tr>
<th>Update</th>
<!--<th>Status</th>-->
</tr>
</thead>
<tbody>

<?php if($updates){ ?>
<?php foreach($updates as $UP){ 
	$department_name=ucwords($UP['department_name']);
?>
<tr>
<td>
<p class="text-primary font-weight-normal"><?php echo $UP['schedules_status_name'];?></p>
<p class="text-muted mb-2">Remark:<?php echo $UP['response_remark'];?></p>
<p class="text-muted mb-2">URL:<?php echo $UP['response_url'];?></p>
<p class="text-muted mb-2"><?php echo $UP['submitted_datetime'];?></p>
</td>



</tr>
<?php } ?>
<?php }else{ ?>

<tr>
<td colspan="2">
<div class="alert alert-success alert-dismissible" style="width:100%;"><br />
					<p>No records found!</p>
					</div>
</td>
</tr>
<?php } ?>


</tbody>
</table>
</div>
</div>
</div>

</div>
</div>  
