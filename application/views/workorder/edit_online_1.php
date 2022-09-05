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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Order Details</strong></p>
<?php echo form_open(base_url('workorder/edit_online/'.$woRow['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>


<input type="hidden" name="order_id" id="order_id" value="<?php echo $woRow['order_id'];?>" />
<input type="hidden" name="orderform_type_id" id="orderform_type_id" value="2" />
<?php 


//print_r($woRow);?>

<div class="row">


<div class="col-md-6"  id="orderno">
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

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Priority *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_work_priority_id" name="wo_work_priority_id"  > 
<option value="">--- Select ---</option>
<?php if($priority){ ?>
<?php foreach($priority as $prty){ ?>
<option value="<?php echo $prty['priority_id'];?>" <?php if($prty['priority_id']==$woRow['wo_work_priority_id']) { echo ' selected="selected"';} ?>><?php echo $prty['priority_name'];?></option>
<?php } ?>
<?php } ?>
</select>
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

<table width="100%" class="table table-striped   mt-0 "  >
    <thead>
    <tr class="item_header">
    <th width="10%"   class="text-left">Ref No:</th>
    <th width="15%"  class="text-left">Product</th>
    <th width="15%"  class="text-left">Collar</th>
    <th width="13%"  class="text-left">Sleeve</th>
    <th width="14%"  class="text-left">Fabric</th>
    <th width="11%"  class="text-left">Add-ons</th>
    <th width="12%"  class="text-left">Qty</th>
    <th width="10%">Action</th>
    </tr>
    </thead>
    
    <tbody id="invDataTableRow">
    <?php $crow=0; if($summary){ ?>
    <?php foreach($summary as $sd){ ?>
    <tr>
    <td>
    <?php if($sd['summary_parent']==0){ ?>
    <a href="javascript:void(0);" title="Add Sub New Item" style="cursor: pointer;" data-toggle="modal" data-target="#addNewRefNo" data-afor="<?php echo ucwords($sd['order_summary_id']);?>" ><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-plus" ></i> <?php echo ucwords($sd['wo_ref_no']);?></label></a>
    <?php }else{ ?>
    <label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-arrow-circle-right"></i></label>
    <?php } ?>
    </td>
    <td><?php echo ucwords($sd['wo_product_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_collar_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_sleeve_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_fabric_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_addon_name']);?></td>
    <td><?php echo ucwords($sd['wo_qty']);?> <?php //echo base_url('workorder/remove_summary_item/'.$sd['online_draft_id']);?></td>
    <td>
    
                        
    <a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($sd['order_summary_id']);?>" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
    
    <a href="javascript:void(0);" onclick="deleteMe(<?php echo $sd['order_summary_id'];?>);" title="Delete" style="cursor: pointer;" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>
    
    </td>
    </tr>
    <?php $crow++;} ?>
    <?php } ?>
    </tbody>
    
<tfoot>
<tr>
<td  align="center" colspan="8">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewRefNo" data-afor="0"  >
<i class="icon-plus-square"></i> <i class="fa fa-plus"></i> Add New Reference Number Row <?php //echo $crow;?>
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


	$('#addNewRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'cid' : '<?php echo $woRow['order_id'];?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("workorder/onlinemodel/");?>"+afor,  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
	
	$('#editRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'cid' : '<?php echo $woRow['order_id'];?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("workorder/edit_summary_item/");?>"+afor,  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
		   
		   
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
});
</script>
<div class="modal fade " id="addNewRefNo" tabindex="-1">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div> 
<div class="modal fade " id="editRefNo" tabindex="-1">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>
