<style>
.fs-30 {
  font-size: 30px;
}
.cardWo {
    height: 100%;
    max-height: 390px;
    overflow: scroll;
}
</style>
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
    <div class="card">
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
	<div class="col-md-4 grid-margin transparent">
    <div class="row">
    
    <div class="col-md-12 mb-4 stretch-card transparent">
    <div class="card card-dark-blue">
    <div class="card-body">
    <h4 class="card-title mb-0">Max Deal Size</h4>
    <div class="d-flex justify-content-between align-items-center">
    <div class="d-inline-block pt-3">
    <div class="d-md-flex">
    <h2 class="mb-0"><?php echo $leadArray['wo_max_gross_total'];?></h2>
    </div>
    </div>
    </div>
    </div>
    
    </div>
    </div>
    </div>

	<div class="row">
    <div class="col-md-12 mb-4 stretch-card transparent">
    <div class="card card-dark-blue">
    <div class="card-body">
    <h6 class="card-title mb-0">Average Deal Size</h6>
    <div class="d-flex justify-content-between align-items-center">
    <div class="d-inline-block pt-3">
    <div class="d-md-flex">
    <h2 class="mb-0"><?php echo floor($leadArray['order_total_avg']);?></h2>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
	
	<div class="row">
    <div class="col-md-12 mb-4 stretch-card transparent">
    <div class="card card-dark-blue">
    <div class="card-body">
    <h4 class="card-title mb-0">Average Time Per Lead</h4>
    <div class="d-flex justify-content-between align-items-center">
    <div class="d-inline-block pt-3">
    <div class="d-md-flex">
    <h2 class="mb-0"><?php echo floor($leadArray['order_time_avg']);?></h2>
    </div>
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
