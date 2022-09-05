<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">

<div class="card-body">


<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:50%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php validation_errors();?>
<?php isset($msg)? $msg: ''; ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error1')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('error1')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success1')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('success1')?>
</div>
<?php endif; ?>



<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('designation/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;">Update Designation  </p>


<?php echo form_open(base_url('designation/edit/'.$row['designation_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden"  name="designation_id" id="designation_id" value="<?php echo $row['designation_id'];?>" />
<div class="form-group row">
<div class="col-lg-3">
<label class="col-form-label">Designation Name</label>
</div>
<div class="col-lg-9">
<input class="form-control "  name="designation_name" id="designation_name" type="text"  value="<?php echo $row['designation_name'];?>" required="">
</div>
</div>

<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Designation Parent</label></div>
<div class="col-lg-9">
<select class="form-control required" id="designation_parent" name="designation_parent">
<option value="">--- Select ---</option>
<option value="0" <?php if($row['designation_parent']=='0'){ echo 'selected="selected"'; }?>>No Parent</option>
<?php if($parent_desi){ ?>
<?php foreach($parent_desi as $PD){  if($PD['designation_id']!=$row['designation_id']){ ?>
<option value="<?php echo $PD['designation_id'];?>" <?php if($PD['designation_id']==$row['designation_parent']){ echo 'selected="selected"'; }?> ><?php echo $PD['designation_name'];?></option>
<?php } } ?>
<?php } ?>
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