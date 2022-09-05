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
  <div class="col-md-12 grid-margin transparent">
    <div class="card" style="height:75vh;overflow-y:scroll;">
      <div class="card-body">
	<h4 class="card-title">Accounts</h4>
	<div class="row">
	  
	  <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
	    
	    <ul class="nav nav-tabs tab-basic" role="tablist">
	      <li class="nav-item">
		<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#ourgoal" role="tab" aria-controls="ourgoal" aria-selected="true">Upcoming</a>
	      </li>
	      <li class="nav-item">
		<a class="nav-link" id="contact-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">All</a>
	      </li>
	      <li class="nav-item">
		<a class="nav-link" id="overdue-tab" data-toggle="tab" href="#overdue" role="tab" aria-controls="overdue" aria-selected="false">Overdue</a>
	      </li>
	    </ul>
	    
	    	    <div class="tab-content tab-content-basic"  >
	    <div class="tab-pane fade show active" id="ourgoal" role="tabpanel" aria-labelledby="profile-tab" >
		    
		    <?php
		       $tasksToday=$this->myaccount_model->get_upcoming_orders($date_filter);
		    if($tasksToday){
		    ?>
	      <div class="table responsive">
		<table class="table table-striped table-borderless" id="orders1">
		  <thead>
		    <tr>
		      <th>Order No:</th>
		      <th>Name</th>
		      <th>Total Amount</th>
		      <th>Advance Amount</th>
		      <th>Bal Amount</th>	      
		      		      <th>Sales/User</th>
		    </tr>
		  </thead>
		  <tbody>

		    
		    <?php
		       foreach($tasksToday as $TT){
		       ?>
		    <tr  class="m-1">
		      <td><?php echo $TT['orderform_number'];?></td>		     
		      <td><?php echo $TT['wo_customer_name'];?></td>
		      <td><?php echo $TT['wo_gr	oss_cost'];?></td>
		      <td><?php echo $TT['wo_advance'];?></td>		     
		      <td><?php echo $TT['wo_balance'];?></td>
		        <td><?php echo $TT['wo_staff_name'];?></td>

		      
		    </tr>	
		    
		    <?php
		       }
		       ?>
		  </tbody>
		</table>
	      </div>
	      
	      <?php }else{?>
	      <div class="alert alert-warning" role="alert">No details found...!</div>
	      <?php } ?>
	    </div>
	    
	    
	    
	    
	    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="contact-tab">
		    <?php
		       $tasksTommorow=$this->myaccount_model->get_overdue_upcoming_orders($date_filter);
		    if($tasksTommorow){
		    ?>
	      <div class="table">
		<table class="table table-striped table-borderless" id="orders2">
		  <thead>
		    <tr>
		      <th>Order No:</th>
		      <th>Name</th>
		      <th>Total Amount</th>
		      <th>Advance Amount</th>
		      <th>Bal Amount</th>'		      
		       <th>Sales/User</th>

		    </tr>
		  </thead>
		  <tbody>
		    

		    
		    <?php
		       foreach($tasksTommorow as $TTM){
		       ?>
		    <tr  class="m-1">
		      <td><?php echo $TTM['orderform_number'];?></td>		     
		      <td><?php echo $TTM['wo_customer_name'];?></td>
		      <td><?php echo $TTM['wo_gross_cost'];?></td>
		      <td><?php echo $TTM['wo_advance'];?></td>		     
		      <td><?php echo $TTM['wo_balance'];?></td>		     
		      <td><?php echo $TTM['wo_staff_name'];?></td>
		     
		      
		    </tr>	
		    
		    
		    <?php
		       }
		       ?>
		  </tbody>
		</table>
	      </div>
	      
	      <?php }else{?>
	      <div class="alert alert-warning" role="alert">No details found...!</div>
	      <?php } ?>
	    </div>
	    
	    <div class="tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">

		    <?php
		       $tasksTommorow=$this->myaccount_model->get_overdue_orders($date_filter);
		    if($tasksTommorow){
		    ?>
	      <div class="table">
		<table class="table table-striped table-borderless" id="orders3">
		  <thead>
		    <tr>
		      <th>Order No:</th>
		      <th>Name</th>
		      <th>Total Amount</th>
		      <th>Advance Amount</th>
		      <th>Bal Amount</th>		      
		      
		      <th>Sales/User</th>

		    </tr>
		  </thead>
		  <tbody>
		    
		    <?php
		 foreach($tasksTommorow as $TTM){
		       ?>
		    <tr  class="m-1">
		      <td><?php echo $TTM['orderform_number'];?></td>		     
		      <td><?php echo $TTM['wo_customer_name'];?></td>
		      <td><?php echo $TTM['wo_gross_cost'];?></td>
		      <td><?php echo $TTM['wo_advance'];?></td>		     
		      <td><?php echo $TTM['wo_balance'];?></td>
		      <td><?php echo $TTM['wo_staff_name'];?></td>
		      
		      
		    </tr>	
		    
		    
		    <?php
		       }
		       ?>
		  </tbody>
		</table>
	      </div>

	      <?php }else{?>
	      <div class="alert alert-warning" role="alert">No details found...!</div>
	      <?php } ?>
	    </div>
	    
	    
	    
	    
	    </div>
	  </div>
	</div>
      </div>
    </div>
  </div>
</div>



<script>
(function($) {
'use strict';
$(function() {
$('#orders1').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('#orders2').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('#orders3').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('#orders1').each(function() {
var datatable = $(this);
// SEARCH - Add the placeholder for Search and Turn this into in-line form control
var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
search_input.attr('placeholder', 'Search');
search_input.removeClass('form-control-sm');
// LENGTH - Inline-Form control
var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
length_sel.removeClass('form-control-sm');
});
$('#orders2').each(function() {
var datatable = $(this);
// SEARCH - Add the placeholder for Search and Turn this into in-line form control
var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
search_input.attr('placeholder', 'Search');
search_input.removeClass('form-control-sm');
// LENGTH - Inline-Form control
var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
length_sel.removeClass('form-control-sm');
});
$('#orders3').each(function() {
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


