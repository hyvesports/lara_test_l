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
<h4 class="card-title"><?php echo $title;?> | competed</h4>
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
<th>#Order</th>
<th>Timestamp</th>
<th>Disp: Date</th>
<th>Sales Handler</th>
<th>Summary</th>
<th>Status</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>
</table>
</div>
</div>
</div>
</div>
</div>


<div class="modal" id="orderItemUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>
<div class="modal" id="allUpdates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>
<div class="modal" id="orderSummaryForDQC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content"></div> 
</div>
</div>

<script>

	var table = $('#listing').DataTable( {
      	"processing": true,
      	"serverSide": true,
		"bInfo" : true,
		"pageLength": 25,
      	"ajax": "<?=base_url('dispatch/list_works_dispatch/completed/')?>",
      "columnDefs": [
         { "targets": 0, "name": "SHD.department_schedule_date", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "WO.orderform_number", 'searchable':true, 'orderable':true},
		{ "targets": 2, "name": "WO.wo_product_info", 'searchable':false, 'orderable':false},
        { "targets": 3, "name": "PM.priority_name", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 4, "name": "SM.staff_name", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 5, "name": "WO.wo_product_info", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 6, "name": "WO.wo_product_info", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 7, "name": "WO.wo_product_info", 'searchable':false, 'orderable':false,className:'text-center'},
		
      ]
    });

$(function() {

$('#orderItemUpdate,#allUpdates').on('hidden.bs.modal', function () {location.reload();});	

$('#orderSummaryForDQC').on('show.bs.modal', function (event) {
	
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var sdid=button.data('sdid');
	var did=button.data('did');
	var ssid=button.data('ssid');
	
	
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&did="+did+"&ssid="+ssid;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/verify_order/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});  
	
	$('#allUpdates').on('show.bs.modal', function (event) {
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
	url: "<?= base_url("myaccount/all_updates_of_order/");?>",  
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
