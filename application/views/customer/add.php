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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('customer/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Add New Customer</strong></p>
<?php echo form_open(base_url('customer/add'), 'class="cmxform"  id="dataform" method="post"'); ?>



<div class="row">

<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Customer Name*</label>
<div class="col-md-10">
<input type="text" class="form-control required" name="customer_name" id="customer_name" maxlength="100">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Email*</label>
<div class="col-md-8">
<input type="text" class="form-control required email" name="customer_email" id="customer_email" maxlength="100">
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Mobile No*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="customer_mobile_no" id="customer_mobile_no" maxlength="10" >
</div>
</div>
</div>


<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Customer Name*</label>
<div class="col-md-10">
<input type="text" class="form-control required" name="customer_name" id="customer_name" maxlength="100">
</div>
</div>
</div>



<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Country</label>
<div class="col-md-8">
<input type="text" class="form-control" name="country" id="country" maxlength="100" >
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">State</label>
<div class="col-md-8">
<input type="text" class="form-control" name="state" id="state" maxlength="100" >
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">City</label>
<div class="col-md-8">
<input type="text" class="form-control" name="city" id="city" maxlength="100" >
</div>
</div>
</div>


</div>




<input class="btn btn-primary float-right" type="submit" value="Submit" id="submit" name="submit">
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>
<script language="javascript">
$(function() {
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