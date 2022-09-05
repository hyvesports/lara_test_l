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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('staff/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Add New Staff</strong></p>
<?php echo form_open(base_url('staff/add'), 'class="cmxform"  id="dataform" method="post"'); ?>



<div class="row">
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Staff Code*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="staff_code" id="staff_code" maxlength="50">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Staff Name*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="staff_name" id="staff_name" maxlength="100">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Email*</label>
<div class="col-md-8">
<input type="text" class="form-control required email" name="log_email" id="log_email" maxlength="100">
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Mobile No*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="log_phone_number" id="log_phone_number" maxlength="10" >
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
	<option value="<?php echo $parent['designation_id'];?>"><?php echo $parent['designation_name'];?></option>
    <?php $childs= $this->settings_model->get_active_designation($parent['designation_id']); ?>
    <?php if($childs) {?>
	<?php foreach($childs as $child) {?>
    	<option value="<?php echo $child['designation_id'];?>"><?php echo $parent['designation_name'];?>-><?php echo $child['designation_name'];?></option>
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
<select class="form-control required" id="department_id" name="department_id" >
<option value="">--- Select ---</option>
<?php if($parent_dept){?>
<?php foreach($parent_dept as $parent_d) {?>
	<!--<option value="<?php //echo $parent_d['department_id'];?>" disabled="disabled"><?php //echo $parent_d['department_name'];?></option>-->
     <optgroup label="<?php echo $parent_d['department_name'];?>">
    <?php $child_dept= $this->settings_model->get_active_department($parent_d['department_id']); ?>
    <?php if($child_dept) {?>
	<?php foreach($child_dept as $child_d) {?>
    	<option value="<?php echo $child_d['department_id'];?>"><?php //echo $parent_d['department_name'];?><?php echo $child_d['department_name'];?></option>
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
	<option value="<?php echo $loc['location_id'];?>"><?php echo $loc['location_name'];?></option>
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
<select class="form-control js-example-basic-multiple" id="department_managed" name="department_managed[]"  multiple="multiple">

<?php if($parent_dept){?>
<?php foreach($parent_dept as $parent_d) {?>
	 <optgroup label="<?php echo $parent_d['department_name'];?>">
    <?php $child_dept= $this->settings_model->get_active_department($parent_d['department_id']); ?>
    <?php if($child_dept) {?>
	<?php foreach($child_dept as $child_d) {?>
    	<option value="<?php echo $child_d['department_id'];?>"><?php //echo $parent_d['department_name'];?><?php echo $child_d['department_name'];?></option>
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

<select class="form-control js-example-basic-multiple required" id="unit_managed" name="unit_managed[]"  multiple="multiple">


    <?php if($units) {?>
	<?php foreach($units as $unit) {?>
    	<option value="<?php echo $unit['production_unit_id'];?>"><?php //echo $parent_d['department_name'];?><?php echo $unit['production_unit_name'];?></option>
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
<label class="col-md-4 col-form-label">Username*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="log_username" id="log_username" maxlength="50" onkeyup="chkstaffcode(this.value);">
<span id="coderesponse"></span>
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Password*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="log_password" id="log_password" maxlength="100" value="<?php echo $password;?>">
</div>
</div>
</div>


<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Dashboard Category</label>
<div class="col-md-8">
<select class="form-control " id="dashboard_category" name="dashboard_category"  >
<option value="">--- Select ---</option>
<option value="PH">Production Head</option>
<option value="AD">Admin</option>
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
function chkstaffcode(code){
	
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
	};
	$('#coderesponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
	$.ajax({
	type: "POST",
	 dataType: 'json',
	url: "<?= base_url("staff/chk_staff_logid/");?>"+code,
	data: post_data
	}).done(function(reply) {
		
		
		if(reply.responseCode=="exist"){
			$("#submit").attr("disabled", "disabled");
			$('#coderesponse').html("<p style='text-align:center; color:#F00;'>"+reply.responseMsg+"</p>");
		}else{
			$("#submit").removeAttr("disabled");
			$('#coderesponse').html("<p style='text-align:center; color:#090;'>"+reply.responseMsg+"</p>");
		}
		//$('#loadClientData').html(reply);
	});
}
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