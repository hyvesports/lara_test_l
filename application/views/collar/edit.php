<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">

<div class="card-body">


<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:50%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php echo validation_errors();?>
<?php isset($msg)? $msg: ''; ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error1')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('error1')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success1')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success1')?>
</div>
<?php endif; ?>



<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('collar/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;">Update Collar Type </p>


<?php echo form_open(base_url('collar/edit/'.$row['collar_type_id']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden"  name="collar_type_id" id="collar_type_id" value="<?php echo $row['collar_type_id'];?>" />

<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Collar Type Name</label></div>
<div class="col-lg-9"><input class="form-control"  name="collar_type_name" id="collar_type_name" type="text"  value="<?php echo $row['collar_type_name'];?>" required=""></div>
</div>


<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Amount *</label></div>
<div class="col-lg-4"><input class="form-control number"  name="collar_amount" id="collar_amount" type="text"  value="<?php echo $row['collar_amount'];?>" required="" maxlength="10" min='0'></div>
</div>

<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Making Minute*</label></div>
<div class="col-lg-4"><input class="form-control number"  name="collar_making_min" id="collar_making_min" type="text"  value="<?php echo $row['collar_making_min'];?>" required="" maxlength="3" min='0' max="1000"></div>
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
// validate the comment form when it is submitted
//$("#dataform").validate();
if ($(".color-picker").length) {
$('.color-picker').asColorPicker();
}
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