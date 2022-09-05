<div class="modal-body"  >
<div class="card-body">
<h4 class="card-title">Update Order Status</h4>
<span id="action_resp"></span>
<form name="updateStatusForm" id="updateStatusForm">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="schedule_department_id" id="schedule_department_id" value="<?php echo $schedule_data['schedule_department_id'];?>" />

<?php //print_r($schedule_data); ?>
<?php
$approved_summary_id_array=explode(',',$schedule_data['approved_summary_id']);
?>

<?php $arrayJson = json_decode($schedule_data['scheduled_order_info'],true); ?>

<?php if($arrayJson){ $k=0; ?>
<div class="list-wrapper">
<ul class="d-flex flex-column-reverse todo-list">
	<?php foreach($arrayJson as $jKey => $jValue){  ?>
    <?php if(!in_array($jValue['summary_id'],$approved_summary_id_array)){ ?>
    <input type="hidden" name="submitItems[<?php echo $k;?>][summary_id]" value='<?php echo ucwords($jValue['summary_id']);?>' />
    <li class="completed">
    <div class="form-check"><i class="fa fa-check-circle"></i>
    <label class=""><?php echo ucwords($jValue['product_type']);?> <em></em></label>
    </div>
    </li>
    <?php $k++;  } ?>
    <?php }?>

</ul>
</div>
<?php } ?>
<?php //echo $k;?>

<div class="form-group">
<label for="exampleInputUsername1">Status <span class="text-danger">*</span></label>
<select class="form-control required" id="schedules_status_id" name="schedules_status_id">
<?php if($schedule_status){ ?>
<option>--- Select ---</option>
<?php foreach($schedule_status as $SS){ ?>
<option value="<?php echo $SS['schedules_status_id'];?>"><?php echo $SS['schedules_status_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
<div class="form-group">
<label for="exampleInputEmail1">Remark</label>
<input type="text" class="form-control" id="schedules_status_remark"  name="schedules_status_remark" maxlength="500">
</div>
<?php if($k!=0){ ?>
<button type="submit" class="btn btn-primary mr-2" id="submitData" name="submitData" value="Submit">Submit</button>
<?php } ?>
</form>
</div>
</div>  
<script type="text/javascript">
$(function() {
	
	$('#orderSummary').on('hidden.bs.modal', function () {
    	location.reload();
		//_________________________________________
	});
	
	$("#updateStatusForm").validate({
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
	//$("#submitData").attr("disabled", "disabled");
	$('#submitData').html("Please Wait ...");
	//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
	//$('#modelResp').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
	$.post('<?= base_url("myaccount/save_order_response/");?>', $("#updateStatusForm").serialize(), function(data) {
																								
		var dataRs = jQuery.parseJSON(data);
		//$("#submitData").delay("slow").fadeIn();
		//$('#submitData').html("Save");
		//$('#submitData').removeAttr("disabled");
		$('#action_resp').html(dataRs.responseMsg)
		$( '#updateStatusForm' ).each(function(){this.reset();});
		
	});	
	}
	});	

});
</script> 