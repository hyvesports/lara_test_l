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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('staff/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Update Staff</strong></p>
<?php echo form_open(base_url('staff/edit/'.$row['staff_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="login_master_id" id="login_master_id"  value="<?php echo $row['login_master_id'];?>" />
<input type="hidden" name="staff_id" id="staff_id"  value="<?php echo $row['staff_id'];?>" />
<?php //print_r($row);?>

<div class="row">
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Staff Code*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="staff_code" id="staff_code" maxlength="50"  value="<?php echo $row['staff_code'];?>">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Staff Name*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="staff_name" id="staff_name" maxlength="100" value="<?php echo $row['staff_name'];?>">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Email*</label>
<div class="col-md-8">
<input type="text" class="form-control required email" name="log_email" id="log_email" maxlength="100" value="<?php echo $row['log_email'];?>">
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Mobile No*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="log_phone_number" id="log_phone_number" maxlength="10" value="<?php echo $row['log_phone_number'];?>" >
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Designation*</label>
<div class="col-md-8">
<select class="form-control required" id="designation_id" name="designation_id">
<option value="">--- Select ---</option>
<?php if($parent_desi) {?>
<?php foreach($parent_desi as $parent) {?>
	<option value="<?php echo $parent['designation_id'];?>" <?php if($parent['designation_id']==$row['designation_id']){ echo 'selected="selected"';}?> ><?php echo $parent['designation_name'];?></option> 
    <?php $childs= $this->settings_model->get_active_designation($parent['designation_id']); ?>
    <?php if($childs) {?>
	<?php foreach($childs as $child) {?>
    	<option value="<?php echo $child['designation_id'];?>" <?php if($child['designation_id']==$row['designation_id']){ echo 'selected="selected"';}?>><?php echo $parent['designation_name'];?>-><?php echo $child['designation_name'];?></option>
    <?php } ?>
    <?php } ?>

    
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>



<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Department*</label>
<div class="col-md-8">
<select class="form-control required" id="department_id" name="department_id">
<option value="">--- Select ---</option>
<?php if($parent_dept){?>
<?php foreach($parent_dept as $parent_d) {?>
	<!--<option value="<?php //echo $parent_d['department_id'];?>" <?php //if($parent_d['department_id']==$row['department_id']){ echo 'selected="selected"';}?> ><?php //echo $parent_d['department_name'];?></option>-->
    <optgroup label="<?php echo $parent_d['department_name'];?>">
    <?php $child_dept= $this->settings_model->get_active_department($parent_d['department_id']); ?>
    <?php if($child_dept) {?>
	<?php foreach($child_dept as $child_d) {?>
    	<option value="<?php echo $child_d['department_id'];?>" <?php if($child_d['department_id']==$row['department_id']){ echo 'selected="selected"';}?>><?php //echo $parent_d['department_name'];?><?php echo $child_d['department_name'];?></option>
    <?php } ?>
    <?php } ?>
	</optgroup>
    
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Work Location*</label>
<div class="col-md-8">
<select class="form-control required" id="location_id" name="location_id">
<option value="">--- Select ---</option>
<?php if($work_locations){?>
<?php foreach($work_locations as $loc) {?>
	<option value="<?php echo $loc['location_id'];?>" <?php if($loc['location_id']==$row['location_id']){ echo 'selected="selected"';}?>><?php echo $loc['location_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>
</div>

<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Managing Department(s)</strong></p>
<div class="row">
<div class="col-md-12">
<div class="form-group row">
<?php if($row['department_managed']!=""){ $department_managed=explode(',',$row['department_managed']); } ?>
<select class="form-control js-example-basic-multiple" id="department_managed" name="department_managed[]"  multiple="multiple">
<?php if($parent_dept){?>
<?php foreach($parent_dept as $parent_d) {?>
	 <optgroup label="<?php echo $parent_d['department_name'];?>">
    <?php $child_dept= $this->settings_model->get_active_department($parent_d['department_id']); ?>
    <?php if($child_dept) {?>
	<?php foreach($child_dept as $child_d) {?>
    	<?php if($child_d['department_id']!=$row['department_id']) {?>
    	<option value="<?php echo $child_d['department_id'];?>"
        <?php if($department_managed!=""){ if (in_array($child_d['department_id'], $department_managed)){ ?> selected="selected" <?php }} ?> 
        ><?php //echo $parent_d['department_name'];?><?php echo $child_d['department_name'];?></option>
        <?php } ?>
        
        
    <?php } ?>
    <?php } ?>
	</optgroup>
    
<?php } ?>
<?php } ?>
</select>

</div>
</div>

</div>


<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Managing Unit(s)</strong></p>
<div class="row">
<div class="col-md-12">
<div class="form-group row">
<?php $unit_managed=""; if($row['unit_managed']!=""){ $unit_managed=explode(',',$row['unit_managed']); } ?>
<select class="form-control js-example-basic-multiple required" id="unit_managed" name="unit_managed[]"  multiple="multiple">
<?php if($units){?>
<?php foreach($units as $unit) {?>
    	<option value="<?php echo $unit['production_unit_id'];?>" <?php if($unit_managed!=""){ if (in_array($unit['production_unit_id'], $unit_managed)){ ?> selected="selected" <?php }} ?> ><?php echo $unit['production_unit_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>

</div>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Login & Dashboard Details</strong></p>
<div class="row">

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Dashboard Category</label>
<div class="col-md-8">
<select class="form-control " id="dashboard_category" name="dashboard_category"  >
<option value="">--- Select ---</option>
<option value="PH" <?php if("PH"==$row['dashboard_category']){ echo 'selected="selected"';}?>>Production Head</option>
<option value="AD" <?php if("AD"==$row['dashboard_category']){ echo 'selected="selected"';}?>>ADMIN</option>
</select>
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
if ($(".js-example-basic-multiple").length) {
$(".js-example-basic-multiple").select2();
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