<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">WORK ORDER FILTER</h4>
	<?php echo form_open("/",'id="wo_search"') ?>
    <div class="row">
    <div class="col-md-2"> 
    <label>Order Date:</label>
    <input name="wo_date" type="text" class="form-control  datepicker" readonly="readonly" value="<?php echo $this->session->userdata('wo_date');?>" />
    </div>
    
    <div class="col-md-2"> 
    <label>Dispatch Date:</label>
    <input name="wo_dispatch_date" type="text" class="form-control  datepicker" readonly="readonly" value="<?php echo $this->session->userdata('wo_dispatch_date');?>" />
    </div>
    
    <div class="col-md-4"> 
    <label>Order no:</label>
    <input name="orderform_number" type="text" class="form-control"  value="<?php echo $this->session->userdata('orderform_number');?>" />
    </div>
    
    <div class="col-md-4"> 
    <label>Order Ref No:</label>
    <input name="wo_ref_numbers" type="text" class="form-control"  value="<?php echo $this->session->userdata('wo_ref_numbers');?>" />
    </div>
    
    <div class="col-md-3"> 
    <label>Customer:</label>
    <input name="wo_customer_name" type="text" class="form-control "  value="<?php echo $this->session->userdata('wo_customer_name');?>" />
    </div>
    
    <div class="col-md-3"> 
    <label>Priority :</label>
    <select class="form-control required" id="wo_work_priority_id" name="wo_work_priority_id"  > 
    <option value="">--- Select ---</option>
    <?php if($priority){ ?>
    <?php foreach($priority as $prty){ ?>
    <option value="<?php echo $prty['priority_id'];?>"  <?php if($prty['priority_id']==$this->session->userdata('wo_work_priority_id')) { echo ' selected="selected"';} ?>  ><?php echo $prty['priority_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>

	<div class="col-md-3"> 
    <label>Order Status :</label>
	<select class="form-control required" id="is_scheduled" name="is_scheduled"  > 
    <option value="">--- Select ---</option>
 	<option value="1">Scheduled</option>
	<option value="0">Not Scheduled</option>
	</select>
	</div>
    
    
   
    
    <div class="col-md-2"> <button type="button" style="margin-top:30px;" onclick="wo_filter()" class="btn btn-info">Submit</button>
    <a href="<?= base_url('orders/online'); ?>" class="btn btn-danger" style="margin-top:30px;"><i class="fa fa-repeat"></i></a>
</div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
</div>
</div>


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


<h4 class="card-title">Online ORDERS
</h4>
<div class="row">
<div class="col-12 table-responsive">
<table id="listing" class="table" >
<thead>
<tr>

<th>Order Number</th>
<th>Customer</th>

<th>Order Date</th>
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

    <div class="modal" id="productionSummary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	  url: '<?php echo base_url();?>orders/online_filter',
	  async: true,
	  success: function(output){
		  table.ajax.reload( null, false );
	  }
  });
}

	var table = $('#listing').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?=base_url('orders/online_wo_list')?>",
     "order": [[0,'desc']],
      "columnDefs": [
        { "targets": 0, "name": "orderform_number", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "wo_customer_name", 'searchable':true, 'orderable':true},
		{ "targets": 2, "name": "wo_staff_name", 'searchable':true, 'orderable':true},
        { "targets": 3, "name": "wo_date_time", 'searchable':true, 'orderable':true},
        { "targets": 4, "name": "wo_dispatch_date", 'searchable':true, 'orderable':true},
        { "targets": 5, "name": "wo_status_id", 'searchable':false, 'orderable':true},
      ]
    });
$(function() {



$('#productionSummary').on('show.bs.modal', function (event) {
	
	
	var button = $(event.relatedTarget);
	var oid=button.data('oid');
	var uid=button.data('uid');
	
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&oid="+oid+"&uid="+uid;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("orders/order_summary/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});  
		   


});
</script>