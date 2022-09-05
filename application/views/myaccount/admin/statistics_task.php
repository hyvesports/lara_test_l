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
	$tasksYesterday=$this->myaccount_model->get_my_tasks_by_date_staff($staff_id,date('Y-m-d', strtotime(' -1 day')));
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
	$tasksToday=$this->myaccount_model->get_my_tasks_by_date_staff($staff_id,date('Y-m-d'));
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
	$tasksTommorow=$this->myaccount_model->get_my_tasks_by_date_staff($staff_id,date('Y-m-d', strtotime(' +1 day')));
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


<div class="col-md-6 grid-margin stretch-card">
	    <div class="card style='height:75vh;'">
<div class="card-body">
<p class="card-title mb-0">Revenue</p>

	<div class="table-responsive ">
    <table class="table table-striped table-borderless" id="orders">
    <thead>
    <tr>
	    <th>Order No:</th>
    <th>Name</th>
    <th>Lead Time</th>
    <th>Gross Cost</th>
    <th>Shipping Cost</th>
    </tr>
    </thead>
    <tbody>
	    <?php if($woArray){ ?>
				<?php foreach($woArray as $OD){ ?>
    <tr  class="m-1">
								<td class="font-weight-bold"><div class="badge badge-success"><?php echo $OD['orderform_number'];?></div></td>
								<td><?php echo $OD['wo_customer_name'];?></td>
								<td><?php echo $OD['lead_diff'];?></td>
								<td class="font-weight-medium"><?php echo $OD['wo_gross_cost'];?></td>
								<td class="font-weight-medium"><?php echo $OD['wo_shipping_cost'];?></td>
    </tr>
								<?php } ?>
				<?php } ?>



    </tbody>
    </table>
    </div>

    

</div>
</div>
</div>
</div>
<script>
	(function($) {
	    'use strict';
	    $(function() {
		    $('#orders').DataTable({
			    "aLengthMenu": [
					    [5, 10, 15, -1],
					    [5, 10, 15, "All"]
					    ],
				"iDisplayLength": 5,
				"language": {
				search: ""
				    }
			});
		    $('#order-listing').each(function() {
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
	})(jQuery);
</script>


