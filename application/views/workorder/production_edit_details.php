<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:100%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php echo validation_errors();?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>


<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/index');?>">List</a></span> 
</h4>
<?php //print_r($row);?>

<?php echo form_open_multipart(base_url('work/details/'.$row['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $row['wo_client_id'];?>" />

<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Order Details</strong></p>
<div class="row">
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Special requirement</label>
<div class="col-md-10">
<textarea class="form-control" id="wo_special_requirement" name="wo_special_requirement" rows="4"><?php echo $row['wo_special_requirement'];?></textarea>
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
<option value="<?php echo $prty['priority_id'];?>" <?php if($prty['priority_id']==$row['wo_work_priority_id']) { echo ' selected="selected"';} ?> ><?php echo $prty['priority_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Shipping Mode *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_shipping_mode_id" name="wo_shipping_mode_id"  > 
<option value="">--- Select ---</option>
<?php if($shipping_modes){ ?>
<?php foreach($shipping_modes as $SMS){ ?>
<option value="<?php echo $SMS['shipping_mode_id'];?>" <?php if($SMS['shipping_mode_id']==$row['wo_shipping_mode_id']) { echo ' selected="selected"';} ?>><?php echo $SMS['shipping_mode_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>     

<input type="hidden" name="customer_shipping_id" id="customer_shipping_id" value="<?php echo $row['customer_shipping_id'];?>" />
<input type="hidden" name="customer_billing_id" id="customer_billing_id" value="<?php echo $row['customer_billing_id'];?>" />


<input type="hidden" name="shipping_customer_id" id="shipping_customer_id" value="<?php echo $row['shipping_customer_id'];?>" />
<input type="hidden" name="billing_customer_id" id="billing_customer_id" value="<?php echo $row['billing_customer_id'];?>" />

<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Billing Address *</label>
<div class="col-md-10">
<textarea class="form-control required" id="billing_address" name="billing_address" rows="4"><?php echo $row['billing_address'];?></textarea>
</div>
</div>
</div>

<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Shipping Address *</label>
<div class="col-md-10">
<textarea class="form-control required" id="shipping_address" name="shipping_address" rows="4"><?php echo $row['shipping_address'];?></textarea>
</div>
</div>
</div>



</div>






<input class="btn btn-primary float-right" type="submit" value="Save & Continue" id="submit" name="submit">
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>
<script language="javascript">

$(function() {
		   
$("#grp_date").on("change",function(){
									
									var selected = $(this).val();
	var post_data = {
'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
gpdate:selected
};								
									
	
	//alert(selected);
	//var post_data='gp_data='+selected;
	$.ajax({
	type: "POST",
	url: "<?= base_url("workorder/group_ajax/");?>",
	data: post_data
	}).done(function(reply) {
		//$('#loadClientData').html("");
		$('#grp_number').val(reply);
	});
});

$('.mydatepicker').datepicker({
enableOnReadonly: false,
todayHighlight: false,
});

$("#dataform").validate({
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