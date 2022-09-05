<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:100%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php echo validation_errors();?>
</div>
<?php endif; ?>
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
<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/index');?>">List</a><a class="btn btn-success m-1 " href="<?php echo base_url('workorder/view/'.$woRow['order_uuid']);?>">View</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Order Details</strong></p>
<?php echo form_open(base_url('formdata/edit/'.$woRow['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="lead_id" id="lead_id" value="<?php echo $lead_info['lead_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $lead_info['lead_client_id'];?>" />
<input type="hidden" name="wo_owner_id" id="wo_owner_id" value="<?php echo $lead_info['lead_owner_id'];?>" />
<input type="hidden" name="wo_owner_id" id="wo_owner_id" value="<?php echo $lead_info['lead_owner_id'];?>" />
<input type="hidden" name="order_id" id="order_id" value="<?php echo $woRow['order_id'];?>" />
<input type="hidden" name="wo_staff_name" id="wo_staff_name" value="<?php echo $lead_info['staff_code'];?>,<?php echo $lead_info['staff_name'];?>" />
<input type="hidden" name="wo_customer_name" id="wo_customer_name" value="<?php echo $lead_info['customer_name'];?>,<?php echo $lead_info['customer_mobile_no'];?>,<?php //echo $lead_info['customer_email'];?>" />
<?php 
//print_r($woRow);?>
<div class="row">
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Type *</label>
<div class="col-md-8">
<select class="form-control required" id="orderform_type_id" name="orderform_type_id" onchange="woNumber(this.value,<?php echo $lead_info['lead_id'];?>)" > 
<?php if($order_types){ ?>
<?php foreach($order_types as $OT){ ?>
<option value="<?php echo $OT['wo_type_id'];?>" <?php if($OT['wo_type_id']==$woRow['orderform_type_id']) { echo ' selected="selected"';}else { echo  'disabled="disabled"'; } ?>><?php echo $OT['wo_type_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>
<div class="col-md-6"  id="orderno">
<script language="javascript">
function woNumber(ot,ln){
	if(ot=='2'){ // offline
		//alert("online");
		$("#product_info").show();
	}else{
		//alert("Offline");
		$("#product_info").hide();
	}
var post_data = {
'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
'ot':+ot,
'ln':+ln,
};
$('#orderform_number_load').html("<p style='text-align:center'>Loading... </p>");
//alert(cid);
$.ajax({
type: "POST",
url: "<?= base_url("workorder/wonumber/");?>",
data: post_data
}).done(function(reply) {
	$('#orderform_number_load').html("");
	$('#orderform_number').val(reply);
});
}
</script>
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Number*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="orderform_number" id="orderform_number" value="<?php echo $woRow['orderform_number'];?>" readonly="readonly" >
<span id="orderform_number_load"></span>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Nature *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_order_nature_id" name="wo_order_nature_id"  > 
<option value="">--- Select ---</option>
<?php if($order_nature){ ?>
<?php foreach($order_nature as $ON){ ?>
<option value="<?php echo $ON['order_nature_id'];?>" <?php if($ON['order_nature_id']==$woRow['wo_order_nature_id']) { echo ' selected="selected"';} ?>><?php echo $ON['order_nature_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Dispatch Date *</label>
<div class="col-md-8">
<input name="wo_dispatch_date" id="wo_dispatch_date" type="text" class="form-control  datepicker required" readonly="readonly" 
value="<?php echo $woRow['wo_dispatch_date']; ?>" />
</div>
</div>
</div>
</div>

<span id='product_info' >
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Product Information </strong></p>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row">
<div class="col-md-12">
<input name="wo_product_info" id="wo_product_info" type="text" class="form-control required" value="<?php echo $woRow['wo_product_info']; ?>" />
</div>
</div>
</div>

<div class="col-md-12">
</div>
</div>
</span>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Order summary </strong></p>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row" id="contentDiv">
        <table class="table table-striped mb-0" width="100%">
        <thead>
        <tr class="item_header">
        <th width="13%"  class="">Product</th>
        <th width="13%"  class="">Collar</th>
        <th width="13%"  class="">Sleeve</th>
        <th width="13%"  class="">Fabric</th>
        <th width="13%"  class="">Add-ons</th>
        <th width="8%"  class="">Qty</th>
        <th width="11%"  class="">Rate</th>
        <th width="13%"  class="">Discount</th>
        <th width="10%"></th>
        </tr>
        </thead>
        <tbody id="invDataTableRow">
        <?php $count_item=0;if($summary) { $inc=0; $count_item=count($summary);?>
        <?php foreach($summary as $item) {?>
        <tr id="inv-row<?php echo $inc;?>"  class="draftItems">
        <td><?php echo $item['wo_product_type_name'];?></td>
        <td><?php echo $item['wo_collar_type_name'];?></td>
        <td><?php echo $item['wo_sleeve_type_name'];?></td>
        <td><?php echo $item['wo_fabric_type_name'];?></td>
        <td><?php echo $item['wo_item_addons_names'];?></td>
        <td><?php echo $item['wo_qty'];?></td>
        <td><?php echo $item['wo_rate'];?></td>
        <td><?php echo $item['wo_discount'];?></td>
        <td>
<a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($item['order_summary_id']);?>" ><label class="badge badge-warning m-1" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
 <a href="javascript:void(0);" onclick="deleteMe(<?php echo $item['order_summary_id'];?>);" title="Delete" style="cursor: pointer;" ><label class="badge badge-danger m-1" style="cursor: pointer;"><i class="fa fa-trash" ></i><?php //echo $sd['offline_draft_id'];?></label></a>
</td>
        </tr>
		<?php $inc++; } }?>
        </tbody>
        <tfoot>
<tr>
<td  align="center" colspan="8">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewRefNo" data-afor="0"  >
<i class="icon-plus-square"></i> <i class="fa fa-plus"></i> Add Order Item
</button>
</td>
</tr>
</tfoot>
        </table>
</div>
</div>
</div>

<input class="btn btn-primary float-right" type="submit" value="Save and Continue" id="submit" name="submit">
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>
<script>
    $('.datepicker').datepicker({
      autoclose: true,
	   format: 'yyyy-mm-dd'
    });
  </script>
<script language="javascript">
$(function() {
	$(".js-example-basic-single").select2();
	$("#dataform1").validate({
	errorPlacement: function(label, element) {
	label.addClass('mt-2 text-danger');
	label.insertAfter(element);
	},
	highlight: function(element, errorClass) {
	$(element).parent().addClass('has-danger')
	$(element).addClass('form-control-danger')
	}
	});
$('#editRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'order_id' : '<?php echo $woRow['order_id'];?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("formdata/model_order_edit/");?>"+afor,  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});

	$('#addNewRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'cid' : '<?php echo $woRow['lead_uuid'];?>',
	'order_id' : '<?php echo $woRow['order_id'];?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(afor);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("formdata/offlinemodelinedit/");?>",  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');
	},
	success: function(response){
		modal.find('.modal-content').html(response); 
	}
	}); 
	});

});
</script>
<script>
function deleteMe(rid){
		//alert(rid);
		//$('#addNewRefNo').modal('toggle');
	if(confirm("Are you sure you want to delete.?")){
		var items=0;
		$( ".draftItems" ).each(function( index ) {items++;});
		if(items==1){
			alert("Can't Remove..");
			return false;
		}
		//$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'<?php echo 'wo_option_session_id'; ?>' : '<?php echo $woRow['wo_option_session_id']; ?>'
		};
		//$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
		$.ajax({
		type: "POST",
		url: "<?= base_url("formdata/drop_summary_item/");?>"+rid,
		data: post_data
		}).done(function(reply) {
			//alert("Yesss");
			$('#contentDiv').html(reply);
		});
	return false;
	}
}
</script>
<div class="modal fade " id="addNewRefNo">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>
<div class="modal fade " id="editRefNo">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>
