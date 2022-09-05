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

<h4 class="card-title"><?php echo $title_head;?></h4>

<div class="row">

<div class="col-12 table-responsive">

<table id="listing" class="table" >

<thead>

<tr>

<th>Order Number</th>

<th>Scheduled Date</th>

<th>Unit</th>

<th>Start Date</th>

<th>Dispatch Date</th>

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



<div class="modal" id="approveDeny" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog modal-md" role="document">

<div class="modal-content"></div> 

</div>

</div>



<script>



	var table = $('#listing').DataTable( {

      	"processing": true,

      	"serverSide": true,

      	"ajax": "<?=base_url('accounts/orders_list')?>",

     	"order": [[0,'desc']],

      "columnDefs": [

          { "targets": 0, "name": "WO.orderform_number", 'searchable':true, 'orderable':true},

        { "targets": 1, "name": "SHD.department_schedule_date", 'searchable':false, 'orderable':false},

		{ "targets": 2, "name": "production_unit_name", 'searchable':false, 'orderable':false},

        { "targets": 3, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},

		{ "targets": 4, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},

		{ "targets": 5, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},

		{ "targets": 6, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},

		

      ]

    });

$(function() {







	$('#approveDeny').on('show.bs.modal', function (event) {

	var button = $(event.relatedTarget);

	var rdid=button.data('rdid');

	var sid=button.data('sid');

	var smid=button.data('smid');

	var afor=button.data('afor');

	

	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&rdid="+rdid+"&sid="+sid+"&smid="+smid+"&afor="+afor;

	//var cid=button.data('cid');

	//alert(oid);

	var modal = $(this);

	//var dataString = "cuid="+cuid;

	$.ajax({  

	type: "POST",

	url: "<?= base_url("accounts/approve_denay/");?>",  

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

