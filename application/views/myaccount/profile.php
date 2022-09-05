<div class="content-wrapper">
<div class="row profile-page">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">My Account</h4>
<div class="row ml-md-0 mr-md-0 vertical-tab tab-minimal">
<ul class="nav nav-tabs col-md-2 justify-content-between" role="tablist">
<li class="nav-item">
<a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#dashboard-2-1" role="tab" aria-controls="dashboard-2-1" aria-selected="true"><i class="fa fa-lock"></i>Change Password</a>
</li>
</ul>
<div class="tab-content col-md-10">
<div class="tab-pane fade show active" id="dashboard-2-1" role="tabpanel" aria-labelledby="tab-2-1">
<div class="row">

<div class="col-md-8 offset-md-1">
	<span id="responseAction"></span>
    <form class="forms-sample" id="dataForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="form-group row">
    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Old Password <span class="text-danger">*</span></label>
    <div class="col-sm-9">
    <input type="password" id="old_pwd" name="old_pwd" class="form-control required" maxlength="50" minlength="1" placeholder="Old Password">
    </div>
    </div>
    <div class="form-group row">
    <label for="exampleInputPassword2" class="col-sm-3 col-form-label">New Password <span class="text-danger">*</span></label>
    <div class="col-sm-9">
    <input type="password" id="new_pwd" name="new_pwd" class="form-control required"   maxlength="50" minlength="4" placeholder="New Password">
    </div>
    </div>
    <div class="form-group row">
    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Re New Password <span class="text-danger">*</span></label>
    <div class="col-sm-9">
    <input type="password" id="c_pwd" name="c_pwd" class="form-control required"   maxlength="50" minlength="4" equalTo='#new_pwd' placeholder="Re New Password">
    </div>
    </div>
    
    <button type="submit" class="btn btn-primary mr-2" id="submitData" name="submitData" value="Change Password">Change Password</button>
    <button class="btn btn-light">Cancel</button>
    </form>


</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
$("#dataForm").validate({
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
//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
$.post('<?= base_url("myaccount/update_pwd/");?>', $("#dataForm").serialize(), function(data) {
	var dataRs = jQuery.parseJSON(data);

	$("#submitData").delay("slow").fadeIn();
	$('#submitData').html("Change Password");
	$('#submitData').removeAttr("disabled");
	$('#responseAction').html(dataRs.responseMsg);
	$( '#dataForm' ).each(function(){this.reset();});
	
});	
}
});
});
</script>