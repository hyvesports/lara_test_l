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
<?php isset($msg)? $msg: ''; ?>
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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('tax/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;">Add New Tax</p>
<?php echo form_open(base_url('tax/add'), 'class="cmxform"  id="dataform" method="post"'); ?>
<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Tax Name *</label></div>
<div class="col-lg-9"><input class="form-control"  name="taxclass_name" id="taxclass_name" type="text"  value="<?php echo $this->input->post('taxclass_name');?>" required=""></div>
</div>

<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Tax Percentage *</label></div>
<div class="col-lg-4"><input class="form-control number"  name="taxclass_value" id="taxclass_value" type="text"  value="<?php echo $this->input->post('taxclass_value');?>" required="" maxlength="3" min='0' max="100"></div>
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
		   
if ($(".color-picker").length) {
$('.color-picker').asColorPicker();
}
  
  
// validate the comment form when it is submitted
//$("#dataform").validate();
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