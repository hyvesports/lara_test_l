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

<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('leads/index');?>">All Leads</a>

<a title="Tasks" class="btn btn-warning " target="_blank" href="<?php echo base_url('leads/task/'.$row['lead_uuid']);?>"><i class="fa fa-tasks"></i> Tasks</a></span> 

</h4>

<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Lead Details</strong></p>

<?php echo form_open(base_url('leads/edit/'.$row['lead_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>

<input type="hidden" name="lead_id" id="lead_id"  value="<?php echo $row['lead_id'];?>" />

<?php //print_r($row);?>







<div class="row">



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Date</label>

<div class="col-md-8">

<label>: <?php echo $row['lead_date'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Lead Source </label>

<div class="col-md-8">

<label>: <?php echo $row['lead_source_name'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Lead Type </label>

<div class="col-md-8">

<label>: <?php echo $row['lead_type_name'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Lead Category </label>

<div class="col-md-8">

<label>: <?php echo $row['lead_cat_name'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Lead Stage </label>

<div class="col-md-8">

<label>: <?php echo $row['lead_stage_name'];?></label>

</div>

</div>

</div>

<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Estimate order value</label>

<div class="col-md-8">

<label>: <?php echo $row['lead_info'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Sports Type </label>

<div class="col-md-8">

<label>:

 <?php 

 if($lead_sports_types){

	 $inc=0;

	foreach($lead_sports_types as $ls){ 

	 	if($inc==0) { $sp=$ls['sports_type_name']; }else{ $sp.=','. $ls['sports_type_name']; }

	}

	echo $sp; 

}?></label>

</div>

</div>

</div>





<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 ">Description </label>

<div class="col-md-10">

<label>: <?php echo $row['lead_desc'];?></label>

</div>

</div>

</div>



<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 ">Remark </label>

<div class="col-md-10">

<label>: <?php echo $row['lead_remark'];?></label>

</div>

</div>

</div>





<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 ">Lead Attachment </label>

<div class="col-md-10">

<label>: <a href="<?php echo base_url() ?>uploads/leads/<?php echo $row['lead_attachment'];?>" target="_blank"><?php echo $row['lead_attachment'];?></a></label>

</div>

</div>

</div>





</div>



<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Lead Client / Company Details</strong></p>



<div class="row">



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Name </label>

<div class="col-md-8">

<label>: <?php echo $row['customer_name'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Email</label>

<div class="col-md-8">

<label>: <?php echo $row['customer_email'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Phone</label>

<div class="col-md-8">

<label>: <?php echo $row['customer_mobile_no'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Website</label>

<div class="col-md-8">

<label>: <a href="<?php echo $row['customer_website'];?>" target="_blank"><?php echo $row['customer_website'];?></a></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">Country</label>

<div class="col-md-8">

<label>: <?php echo $row['country'];?></label>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">State</label>

<div class="col-md-8">

<label>: <?php echo $row['state'];?></label>

</div>

</div>

</div>





<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 ">City</label>

<div class="col-md-8">

<label>: <?php echo $row['city'];?></label>

</div>

</div>

</div>





<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 ">Social Media Profiles</label>

<div class="col-md-10">

<?php if($row['customer_social_media_links']!="") {  $json_decode=json_decode($row['customer_social_media_links'],true); ?>

<?php foreach($json_decode as  $key => $value){ ?>

<label><?php echo ucwords($key);?> : <a href="<?php echo $value;?>" target="_blank"><?php echo $value;?></a></label><br/>

<?php } ?>

<?php } ?>

</div>

</div>

</div>























</div>



<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Lead Owner</strong></p>





<div class="row">



<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 ">Staff Code & Name</label>

<div class="col-md-10">

<label>: <?php echo $row['staff_code'];?>,<?php echo $row['staff_name'];?></label>

</div>

</div>

</div>

</div>







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