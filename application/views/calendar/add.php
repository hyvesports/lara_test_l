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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('calendar/index');?>">List</a></span> 
</h4>
	<form action="post" id="dateInputForm" name="dateInputForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
    <div class="col-md-4">
    <label>Year <span class="text-danger">*</span></label>
    <select class="form-control required" id="calendar_year" name="calendar_year" > 
    <option value="">--- Select ---</option>
   	<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
    <option value="<?php echo date('Y', strtotime('+1 year')); ?>"><?php echo date('Y', strtotime('+1 year')); ?></option>
    </select>
    </div>
    <div class="col-md-4">
    <label>Month <span class="text-danger">*</span></label>
    <select class="form-control required" id="calendar_month" name="calendar_month"> 
    <option value="">--- Select ---</option>
    <option value='01'>Janaury</option>
    <option value='02'>February</option>
    <option value='03'>March</option>
    <option value='04'>April</option>
    <option value='05'>May</option>
    <option value='06'>June</option>
    <option value='07'>July</option>
    <option value='08'>August</option>
    <option value='09'>September</option>
    <option value='10'>October</option>
    <option value='11'>November</option>
    <option value='12'>December</option>

    </select>
    </div>
    <div class="col-md-2"> <button type="submit" style="margin-top:30px;"  class="btn btn-info" id="submitData" name="submitData">Load Dates</button>
    </div>
    </div>
    </form>
</div>
</div>


</div>
</div>
<span id="dateContent2"></span>
<span id="dateContent">

<div class="row">
<div class="col-12">
<div class="card">

</div>
</div>
</div>
</span>


</div>
<script type="text/javascript">
$(document).ready(function() {
$("#dateInputForm").validate({
highlight: function(element) {
$(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
},
unhighlight: function(element) {
$(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
},
errorElement: 'p',
errorClass: 'text-danger',
errorPlacement: function(error, element) {
if (element.parent('.input-group').length || element.parent('label').length) {
error.insertAfter(element.parent());
} else {
error.insertAfter(element);
}
},
submitHandler: function() {
//$("#loginAccount").attr("disabled", "disabled");
$('#submitData').html("Please Wait ...");
$('#dateContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
$.post('<?= base_url("calendar/load_dates/");?>', $("#dateInputForm").serialize(), function(data) {
	
	$("#dateContent").html(data);
	$('#submitData').html("Load Dates");
	
});	
}
});
});
</script>
