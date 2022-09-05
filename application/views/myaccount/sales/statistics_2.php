<style>
.icon-data-list {
    list-style-type: none;
    padding-left: 0;
    position: relative;
    margin-bottom: 0;
    font-family: "Nunito", sans-serif;
}
</style>
<div class="row">
  <div class="col-md-6 grid-margin transparent">
    <div class="card" style="height:75vh;overflow-y:scroll;">
      <div class="card-body">
	<h4 class="card-title">Task</h4>
	<div class="row">
	  
	  <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
	    
	    <ul class="nav nav-tabs tab-basic" role="tablist">
	      <li class="nav-item">
		<a class="nav-link " id="home-tab" data-toggle="tab" href="#whoweare" role="tab" aria-controls="whoweare" aria-selected="true">Yesterday</a>
	      </li>
	      <li class="nav-item">
		<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#ourgoal" role="tab" aria-controls="ourgoal" aria-selected="false">Today</a>
	      </li>
	      <li class="nav-item">
		<a class="nav-link" id="contact-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Tomorrow</a>
	      </li>
	    </ul>
	    <div class="tab-content tab-content-basic" >
	      <div class="tab-pane fade " id="whoweare" role="tabpanel" aria-labelledby="home-tab" >
		<?php
		   $loginid=$this->session->userdata('loginid');
		$tasksYesterday=$this->myaccount_model->get_my_tasks_by_date($loginid,date('Y-m-d', strtotime(' -1 day')));
		if($tasksYesterday){
		?>
		<ul class="icon-data-list" >
		  <?php
		     foreach($tasksYesterday as $YT){
		     ?>
		  <li>
		    <div class="d-flex border-bottom ">
		      <div>
			<p class="text-info mb-1"><?php echo $YT['task_desc'];?></p>
			<p class="mb-0"><?php echo $YT['customer_name'];?><br/><?php echo $YT['customer_mobile_no'];?>,<?php echo $YT['customer_email'];?></p>
			<small><?php echo $YT['reminder_date'];?> <?php echo $YT['reminder_time'];?></small>
		      </div>
		    </div>
		  </li>
		  <?php
		     }
		     ?>
		</ul>
		<?php }else{?>
		<div class="alert alert-warning" role="alert">No tasks found...!</div>
		<?php } ?>
	      </div>

	      <div class="tab-pane fade show active" id="ourgoal" role="tabpanel" aria-labelledby="profile-tab" >
		<?php
		   $tasksToday=$this->myaccount_model->get_my_tasks_by_date($loginid,date('Y-m-d'));
		if($tasksToday){
		?>
		<ul class="icon-data-list" >
		  <?php
		     foreach($tasksToday as $TT){
		     ?>
		  <li>
		    <div class="d-flex border-bottom ">
		      <div>
			<p class="text-info mb-1"><?php echo $TT['task_desc'];?></p>
			<p class="mb-0"><?php echo $TT['customer_name'];?><br/><?php echo $TT['customer_mobile_no'];?>,<?php echo $TT['customer_email'];?></p>
			<small><?php echo $TT['reminder_date'];?> <?php echo $TT['reminder_time'];?></small>
		      </div>
		    </div>
		  </li>
		  <?php
		     }
		     ?>
		</ul>
		<?php }else{?>
		<div class="alert alert-warning" role="alert">No tasks found...!</div>
		<?php } ?>
	      </div>
	      <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="contact-tab">
		<?php
		   $tasksTommorow=$this->myaccount_model->get_my_tasks_by_date($loginid,date('Y-m-d', strtotime(' +1 day')));
		if($tasksTommorow){
		?>
		<ul class="icon-data-list" >
		  <?php
		     foreach($tasksTommorow as $TTM){
		     ?>
		  <li>
		    <div class="d-flex border-bottom ">
		      <div>
			<p class="text-info mb-1"><?php echo $TTM['task_desc'];?></p>
			<p class="mb-0"><?php echo $TTM['customer_name'];?><br/><?php echo $TTM['customer_mobile_no'];?>,<?php echo $TTM['customer_email'];?></p>
			<small><?php echo $TTM['reminder_date'];?> <?php echo $TTM['reminder_time'];?></small>
		      </div>
		    </div>
		  </li>
			<?php
			   }
			   ?>
		</ul>
		<?php }else{?>
		<div class="alert alert-warning" role="alert">No tasks found...!</div>
		<?php } ?>
	      </div>
	    </div>
	  </div>
	</div>
      </div>
    </div>
  </div>
  
  <?php
$notifactionDate=date("Y-m-d", strtotime($this->session->userdata('date_now')));
$notifications=$this->dashboard_model->get_my_notifications($notifactionDate,$this->session->userdata('staff_id'));
?>
<div class="col-md-6 grid-margin stretch-card">
<div class="card bg-primary text-white card-update" style="height:75vh;overflow-y:scroll;">
<div class="card-body">
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
	<?php }else{ ?><br><br>
	<div class="alert alert-warning text-white" role="alert">Notifications not found!!!</div>
	<?php } ?>
	
    

</div>
</div>
</div>
</div>
