
<?php 
//echo $selectedDate;
$woArray=$this->dashboard_model->get_wo_edit_request($selectedDate);
?>
<div class="row">
<div class="col-md-6 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<p class="card-title">Edit Request</p>
	<div class="table-responsive ">
    <table class="table table-striped table-borderless listing" id="listing">
    <thead>
    <tr>
    <th>Order No:</th>
	
    <th>Sales Owner</th>
    <th>Order Date</th>
    <th>Dispatch Date</th>
    </tr>  

    </thead>
    <tbody>
	<?php if($woArray){?>
	<?php foreach($woArray as $OR){ ?>
	<tr>
	<td><?php echo $OR['orderform_number'];?></td>
	
	<td><?php echo $OR['staff_name'];?></td>
    <td><?php  echo substr($OR['wo_date_time'],0,10);?></td>
    <td><?php echo date("d-m-Y", strtotime($OR['wo_dispatch_date']));?></td>
	</tr>
	<?php } ?>
	<?php } ?>
	</tbody>
	</table>
</div>
</div>
</div>
</div>

<?php 
//echo $selectedDate;
$submitted=date("d-m-Y", strtotime($this->session->userdata('date_now')));
$woArray2=$this->dashboard_model->get_wo_submitted($submitted);
?>
<div class="col-md-6 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<p class="card-title">Order Submitted</p>
	<div class="table-responsive ">
    <table class="table table-striped table-borderless listing" id="listing">
    <thead>
    <tr>
    <th>Order No:</th>
	
    <th>Sales Owner</th>
    <th>Order Date</th>
    <th>Dispatch Date</th>
    </tr>  

    </thead>
    <tbody>
	<?php if($woArray2){?>
	<?php foreach($woArray2 as $OR2){ ?>
	<tr>
	<td><?php echo $OR2['orderform_number'];?></td>
	
	<td><?php echo $OR2['staff_name'];?></td>
    <td><?php  echo substr($OR2['wo_date_time'],0,10);?></td>
    <td><?php echo date("d-m-Y", strtotime($OR2['wo_dispatch_date']));?></td>
	</tr>
	<?php } ?>
	<?php } ?>
	</tbody>
	</table>
</div>
</div>
</div>
</div>
<script>
(function($) {
'use strict';
$(function() {
$('.listing').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('.listing').each(function() {
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