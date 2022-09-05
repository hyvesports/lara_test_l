<style>
.drp-buttons{
	display:none;
}
</style>
<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">SCHEDULE Overview</h4>
<form action="post" id="scheduleInputForm" name="scheduleInputForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
    <div class="col-md-3">
    <label>Start Date <span class="text-danger">*</span></label>
     <input type="text" class="form-control required datepicker" name="start_date" id="start_date" readonly="readonly">
    </div>
    <div class="col-md-3">
    <label>End Date <span class="text-danger">*</span></label>
     <input type="text" class="form-control required datepicker" name="end_date" id="end_date"  readonly="readonly" >
    </div>
    
     <div class="col-md-3">
    <label>Production Unit</label>
    <?php if($punits) {?>
    <select class="form-control required"  id="unit_id" name="unit_id"   > 
    <option value="">--- Select ---</option>
    <?php foreach($punits as $UN){ ?>
    <option value="<?php echo $UN['production_unit_id'];?>"><?php echo $UN['production_unit_name'];?></option>
    <?php } ?>
    </select>
    <?php } ?>
    </div>
    <div class="col-md-3"> <button type="submit" style="margin-top:30px;"  class="btn btn-info" id="submitData" name="submitData">Show Schedule Data</button>
    </div>
    </div>
    </form>
</div>
</div>
</div>
</div>


<div class="card" id="scheduleContent">

</div>


</div>

<script>

</script>
<script type="text/javascript">
$(document).ready(function() {
$('.datepicker').datepicker({
autoclose: true,
format: 'yyyy-mm-dd',

});
	
$('[data-toggle="tooltip"]').tooltip();				   
						   
$("#scheduleInputForm").validate({
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
$('#submitData').html("<i class='fa fa-spin fa-spinner'></i> Please Wait ...");
$('#scheduleContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
$.post('<?= base_url("orders/overview_result/");?>', $("#scheduleInputForm").serialize(), function(data) {
	$("#scheduleContent").html(data);
	$('#submitData').html("Check Availability & Schedule");
	
});	
}
});
});
</script>
