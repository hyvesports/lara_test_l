	<style>
.fs-30 {
  font-size: 30px;
}
.icon-data-list {
    list-style-type: none;
    padding-left: 0;
    position: relative;
    margin-bottom: 0;
    font-family: "Nunito", sans-serif;
}
.icon-data-list li {
    margin-bottom: 1rem;
}
</style>

<?php
$notifactionDate=date("Y-m-d", strtotime($this->session->userdata('date_now')));

$notifications=$this->dashboard_model->get_my_notifications($notifactionDate,$this->session->userdata('staff_id'));
?>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card bg-primary text-white card-update">
<div class="card-body" style="height:60vh;overflow-y:scroll;">
<h4 class="card-title text-white">Notifications</h4>
	<?php if($notifications){ ?>
	<?php foreach($notifications as $MYDATA){ ?>
        <div class="d-flex border-light-white  update-item mt-2">
        <div>
        <h6 class="text-white font-weight-medium d-flex"><?php echo ucwords($MYDATA['log_full_name']);?>
        <span class="small ml-auto"><?php echo $MYDATA['notification_time_stamp'];?></span>
        </h6>
        <p><?php echo $MYDATA['notification_content'];?></p>
        </div>
        </div>
	<?php }?>
	<?php }else{ ?>
	<div class="alert alert-warning text-white" role="alert">Notifications not found!!!</div>
	<?php } ?>
	
    

</div>
</div>
</div>
</div>