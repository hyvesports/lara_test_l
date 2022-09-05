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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('leadstage/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;">Update Lead Stage  </p>


<?php echo form_open(base_url('leadstage/edit/'.$row['lead_stage_id']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden"  name="lead_stage_id" id="lead_stage_id" value="<?php echo $row['lead_stage_id'];?>" />

<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Stage Name*</label></div>
<div class="col-lg-9">
<input class="form-control required"  name="lead_stage_name" id="lead_stage_name" type="text"  value="<?php echo $row['lead_stage_name'];?>" required="">
</div>
</div>

<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Stage Status*</label></div>
<div class="col-lg-9">
<select class="form-control required" id="lead_stage_status" name="lead_stage_status">
<option value="">--- Select ---</option>
<option value="1" <?php if($row['lead_stage_status']==1){ echo 'selected="selected"'; } ?> >Active</option>
<option value="0" <?php if($row['lead_stage_status']==0){ echo 'selected="selected"'; } ?>>InActive</option>
</select>
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