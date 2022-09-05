<div class="content-wrapper">
<div class="row">

<div class="col-md-6 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">Working Hours</h4>
<span id="responseData"></span>
<form class="forms-sample" id="workingHourForm">
<input type="hidden" name="system_master_id" id="system_master_id" value="<?php echo $row['system_master_id'];?>" />
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<div class="form-group row">
<div class="col">
<label>Hours</label>
<div id="">
<input class="form-control digits required"  name="working_hrs" id="working_hrs" type="number"   maxlength="2" min='7' max="11" value="<?php echo $row['wh_hrs'];?>">
</div>
</div>
<div class="col">
<label>Minitue</label>
<div id="">
<input class="form-control digits required"  name="working_min" id="working_min" type="number"   maxlength="2" min='0' max="60" value="<?php echo $row['wh_min'];?>">
</div>
</div>
</div>
<button type="submit" class="btn btn-primary mr-2"  id="submitDataa" name="submitDataa">Update</button>
</form>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
$("#workingHourForm").validate({
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
$("#submitDataa").attr("disabled", "disabled");
$('#submitDataa').html("Please Wait ...");
//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
$('#dateContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
$.post('<?= base_url("settings/save_wh/");?>', $("#workingHourForm").serialize(), function(data) {
		$('#responseData').html("");																							
	var dataRs = jQuery.parseJSON(data);
	$("#submitDataa").delay("slow").fadeIn();
	$('#submitDataa').html("Update");
	$('#submitDataa').removeAttr("disabled");
	$('#responseData').html(dataRs.responseMsg);
	//$( '#calenderData' ).each(function(){this.reset();});
	
});	
}
});
});
</script>





</div>
</div>
