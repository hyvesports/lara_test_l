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
<h4 class="card-title"><?php echo $title;?></h4>
<div class="row">
<div class="col-12 table-responsive">
<table id="listing" class="table" >
<thead>
<tr>
<th>Order Number</th>
<th>Scheduled Date</th>
<th>Unit</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>
</table>
</div>
</div>
</div>
</div>
</div>

<div class="modal" id="orderSummary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content"></div> 
</div>
</div>

  <script>
    $('.datepicker').datepicker({
      autoclose: true,
	   format: 'yyyy-mm-dd'
    });
  </script>
<script>
function wo_filter()
{
  var _form = $("#wo_search").serialize();
  $.ajax({
	  data: _form,
	  type: 'post',
	  url: '<?php echo base_url();?>orders/offline_filter',
	  async: true,
	  success: function(output){
		  table.ajax.reload( null, false );
	  }
  });
}
function deleteRow(){
	  if(confirm("Are you sure you want to delete.?")){
		  return true;
	  }
	  return false;
}
	var table = $('#listing').DataTable( {
      	"processing": true,
      	"serverSide": true,
      	"ajax": "<?=base_url('myaccount/orders_list')?>",
     	"order": [[0,'desc']],
      "columnDefs": [
        { "targets": 0, "name": "schedule_id", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "schedule_c_date", 'searchable':true, 'orderable':true},
		{ "targets": 2, "name": "production_unit_name", 'searchable':false, 'orderable':false},
        { "targets": 3, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},
		
      ]
    });

$(function() {



$('#orderSummary').on('show.bs.modal', function (event) {
	
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var sdid=button.data('sdid');
	var did=button.data('did');
	
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&did="+did;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/order_response/");?>",  
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
