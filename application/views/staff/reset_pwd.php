<?php //print_r($_POST);?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">x</span>
</button>
</div>
<div class="modal-content">

<div class="modal-body">
<div class="card-body">
                  <h4 class="card-title">Reset Password</h4>
                 <span id="action_resp"></span>
                  <form class="forms-sample" action="" id="saveStatus">
                  <input type="hidden" name="slid" id="slid" value="<?php echo $_POST['slid'];?>" />
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">New Password</label>
                       <input type="text" name="new_pwd" id="new_pwd"  class="form-control required" maxlength="50" minlength="4" />
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="Submit" value="Submit" id="Submit">Submit</button>
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
</div>
</div>

<script type="text/javascript">
$(function() {
	

	
	$("#saveStatus").validate({
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
	//$("#submitDataModel").attr("disabled", "disabled");
	$('#Submit').html("Please Wait ...");
	//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
	//$('#modelResp').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
	$.post('<?= base_url("staff/save_resetpwd/");?>', $("#saveStatus").serialize(), function(data) {
																								
		//window.location.reload();  
		var dataRs = jQuery.parseJSON(data);
		$('#Submit').html("Submit");
		$('#action_resp').html(dataRs.responseMsg)
		$( '#saveStatus' ).each(function(){this.reset();});
		
	});	
	}
	});	

});
</script>


