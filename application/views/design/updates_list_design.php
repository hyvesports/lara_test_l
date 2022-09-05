

<?php
print_r($_POST);
$schedule_department_id=$_POST['sdid'];
$schedule_id=$_POST['sid'];
$summary_id=$_POST['smid'];

$sel="SELECT DD.*,SS.schedules_status_name FROM
rs_design_departments  as DD
LEFT JOIN sh_schedules_status as SS on SS.schedules_status_id=DD.status_id
WHERE 
DD.schedule_department_id='$schedule_department_id'  AND
DD.summary_item_id='$summary_id' ORDER BY DD.rs_design_id DESC ";
//echo $sel;
$query = $this->db->query($sel);					 
$updates=$query->result_array();
//print_r($updates);


$rej="select * from sh_schedule_department_rejections where summary_id='$summary_id'";


$queryD = $this->db->query($rej);
$rejupdates=$queryD->result_array();

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

<th>QC Status</th>
</tr>
</thead>
<tbody>

<?php if($updates){ ?>
<?php foreach($updates as $UP){ ?>
<tr>
<td>
<p class="text-primary font-weight-normal"><?php echo $UP['schedules_status_name'];?></p>
<p class="text-muted mb-2">Remark:<?php echo $UP['response_remark'];?></p>
<p class="text-muted mb-2">URL:<?php echo $UP['response_url'];?></p>
<p class="text-muted mb-2"><?php echo $UP['submitted_datetime'];?></p>
</td>

<td>
<?php if($UP['status_value']==0){ echo 'Nil';?>
<?php }else{ ?>
	<?php if($UP['verify_status']==0){ ?>
    <p class="text-warning font-weight-normal">Waiting For Approval</p>
   
    <?php }else if($UP['verify_status']==-1){?>
    <p class="text-danger font-weight-normal">Rejected</p>
    <p class="text-muted mb-2"><?php echo $UP['verify_remark'];?></p>
	<p class="text-muted mb-0"><?php echo $UP['verify_datetime'];?></p>
    <?php }else{ ?>
    <p class="text-danger font-weight-normal">Approved</p>
    <p class="text-muted mb-2"><?php echo $UP['verify_remark'];?></p>
	<p class="text-muted mb-0"><?php echo $UP['verify_datetime'];?></p>
    <?php } ?>
<?php } ?>
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

<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">Rejected Updates</h4>
<table class="table">
<thead>
<tr>
<th>Rejcted From</th>
<th>Rejected Remark</th>
<th>Rejected Qty</th>
</tr>
</thead>
<tbody>

<?php if($rejupdates){ ?>
<?php foreach($rejupdates as $dep){ ?>
<tr>
<td>
<?php echo $dep['rejected_from_departments'];?>
</td>
<td>
<?php echo $dep['rejected_remark'];?>
</td>
<td>
<?php echo $dep['rejected_qty'];?>
</td>
</tr>
<?php } }?>
</tbody>
</table>
</div></div></div>

</div>
</div>  
